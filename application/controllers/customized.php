<?php

class Ccustomized extends application {

    function hotel_la_molina($idtab="1") {

        switch ($idtab) {
            default:
                $fbappid = "111814125595831";
                $fbsecret = "2892cef19dd95f91af5e76068d190014";
                $fbapikey = "1bfc4fa20ad03bb854593f9a7f3953e6";
                $this->loadView("customized/hotellamolina/hotellamolina.php", $this->params);
        }
    }

    private function auxfbconexion1($pag=1, $cat="") {
        $db = $this->dbInstance();
        if ($cat == "" || $cat == 0) {
            //se listan los ID por orden de update
            $sql = "select distinct idpagina from #_tab b inner join #_usuario a on a.uid=b.uid where a.partner like '%' and concat(a.firstname,' ',a.lastname) like '%%' order by fechapub desc limit " . (($pag - 1) * 5) . ",5";
            $res1 = $db->loadObjectList($sql);
            //se listan los nombres
            $ids = "";
            if (count($res1) == 0)
                return false;
            foreach ($res1 as $r) {
                $ids.=',' . $r->idpagina;
            }
            $ids = substr($ids, 1);
            $fql = "select page_id, name, page_url from page where page_id in ($ids)";
            $res2 = $this->fb->fqlQuery($fql);
            //se ordena la lista y se concatena
            $lista = array();
            foreach ($res1 as $r1) {
                foreach ($res2 as $r2) {
                    if ($r1->idpagina == $r2["page_id"]) {
                        $r2["fechapub"] = $r1->fechapub;
                        $lista[] = $r2;
                        break;
                    }
                }
            }
            return $lista;
        } else {
            $res1 = $db->loadResult("select distinct GROUP_CONCAT(idpagina) from #_tab");
            $fql = "select page_id, name, page_url from page where page_id in ($ids) and type='" . mysql_escape_string($cat) . "' limit " . (($pag - 1) * 5) . ",5";
            $res2 = $this->fb->fqlQuery($fql);
            return $res2;
        }
    }

    private function auxfbconexion2($paginas) {
        $cad = '';
        if (count($paginas) > 0 && $paginas) {
            foreach ($paginas as $p) {
                $cad.='
                <div class="filaestrella">
                    <div class="cuadrocomments">
                        <fb:like href="' . $p["page_url"] . '" send="false" layout="button_count" width="110" show_faces="false"></fb:like>
                    </div>
                    <a target="_BLANK" href="' . $p["page_url"] . '">' . $p["name"] . '</a>
                </div>
                ';
            }
        }
        else
            $cad = '
                <script type="text/javascript">
                    $("#linkvermaspag").hide();
                </script>';
        return $cad;
    }

    function fbconexion($idtab) {
        $fbappid = "192946747453023";
        $fbsecret = "c9c6f1ff7274d3dbe52dea61db45a84c";
        $fbapikey = "91cb6eedff138b6cb274d64dc3b58544";
        $this->params["fbcred"] = $this->loadConfig("fb");


        $lang = $_SESSION["lang"];
        $db = $this->dbInstance();
        switch ($idtab) {
            case 1:
                //pantalla de inicio
                $sql = "SELECT 
                        CEIL((avg(preg1)+avg(preg2)+avg(preg3)+avg(preg4)+avg(preg5))/5) as promedio, 
                        CEIL(avg(preg1)) as preg1,
                        CEIL(avg(preg1)) as preg2,
                        CEIL(avg(preg1)) as preg3,
                        CEIL(avg(preg1)) as preg4,
                        CEIL(avg(preg1)) as preg5
                        FROM fbc_encuesta";
                $res = $db->loadObjectRow($sql);
                $this->params["promedio_final"] = $res->promedio;
                $this->params["teq"] = $res;

                $aux = $this->auxfbconexion1();
                $this->params["paginas"] = $this->auxfbconexion2($aux);

                $res = $db->loadResult("select distinct GROUP_CONCAT(idpagina) from #_tab");
                $cats = $this->fb->fqlQuery("select type from page where page_id in ($res)");
                $this->params["cats"] = array();
                foreach ($cats as $c) {
                    if (!in_array($c["type"], $this->params["cats"])) {
                        $this->params["cats"][] = $c["type"];
                    }
                }
                $this->loadView("customized/fbconexion/home_$lang.php", $this->params);
                break;
            case 2:
                //para listar las paginas
                $cat = mysql_escape_string($_POST["cat"]);
                $pag = intval($_POST["pag"]);

                $aux = $this->auxfbconexion1($pag, $cat);
                echo $this->auxfbconexion2($aux);

                break;
            case 3:
                //las preguntas de fbconexion
                $secret = $this->_parse_signed_request($_REQUEST["signed_request"], "14122c4b1efc49b879a2d23056431d05");
                //print_r($secret);
                if ($secret["page"]["id"] == "285369954810369") {
                    //latinoamerica
                    define("LANG", "es/");
                    $_SESSION["lang"] = "es";
                } else {
                    define("LANG", "/");
                    $_SESSION["lang"] = "en";
                }
                $db->debug(2);
                $sql = "
                    select a.*,unix_timestamp(a.fecha) as fecha2,(preg1+preg2+preg3+preg4+preg5)/5 as promedio,b.firstname,b.lastname from #_encuesta a
                    inner join #_usuario b on a.uid collate utf8_unicode_ci=b.uid
                    where a.idioma='" . $_SESSION["lang"] . "' and trim(comentario)!=''";
                $this->params["res"] = $db->loadObjectList($sql);
                $this->loadView("customized/fbconexion/comentarios.php", $this->params);
                break;
            case 4:
                //el blog
                $fbappid = "194757327280771";
                $fbsecret = "aadba6ce8b80d35d4bda37fa2ccb0c4e";
                $fbapikey = "de1d25a4eaf89ea11ae60e422b309ff0";
                $secret = $this->_parse_signed_request($_REQUEST["signed_request"], $fbsecret);
                if ($secret["page"]["id"] == "285369954810369") {
                    define("LANG", "es/");
                    $_SESSION["lang"] = "es";
                    $blog = $this->getURL("blog/es/feed");
                } else {
                    define("LANG", "/");
                    $_SESSION["lang"] = "en";
                    $blog = $this->getURL("blog/feed");
                }
                $db->debug(2);
                include realpath("widgets/rss/rayfeedreader.php");
                include realpath("widgets/rss/rayfeedwidget.php");
                $opciones = array(
                    'url' => $blog,
                        //'widget' => 'RayFeedWidget',
                );
                $reader1 = RayFeedReader::getInstance()->setOptions($opciones)->parse();
                $this->params["datos"] = $reader1->getData();
                $this->loadView("customized/fbconexion/blog.php", $this->params);
                break;
            case 5:
                //planes
                $fbappid = "145042652271489";
                $fbsecret = "704fb0dca93bbe46cca5181db3a86ff7";
                $fbapikey = "d3fa7a678c8442eafb466c4c547dc63d";
                $secret = $this->_parse_signed_request($_REQUEST["signed_request"], $fbsecret);
                if ($secret["page"]["id"] == "285369954810369") {
                    define("LANG", "es/");
                    $_SESSION["lang"] = "es";
                } else {
                    define("LANG", "/");
                    $_SESSION["lang"] = "en";
                }
                $this->loadView("customized/fbconexion/plans_" . $_SESSION["lang"] . ".php", $this->params);
                break;
            case 6:
                //newsletter
                $fbappid = "165906066853430";
                $fbsecret = "d4f41243eb6fdf5f97c1cd465853e770";
                $fbapikey = "3b984e948519607e534571638b98718e";
                if ($secret["page"]["id"] == "285369954810369") {
                    define("LANG", "es/");
                    $_SESSION["lang"] = "es";
                } else {
                    define("LANG", "/");
                    $_SESSION["lang"] = "en";
                }
                $this->loadView("customized/fbconexion/newsletter_" . $_SESSION["lang"] . ".php", $this->params);
                break;
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
