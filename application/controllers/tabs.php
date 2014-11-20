<?php

class Ctabs extends application {

    function debug($variable) {
        echo '<pre>';
        print_r($variable);
        echo '</pre>';
    }

    function index($idapp) {
        $db = $this->dbInstance();
        $db->debug(2);
        //desencripto la respuesta
        $sql = "select appsecret,appid from #_aplicacion where id=" . intval($idapp);
        $appres = $db->loadObjectRow($sql);
        $secret = $this->_parse_signed_request($_REQUEST["signed_request"], $appres->appsecret);
        //$this->debug($secret);
        $this->params["secret"] = $secret;
        $this->params["appid"] = $appres->appid;
        $this->params["liked"] = $secret["page"]["liked"];
        //autentico la pag
        $sql = "select id,estructura_pub as estructura,uid,settings_pub, settings as set1,espublicado,espremium from #_tab where idapp=$idapp and idpagina='" . $secret["page"]["id"] . "' order by fechapub desc";
        $res = $db->loadObjectList($sql);
        if (count($res) > 0) {
            $estructura = $res[0]->estructura;
            $this->params["settings"] = json_decode(rawurldecode($res[0]->settings_pub));
            $sql = "select count(*) from #_plan_pagina inner join #_tab on #_tab.idpagina=#_plan_pagina.id_pagina where #_tab.id=" . $res[0]->id;
            if ($db->loadResult($sql) > 0) {
                $sqlpremium = "select a.trialcode,if(a.tienetrial and curdate()<trialfechafin,'1','0') as havetrial,if(a.tienetrial and curdate()<trialfechafin,trialplan,if(curdate()<(select c.fecha_fin from #_pagos c where c.idusuario='" . $res[0]->uid . "' order by id desc limit 1),a.plan,1)) as plan from #_usuario a where a.uid='" . $res[0]->uid . "'";
                $trial = $db->loadObjectRow($sqlpremium);
                if ($trial->havetrial == 1 && ($trial->trialcode == "WELCOMEFANS" || $trial->trialcode == "INTROFB") && $res[0]->uid != "100003092180077")
                    $this->params["showbrand"] = true;
                $this->params["espremium"] = $trial->plan;
            } else {
                $this->params["espremium"] = 1;
            }
            $this->params["idtab"] = $res[0]->id;
            $this->params["admin"] = $secret["page"]["admin"];
            $this->params["idadmin"] = $res[0]->uid;
            //$contenido=preg_replace('/\<div class=\"wm_editor wm{1,2}[0-9]" id="(.*)"/', $replacement, $subject);
            $this->params["estructura"] = $estructura;
            //$sql="select * from #_widgetprod where marca in ('".str_replace(",","','",$estructura)."')";

            $inicio = "select * from #_widgetprod where marca = '";
            $fin = "' ";
            $sql = $inicio . str_replace(",", $fin . " union " . $inicio, $estructura) . $fin;

            $this->params["widgets"] = $db->loadObjectList($sql);
            $this->params["scripts"][] = "swfobject.js";
            $this->params["scripts"][] = "canvas.js";
            $this->params["scripts"][] = "jquery.shape.js";
            if ($idapp != 10)
                $this->loadHtml("devpage.php", $this->params);
            else {
                $this->params["tab"] = $res[0];
                $this->params["escupon"] = true;
                $this->loadHtml("devcoupon.php", $this->params);
            }
        } else {
            $this->loadHtml("nopage.php");
        }
    }

    function pagcoupon1($idtab) {
        $db = $this->dbInstance();
        $sql = "select * from #_coupon where idtab=" . $idtab . " and numprints<if(numcoupons=0 or numcoupons is null,999999999,numcoupons)";
        $this->params["cupones"] = $db->loadObjectList($sql);
        $this->params["escupon"] = true;
        $this->loadView("coupon_listado.php", $this->params);
    }

    function pagcoupon2($idcoupon) {
        $db = $this->dbInstance();
        $sql = "select *,date_format(enddate,'%M %D, %Y') as fechatext from #_coupon where id=" . intval($idcoupon);
        $this->params["coupon"] = $db->loadObjectRow($sql);
        $this->loadView("coupon_detalle.php", $this->params);
    }

    function printcoupon($idc) {
        $db = $this->dbInstance();
        $sql = "update #_coupon set numprints=numprints+1 where id=" . intval($idc);
        $db->setQuery($sql);
        $db->query();
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

    function loadHtml($view = "", $params = array()) {
        //pasarle los parametros por defecto para estilos y scripts
        $x = new config();
        $x->loadFile(CONFIG_PATH);
        $defecto["scripts"] = array(
            "http://www.fbconexion.com/onlineco/js/jquery-1.4.4.min.js",
            "http://www.fbconexion.com/js/jQuery.gradient.js",
        );
        $defecto["css"] = array(
        );
        $defecto["config"] = $x->item("site");
        $defecto["tripas"] = $this->destripar();
        $params = $this->mergeVars($defecto, $params);
        $this->loadView("page_header.php", $params);
        if ($view)
            $this->loadView($view, $params);
        $this->loadView("page_footer.php", $params);
    }

    //picasa ausiliar
    function picasaAux($username, $album, $tipo, $pkey="") {
        if ($pkey != "")
            $pkey = "?authkey=" . $pkey;
        $url = "http://picasaweb.google.com/data/feed/api/user/$username/album/$album$pkey";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);

        $c = curl_exec($ch);
        curl_close($ch);
    }

    ///pa los picasa el parser
    function picasa1($username, $album, $tipo, $pkey="") {

        $c = file_get_contents($this->getURL("tabs/picasaAux/$username/$album/$tipo/$pkey"));
        $c = str_replace("media:content", "media_content", $c);
        $c = str_replace("media:description", "media_description", $c);
        $DOM = new DOMDocument('1.0', 'utf-8');
        $DOM->loadXML($c);
        $entradas = $DOM->getElementsByTagName('entry');

        switch ($tipo) {
            case 0://el que hice, en forma de json
                for ($i = 0; $i < $entradas->length; $i++) {
                    $e = $entradas->item($i);
                    $img = $e->getElementsByTagName("media_content")->item(0)->getAttribute("url");
                    $desc = $e->getElementsByTagName("media_description")->item(0)->nodeValue;
                    $result[] = array("src" => $img, "title" => nl2br($desc));
                }
                echo json_encode($result);
                break;
            case 1://en xml
                echo '<?xml version="1.0" encoding="UTF-8"?>';
                echo '<gallery>';
                echo '    <album id="ssp" lgPath="" tnPath="" title="Default Album" description="" tn="">';
                for ($i = 0; $i < $entradas->length; $i++) {
                    $e = $entradas->item($i);
                    $img = $e->getElementsByTagName("media_content")->item(0)->getAttribute("url");
                    $desc = $e->getElementsByTagName("media_description")->item(0)->nodeValue;
                    echo '<img src="' . $img . '" title="Description:" caption="' . nl2br($desc) . '" link="" target="_blank" pause="" vidpreview="" />';
                }
                echo '    </album>';
                echo '</gallery>';
                break;
        }
    }

    ///pa los widgets el xml1
    function galeria2_xml1($id, $username="", $picasa_album="") {
        $db = $this->dbInstance();
        $sql = "select * from #_widgetprod where marca='" . str_replace("'", "", $id) . "'";
        $r = $db->loadObjectRow($sql);
        $m = json_decode(rawurldecode($r->estructura));
        echo '<?xml version="1.0" encoding="UTF-8"?>';
        echo '<params>';
        echo '<customParams sspWidth="' . ($r->width ? $r->width : "520") . '" sspHeight="' . ($r->width ? $r->width : "520") . '" />';
        echo '<nativeParams albumBackgroundAlpha="1"
                albumBackgroundColor="0x999999"
                albumDescColor="0xCCCCCC"
                albumDescSize="9"
                albumPadding="8"
                albumPreviewScale="Proportional"
                albumPreviewSize="54,40"
                albumPreviewStrokeColor="0xFFFFFF"
                albumPreviewStrokeWeight="1"
                albumPreviewStyle="Inline Left"
                albumRolloverColor="0x262626"
                albumStrokeAppearance="Visible"
                albumStrokeColor="0x141414"
                albumTextAlignment="Left"
                albumTitleColor="0xFFFFFF"
                albumTitleSize="10"
                audioLoop="Off"
                audioPause="Off"
                audioVolume=".8"
                autoFinishMode="Switch"
                cacheContent="None"
                captionAppearance="Overlay Mouse Over (If Available)"
                captionBackgroundAlpha=".75"
                captionBackgroundColor="0x000000"
                captionHeaderAppearance="Image Count"
                captionPadding="5,5,5,5"
                captionPosition="Top"
                captionTextAlignment="Left"
                captionTextColor="0xffffff"
                captionTextSize="9"
                contentAlign="Center"
                contentAreaBackgroundAlpha="1"
                contentAreaBackgroundColor="0x000000"
                contentAreaStrokeAppearance="Visible"
                contentAreaStrokeColor="0x000000"
                contentFormat="Normal"
                contentFrameAlpha="1"
                contentFrameColor="0x000000"
                contentFramePadding="0"
                contentFrameStrokeAppearance="Hidden"
                contentFrameStrokeColor="0x333333"
                contentOrder="Sequential"
                contentScale="Downscale Only"
                directorLargeImageSettings="80,1,1"
                directorThumbImageSettings="50,1"
                displayMode="Auto"
                feedbackBackgroundAlpha=".4"
                feedbackBackgroundColor="0x000000"
                feedbackHighlightAlpha=".8"
                feedbackHighlightColor="0xFFFFFF"
                feedbackPreloaderAlign="Center"
                feedbackPreloaderAppearance="Pie"
                feedbackPreloaderPosition="Inside Content Area"
                feedbackScale="1"
                feedbackTimerAlign="Top Right"
                feedbackTimerAppearance="Visible"
                feedbackTimerPosition="Inside Content Area"
                galleryAppearance="Closed at Startup"
                galleryBackgroundAlpha="1"
                galleryBackgroundColor="0x1c1c1c"
                galleryColumns="2"
                galleryOrder="Left to Right"
                galleryPadding="10"
                galleryRows="4"
                galleryNavActiveColor="0x303030"
                galleryNavAppearance="Visible"
                galleryNavInactiveColor="0x000000"
                galleryNavRolloverColor="0x262626"
                galleryNavStrokeAppearance="Visible"
                galleryNavStrokeColor="0x141414"
                galleryNavTextColor="0xCCCCCC"
                galleryNavTextSize="9"
                iconInactiveAlpha=".4"
                iconShadowAlpha=".6"
                keyboardControl="On"
                mediaPlayerAppearance="Visible"
                mediaPlayerBackgroundAlpha=".25"
                mediaPlayerBackgroundColor="0x000000"
                mediaPlayerBufferColor="0x000000"
                mediaPlayerControlColor="0xFFFFFF"
                mediaPlayerElapsedBackgroundColor="0xFFFFFF"
                mediaPlayerElapsedTextColor="0x000000"
                mediaPlayerIconColor="0xCCCCCC"
                mediaPlayerPosition="Bottom"
                mediaPlayerProgressColor="0xCCCCCC"
                mediaPlayerScale=".8"
                mediaPlayerTextColor="0xEEEEEE"
                mediaPlayerTextSize="9"
                mediaPlayerVolumeBackgroundColor="0x000000"
                mediaPlayerVolumeHighlightColor="0xCCCCCC"
                navAppearance="Always Visible"
                navBackgroundAlpha="1"
                navBackgroundColor="0x121212"
                navButtonsAppearance="All Visible"
                navGradientAlpha=".3"
                navGradientAppearance="Glass Dark"
                navIconColor="0xEEEEEE"
                navLinkAppearance="Thumbnails"
                navLinkCurrentColor="0xEEEEEE"
                navLinkPreviewAppearance="Visible"
                navLinkPreviewBackgroundAlpha="1"
                navLinkPreviewBackgroundColor="0xFFFFFF"
                navLinkPreviewScale="Proportional"
                navLinkPreviewSize="80,60"
                navLinkPreviewStrokeWeight="1"
                navLinkRolloverColor="0xFFFFFF"
                navLinkSpacing="10"
                navLinksBackgroundAlpha="1"
                navLinksBackgroundColor="0x121212"
                navNumberLinkColor="0x999999"
                navNumberLinkSize="9"
                navPosition="Bottom"
                navThumbLinkBackgroundColor="0x666666"
                navThumbLinkInactiveAlpha="1"
                navThumbLinkShadowAlpha=".6"
                navThumbLinkSize="20,20"
                navThumbLinkStrokeWeight="1"
                permalinks="Off"
                smoothing="Off"
                soundEffects="None,None,None"
                textStrings="Previous Screen,Next Screen,Screen,of,No caption,No title"
                transitionDirection="Left to Right"
                transitionLength="2"
                transitionPause="4"
                transitionStyle="Cross Fade"
                typeface="Lucida Grande,Lucida Sans Unicode,Verdana,Arial,_sans"
                typefaceHead="Lucida Grande,Lucida Sans Unicode,Verdana,Arial,_sans"
                typefaceEmbed="Off"
                videoAutoStart="On"
                videoBufferTime="0.1"
                xmlFilePath="';
        if ($picasa_album == "")
            echo $this->getURL("/tabs/galeria2_xml2/$id/$username");
        else
            echo $this->getURL("picasa1/$username/$picasa_album/1");
        echo '" xmlFileType="Default" /> ';
        echo '</params>';
    }

    ///pa los widgets el xml2
    function galeria2_xml2($id, $username="") {
        $db = $this->dbInstance();
        $sql = "select * from #_widgetprod where marca='" . str_replace("'", "", $id) . "'";
        $r = $db->loadObjectRow($sql);
        $m = json_decode(rawurldecode($r->estructura));
        echo '<?xml version="1.0" encoding="UTF-8"?>';
        echo '<gallery>';
        echo '    <album id="ssp" lgPath="" tnPath="" title="Default Album" description="" tn="">';
        switch (preg_replace("/(w.[0-9]+)_.*/", "$1", $id)) {
            case "w21":
                if (count($m->edb_wc))
                    foreach ($m->edb_wc as $key => $i) {
                        echo '<img src="' . $i . '" title="Description:" caption="' . $m->edb_wd[$key] . '" link="" target="_blank" pause="" vidpreview="" />';
                    }
                break;
            case "w24":
                $username = $m->edb_w2;

                echo file_get_contents($this->getURL("widgets/flikr/inFlikr.php?username=$username&estilo=1"));
                break;
        }

        echo '    </album>';
        echo '</gallery>';
    }

    function processWContact() {
        if (count($_POST) > 0) {
            $body = "Contact Form of Your Tab: " . date("D F d, Y") . " at " . date("h:i a") . "<br/>";
            if ($_POST["txt4"] != "")
                $body.='<strong>Name: </strong>&nbsp;' . $_POST["txt4"] . "<br/>";
            if ($_POST["txt5"] != "")
                $body.='<strong>E-Mail: </strong>&nbsp;' . $_POST["txt5"] . "<br/>";
            if ($_POST["txt10"] != "")
                $body.='<strong>Phone: </strong>&nbsp;' . $_POST["txt10"] . "<br/>";
            if ($_POST["txt6"] != "")
                $body.='<strong>Address: </strong>&nbsp;' . $_POST["txt6"] . "<br/>";
            if ($_POST["txt7"] != "")
                $body.='<strong>Country: </strong>&nbsp;' . $_POST["txt7"] . "<br/>";
            if ($_POST["txt8"] != "")
                $body.='<strong>City: </strong>&nbsp;' . $_POST["txt8"] . "<br/>";
            if ($_POST["txt9"] != "")
                $body.='<strong>Comments: </strong>&nbsp;' . $_POST["txt9"] . "<br/>";

            $Mail = $this->loadLib("phpmailer");
            $Mail->From = $_POST["e2s"];
            $Mail->FromName = "FB Conexion";
            //$Mail->AddAddress("kreymundo@gmail.com");
            $Mail->AddAddress($_POST["e2r"]);
            $Mail->AddReplyTo($Mail->From);
            $Mail->Subject = "Contact Message " . $_POST["txt1"];
            $Mail->IsHTML(true);
            $Mail->Body = ($body);
            $Mail->Send();
            echo "Your message has been sent.";
        }
    }

    function processChimp($id) {
        $db = $this->dbInstance();
        $db->debug(2);
        $sql = "select estructura from #_widgetprod where marca='" . mysql_escape_string($id) . "'";
        $m = json_decode(urldecode($db->loadResult($sql)));
        $campain = $m->edb_w3;
        $apiid = $m->edb_w4;
        include(dirname(dirname(dirname(__FILE__)))) . "/widgets/mailchimp/MCAPI.class.php";
        $api = new MCAPI($apiid);
        $batch[] = array('EMAIL' => mysql_escape_string($_POST["mail"]));
        $optin = true; //yes, send optin emails
        $up_exist = true; // yes, update currently subscribed users
        $replace_int = false; // no, add interest, don't replace
        $vals = $api->listBatchSubscribe($campain, $batch, $optin, $up_exist, $replace_int);
        echo $campain . "---\n";
        if ($api->errorCode) {
            echo "Batch Subscribe failed!\n";
            echo "code:" . $api->errorCode . "\n";
            echo "msg :" . $api->errorMessage . "\n";
        } else {
            echo "okok";
        }
    }
    function slug($slug) {
        $this->checkSession();
        $de = array(
            "á", "é", "í", "ó", "ú", "ñ", "Á", "É", "Í", "Ó", "Ú", "Ñ", "_", " ", "(", ")", "[", "]"
        );
        $a = array(
            "a", "e", "i", "o", "u", "n", "a", "e", "i", "o", "u", "N", "-", "-", "", "", "", ""
        );
        $slug = strtolower(str_replace($de, $a, $slug));
        $atrar = str_split($slug);
        $str1 = "";
        foreach ($atrar as $c) {
            if ((ord($c) <= 47 || (ord($c) >= 58 && ord($c) <= 64) || (ord($c) >= 91 && ord($c) <= 96) || ord($c) >= 123) && ord($c) != 45) {
//no se hace nada, jaja
            } else {
                $str1.=$c;
            }
        }
        return $slug;
    }

    ///widget contest concurso competition
    function wcontest_form($id) {
        //carga normal
        $db = $this->dbInstance();
        $db->debug(2);
        $sql = "select * from #_widgetprod where marca='" . mysql_escape_string($id) . "'";
        $obj = $db->loadObjectRow($sql);
        $str = json_decode($obj->estructura);
        $this->params["obj"] = $obj;
        $this->params["str"] = $str;
        $this->params["idc"] = $id;
        $this->params["fbcred"] = $this->loadConfig("fb");
        //update files
        if ($_POST["fba"]) {
            switch ($this->params["str"]->edb_w2) {
                case "Image":
                    $files = array('jpg', 'png', 'gif');
                    $tipostream = "Image";
                    break;
                case "Video":
                default:
                    $files = array('mp4', 'flv');
                    $tipostream = "Video";
                    break;
            }
            if (trim($_POST["txt1"]) != "") {
                //un link
                $stream = str_replace(array("../","./"),"",trim(strip_tags($_POST["txt1"])));
            } else {
                //se sube el archivo
                if (!empty($_FILES)) {
                    $directorio = dirname(dirname(dirname(__FILE__)));
                    $directorio .= "/contest/";
                    $archivo = mktime().  rand(0, 999999999).str_replace(array("../","./"),"",strtolower($this->slug($_FILES["txt2"]["name"])));
                    $aux = explode(".", $archivo);
                    $ext = $aux[count($aux) - 1];
                    if (in_array($ext, $files)) {
                        move_uploaded_file($_FILES['txt2']['tmp_name'], $directorio . $archivo);
                        $stream = $this->getURL("contest/" . $archivo);
                    }
                } else {
                    $stream = "";
                }
            }
            //$this->debug($this->params["str"]);
            if ($stream != "") {
                $db->insert("#_appcontest", array(
                    "marca" => $id,
                    "resource" => $stream,
                    "tipo" => $tipostream,
                    "description" => mysql_escape_string(htmlspecialchars($_POST["txt3"])),
                    "fechains" => mktime(),
                    "uid" => mysql_escape_string($_POST["fba"]),
                ));
                $this->params["okok"] = true;
            }
            else{
                $this->params["okok"] = false;
            }
        }
        //showform
        $this->loadView("contest_form.php", $this->params);
    }

    ///widget contest concurso competition
    function wcontest($id) {
        $lib = $this->loadLib("textlibs");
        $db = $this->dbInstance();
        $sql = "select * from #_widgetprod where marca='" . mysql_escape_string($id) . "'";
        $obj = $db->loadObjectRow($sql);
        $str = json_decode(urldecode($obj->estructura));
        $sql = "select * from #_appcontest where marca='" . mysql_escape_string($id) . "'";
        $res = $db->loadObjectList($sql);
        ?>
        <div class="contestbar">
            <div class="contestsubmit">Submit <?= $str->edb_w2 ?> Entry</div>
            <iframe class="contestform" src="<?= $this->getURL("tabs/wcontest_form/$id") ?>"></iframe>
        </div>
        <div class="contestcon">
            <?php
            if (count($res) > 0) {
                foreach ($res as $r) {
                    ?>
                    <div class="contestitem">
                        <div class="contestres">
                            <?php
                            switch ($r->type) {
                                case "Image":
                                    echo '<img src="' . $this->getURL("contest/$r->resource") . '" />';
                                    break;
                                case "Video":
                                default:
                                    if (strpos($r->resource, "http://www.youtube.com") === false && strpos($r->resource, "http://youtu.be") === false) {
                                        //video normal
                                        echo '<iframe src="' . $this->getURL("flash/player2.swf?file=") . urlencode($this->getURL("contest/$r->resource")) . '" frameborder="0" allowfullscreen></iframe>';
                                    } else {
                                        //video youtube
                                        $s = str_replace(array("http://www.youtube.com/watch?v=", "http://youtu.be/"), "", $r->resource);
                                        $s = substr($s, 0, strpos($s, "&"));
                                        echo '<iframe src="http://www.youtube.com/embed/' . $s . '" frameborder="0" allowfullscreen></iframe>';
                                    }
                                    break;
                            }
                            ?>
                        </div>
                        <div class="contesttext">
                <?= strip_tags($r->desc) ?>
                        </div>
                        <div class="contestdate">
                <?= $lib->fechainexacta($r->fechains) ?>
                        </div>
                        <div class="contestlike">
                            <fb:like href="<?= $this->getURL("contest/$r->resources") ?>" send="false" layout="button_count" width="150" show_faces="false"></fb:like>
                        </div>
                    </div>
                <?php
            }
        }
        ?>
            <script type="text/javascript">
                FB.XFBML.parse();
            </script>
        </div>
        <?php
    }

}
?>
