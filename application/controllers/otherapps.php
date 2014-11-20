<?php

class Cotherapps extends application {

    function __construct() {
        parent::__construct();
    }

    function comments() {
        if (LANG == "es/") {
            $this->params["fbcred"]["id"] = "318381378180164";
            $this->params["fbcred"]["apikey"] = "30e66dc92a05ff49ae84bf0ca601b3aa";
            $this->params["fbcred"]["appsecret"] = "7fc954d5f555f32942d77f6453e80e98";
        } else {
            $this->params["fbcred"]["id"] = "325391304140530";
            $this->params["fbcred"]["apikey"] = "15528ff913368d8ed8ee218f1ed0c7cf";
            $this->params["fbcred"]["appsecret"] = "7c1b684229b4e9535ab37ae8ffab058d";
        }

        $db = $this->dbInstance();
        $db->debug(2);
        if (!$_POST["signed"]) {
            $secret = $this->_parse_signed_request($_REQUEST["signed_request"], $this->params["fbcred"]["appsecret"]);

            if ($secret["page"]["id"] == "") {
                echo 'This is the <strong>"' . $_SESSION["lang"] . '"</strong> version, to install click <a href="http://facebook.com/add.php?api_key=' . $this->params["fbcred"]["apikey"] . '&pages=1&page=your_page" target="_blank">here</a><br/>';
                exit;
            }
            $fql = "select name,page_url from page where page_id=" . $secret["page"]["id"];
            $res = $this->fb->fqlQuery($fql);
            $this->params["pageurl"] = $res[0]["page_url"] . "?sk=app_" . $this->params["fbcred"]["id"];

            $sql = "select a.*,unix_timestamp(a.fecha) as fecha2 from fbc_appcomments a where idpag = '" . $secret["page"]["id"] . "' order by id desc";
            //$sql = "select a.*,unix_timestamp(a.fecha) as fecha2 from fbc_appcomments a order by id desc";
            $this->params["res"] = $db->loadObjectList($sql);
            $this->params["isadmin"]=$secret["page"]["admin"];
            
            $this->loadView("appcomentarios.php", $this->params);
        } else {
            $secret = $this->_parse_signed_request($_POST["signed"], $this->params["fbcred"]["appsecret"]);

            if ($_POST["txt1"] && $_POST["txt2"] && !$_POST["idc"]) {
                //agregar contenido
                if ($secret["page"]["id"] == "") {
                    echo 'This is the <strong>"' . $_SESSION["lang"] . '"</strong> version, to install click <a href="http://facebook.com/add.php?api_key=' . $this->params["fbcred"]["apikey"] . '&pages=1&page=your_page" target="_blank">here</a><br/>';
                    exit;
                }
                $db->insert("#_appcomments", array(
                    "uid" => strip_tags($_POST["txt2"]),
                    "descripcion" => strip_tags($_POST["txt1"]),
                    "idpag" => $secret["page"]["id"],
                    "fecha" => date("Y-m-d H:i:s")
                ));
                switch ($secret["page"]["id"]){
                    case "215585355132778":
                        $email="danichalay@yahoo.es";
                        $asunto="Un nuevo comentario - tresdosuno";
                        break;
                    case "171408762881570":
                        $email="info@fbconexion.com";
                        $asunto="New Comment - Hotel La Molina";
                        break;
                }
                if($email){
                    $body='
                        <table>
                            <tr><th>Comment:</th><td>'.  strip_tags($_POST["txt1"]).'</td></tr>
                            <tr><th>Date:</th><td>'.date("Y-m-d H:i:s").'</td></tr>
                        </table>';
                    
                    $Mail = $this->loadLib("phpmailer");
                    $Mail->From = "info@fbconexion.com";
                    $Mail->FromName = "FB Conexion";
                    $Mail->AddAddress($email);
                    $Mail->AddReplyTo($Mail->From);
                    $Mail->Subject = $asunto;
                    $Mail->IsHTML(true);
                    $Mail->Body = utf8_decode($body);
                    $Mail->Send();
                }
            }
            else{
                //eliminar contenido
                if($secret["page"]["admin"]=="1"){
                    //solo administradores pueden ver el contenido
                    $db->delete("#_appcomments", "id=".  intval($_POST["idc"]." and idpag=".$secret["page"]["id"]));
                }
            }
        }
    }

    function _parse_signed_request($signed_request, $secret) {
        list($encoded_sig, $payload) = explode('.', $signed_request, 2);

        // decode the data
        $sig = base64_decode(strtr($encoded_sig, '-_', '+/'));
        $data = json_decode(base64_decode(strtr($payload, '-_', '+/')), true);

        if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') {
            error_log('Unknown algorithm. Expected HMAC-SHA256');
            return null;
        }

        // check sig
        $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
        if ($sig !== $expected_sig) {
            error_log('Bad Signed JSON signature!');
            return null;
        }

        return $data;
    }

}

?>
