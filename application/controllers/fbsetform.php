<?php

//buscar:        (\$_POST\[\")(edb_w[0-9]+)(\"\])
//reemplazar:    ($1$2$3?$1$2$3:\$m->$2)
function cleancs($string) {
    $string = strip_tags($string);
    $string = mysql_escape_string($string);
    return $string;
}

class Cfbsetform extends application {

    function _normalizar($valor) {
        $valor = str_replace("\'", "'", $valor);
        $valor = str_replace("'", "\'", $valor);
        return $valor;
    }

    function probar($id) {
        $db = $this->dbInstance();
        $x = $db->loadresult("select estructura from #_tab where id=" . $id);
        echo $x;
        $res = $db->loadObjectList("select * from #_widgeted where marca in ('" . str_replace(",", "','", $x) . "')");
        foreach ($res as $r) {
            echo '<br/><br/>marca:' . $r->marca . "<br/>";
            echo 'estructura:';
            echo '<div>' . htmlspecialchars(str_replace("\/", "/", urldecode($r->estructura))) . '</div>';
        }
    }

    function _guardarW($id, &$ed=null, $pub=null) {
        //extraigo la info
        $db = $this->dbInstance();
        $db->debug(2);
        $sql = "select * from #_widgeted where marca='$id'";
        $r = $db->loadObjectRow($sql);

        $estructura = json_decode(urldecode($r->estructura));
        if (!$estructura || $estructura == null) {
            $estructura = new object();
        }
        foreach ($_POST as $k => $p) {
            if (trim($p) != "")
                $estructura->$k = $p;
        }
        $db->update("#_widgeted", array(
            "estructura" => urlencode(json_encode($estructura)),
            "contenido_prod" => $this->_normalizar($pub),
            "contenido_ed" => $this->_normalizar($ed),
                ), "marca='$id'");
    }

    function _sacarMedidas($id, &$w, &$h) {
        $db = $this->dbInstance();
        $sql = "select * from #_widgeted where marca='$id'";
        $r = $db->loadObjectRow($sql);
        $estructura = json_decode(urldecode($r->estructura));
        if (!$estructura)
            $estructura = new object ();
        if ($_POST["width"] != "" && intval($_POST["width"]) <= 520 && intval($_POST["width"]) > 0)
            $estructura->width = $_POST["width"];
        else
            unset($_POST["width"]);
        if ($_POST["height"] != "" && intval($_POST["height"]) > 0)
            $estructura->height = $_POST["height"];
        else
            unset($_POST["height"]);
        if ($_POST["left"] != "")
            $estructura->left = ($_POST["left"] ? $_POST["left"] : 0);
        if ($_POST["top"] != "")
            $estructura->top = ($_POST["top"] ? $_POST["top"] : 0);
        if ($_POST["sp_1"] == "")//z-index
            $_POST["sp_1"] = "5";
        foreach ($_POST as $key => $p) {
            $estructura->{$key} = $p;
        }
        return $estructura;
    }

    function _generar_otros($id) {
        $cad = '';
        $cad.='<script type="text/javascript">';
        if ($_POST["width"] != "" && intval($_POST["width"]) <= 520 && intval($_POST["width"]) > 0)
            $cad.='document.getElementById("' . $id . '").style.width="' . intval($_POST["width"]) . 'px";';
        if ($_POST["height"] != "" && intval($_POST["height"]) > 0)
            $cad.='document.getElementById("' . $id . '").style.height="' . intval($_POST["height"]) . 'px";';
        if ($_POST["sp_1"] != "")
            $cad.='document.getElementById("' . $id . '").style.zIndex="' . intval($_POST["sp_1"]) . '";';
        if ($_POST["sp_2"] == "1" && $_POST["sp_3"] != "")
            $cad.='$("#' . $id . '").css("border","' . $_POST["sp_4"] . 'px solid ' . $_POST["sp_3"] . '");';
        else
            $cad.='$("#' . $id . '").css("border","1px solid #CECECF");';
        $cad.='</script>';
        echo $cad;
    }

    /**
     * HTML
     */
    function w1($idfanpage, $id) {
        $m = $this->_sacarMedidas($id, $w, $h);
        $editor = str_replace(array("iframe", "embed", "script"), "noscript", urldecode($m->edb_w1));
        $pub = urldecode($m->edb_w1);
        $this->_guardarW($id, $editor, $pub);
        echo $editor;
        $this->_generar_otros($id);
    }

    /**
     * Flash
     */
    function w2($idfanpage, $id) {
        $m = $this->_sacarMedidas($id, $w, $h);
        $editor = '<div class="estadoarchivo paresizar"><span>' . $m->edb_w1 . '</span></div><img class="paresizar" src="' . $this->getURL("images/bg_flash1.jpg") . '" alt=""  />';
        $resultado = '<object id="myFlash" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9.0.0.0" width="100%" height="100%">';
        $resultado.='<param name="movie" value="' . ($_POST["edb_w1"] ? $_POST["edb_w1"] : $m->edb_w1) . '">';
        $resultado.='<param name="quality" value="' . ($_POST["edb_w3"] ? $_POST["edb_w3"] : $m->edb_w3) . '">';
        $resultado.='<param name="wmode" value="' . $m->edb_w4 . '">';
        $resultado.='<param name="flashvars" value="' . $m->edb_w2 . '">';
        $resultado.='<embed src="' . $m->edb_w1 . '" wmode="' . $m->edb_w4 . '" FlashVars="' . $m->edb_w2 . '" quality="' . $m->edb_w3 . '" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" swLiveConnect=true></embed>';
        $resultado.='</object>';
        if ($m->edb_w1 != "") {
            $editor = $resultado;
        }
        $this->_guardarW($id, $editor, $resultado);
        echo $editor;
        $this->_generar_otros($id);
    }

    /**
     * insertar comentario
     */
    function w3($idfanpage, $id) {
        $m = $this->_sacarMedidas($id, $w, $h);
        $editor = '<img class="paresizar" src="' . $this->getURL("images/bg_comentario.jpg") . '" alt=""  />';
        $prod = '<iframe width="' . $m->width . '" height="' . $m->height . '" src="http://www.facebook.com/plugins/feedback.php?href=' . $m->edb_w1 . '&width=' . $m->width . '&num_posts=' . $m->edb_w2 . '&colorscheme=' . $m->edb_w3 . '"></iframe>';
        $prod = '<fb:comments href="' . $m->edb_w1 . '" publish_feed="' . $m->edb_w4 . '" num_posts="' . $m->edb_w2 . '" width="' . $m->width . '" colorscheme ="' . $m->edb_w3 . '">';
        $prod.='<script type="text/javascript">$("#' . $id . '").height("auto");</script>';
        $this->_guardarW($id, $editor, $prod);
        echo $editor;
        $this->_generar_otros($id);
    }

    /**
     * insertar video
     */
    function w4($idfanpage, $id) {
        $m = $this->_sacarMedidas($id, $w, $h);
        $editor = '<div class="estadoarchivo paresizar"><span>' . $m->edb_w1 . '</span></div><img class="paresizar" src="' . $this->getURL("images/bg_video1-" . $_SESSION["lang"] . ".jpg") . '" alt="Video" style="width:' . $m->width . 'px; height:' . $m->height . 'px;" />';
        $pub = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="100%" height="100%">
        <param name="movie" value="' . $this->getURL("/flash/player2.swf?file=" . urlencode($_POST["edb_w1"] ? $_POST["edb_w1"] : $m->edb_w1)) . '" />
        <param name="quality" value="high" />
        <param name="wmode" value="transparent" />
        <embed wmode="transparent" src="' . ("http://www.studio92.com/swf/player.swf?file=" . urlencode($_POST["edb_w1"] ? $_POST["edb_w1"] : $m->edb_w1)) . '" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%"></embed>
        </object>';
        if (trim($m->edb_w2) != "") {
            $marca = "cover" . mktime() . rand(0, 999999999);
            $pub = '<img id="' . $marca . '" src="' . $m->edb_w2 . '" style="position.absolute; z-index:31; width:' . $m->width . 'px; height:' . $m->height . 'px;"/>' . $pub;
            $pub.='<script type="text/javascript">$("#' . $marca . '").click(function(){$(this).hide();});</script>';
        }
        if ($m->edb_w1 != "")
            $editor = $pub;
        $this->_guardarW($id, $editor, $pub);
        echo $editor;
        $this->_generar_otros($id);
    }

    /**
     * rss
     */
    function w5($idfanpage, $id) {
        $m = $this->_sacarMedidas($id, $w, $h);
        $pub = '<iframe src="' . $this->getURL("widgets/rss.php") . '?feed=' . urlencode(str_replace("http://", "", $m->edb_w1)) . '&showtitle=' . urlencode($m->edb_w2) . '&display=' . urlencode($m->edb_w3) . '&posts=' . urlencode($m->edb_w4) . '&bgtitle=' . urlencode($m->edb_w5) . '" frameborder="0" allowfullscreen class="paresizar" style="width:100%;height:100%; position:relative; z-index:' . $m->sp_1 . '"></iframe>';
        if ($m->edb_w1 == "")
            $editor = '<img style="width:' . $m->width . 'px;height:' . $m->height . 'px;" class="paresizar" src="' . $this->getURL("images/bg_rss.jpg") . '" alt="Video"  />';
        else
            $editor = $pub;
        $this->_guardarW($id, $editor, $pub);
        echo $editor;
        $this->_generar_otros($id);
    }

    /**
     * insertar video de youtube
     */
    function w7($idfanpage, $id) {
        $m = $this->_sacarMedidas($id, $w, $h);
        $idy = str_replace("http://youtu.be/","",$m->edb_w1);
        $idy = preg_replace("/(http\:\/\/www.youtube.com\/watch\?v\=)(.[^&]+)(.*)?/", "$2", $idy);
        //echo $m->edb_w1;
        //-----------------------
        $editor = '<img src="' . $this->getURL("images/bg_youtube0.jpg") . '" class="paresizar" style="width:' . $m->width . 'px;height:' . $m->height . 'px;"/>';
        if ($m->edb_w1 != "")
            $editor =  '<div class="estadoarchivo paresizar"><span>' . $m->edb_w1 . '</span></div>';
        if (trim(str_replace("http://","",$m->edb_w3)) == ""){
            $editor .= '<img class="paresizar" src="http://i2.ytimg.com/vi/' . $idy . '/hqdefault.jpg" alt="Video" style="width:' . $m->width . 'px;height:' . $m->height . 'px;" />';
            $pub = '<iframe width="' . $m->width . '" height="' . $m->height . '" src="http://www.youtube.com/embed/' . $idy . '?hd=' . ($_POST["edb_w2"] ? $_POST["edb_w2"] : $m->edb_w2) . '" frameborder="0" allowfullscreen></iframe>';
        }
        else {
            $editor .= '<img class="paresizar" src="'.$m->edb_w3.'" alt="Video" style="width:' . $m->width . 'px;height:' . $m->height . 'px;" />';
            $editor .= '<div class="paresizar playvideo"></div>';
            $icorand = 'ico' . rand(0, 400000);
            $pub = '<script type="text/javascript">';
            $pub .= 'function ' . $icorand . '_click(a){' . "\n";
            $pub .= $icorand . '=\'<iframe width="' . $m->width . '" height="' . $m->height . '" src="http://www.youtube.com/embed/' . $idy . '?hd=' . ($_POST["edb_w2"] ? $_POST["edb_w2"] : $m->edb_w2) . '&autoplay=1" frameborder="0" allowfullscreen></iframe>\';' . "\n";
            $pub .= 'a.parentNode.innerHTML=' . $icorand . ";" . "\n";
            $pub .= 'return false;';
            $pub .= '}' . "\n";
            $pub .= '</script>';
            $pub .= '<a href="#" onclick="return ' . $icorand . '_click(this);"><img src="' . $m->edb_w3 . '" style="width:' . $m->width . 'px;height:' . $m->height . 'px; position:relative;"/><span class="paresizar playvideo" style="width:100%; height:100%;"></span></a>';
        } 
        $this->_guardarW($id, $editor, $this->_normalizar($pub));
        echo $editor;
        $this->_generar_otros($id);
    }

    /**
     * mixpod musica
     */
    function w8($idfanpage, $id) {
        $m = $this->_sacarMedidas($id, $w, $h);
        $idy = str_replace("http://www.mixpod.com/playlist/", "", $m->edb_w1);
        $editor = '<img class="paresizar" src="' . $this->getURL("images/bg_mixpod.jpg") . '" alt="Video" />';
        $pub = '<embed src="http://assets.myflashfetish.com/swf/mp3/mixpod.swf?myid=' . $idy . '" quality="high" wmode="transparent" bgcolor="ffffff" flashvars="mycolor=ffffff&mycolor2=dbd8da&mycolor3=594855&autoplay=' . $m->edb_w2 . '&rand=' . $m->edb_w3 . '&f=4&vol=100&pat=0&grad=false" width="100%" height="100%" name="myflashfetish" salign="TL" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" border="0" style="visibility:visible;width:100%;height:100%;" />    ';
        if ($m->edb_w1 != "") {
            $editor = $pub;
        }
        $this->_guardarW($id, $editor, $this->_normalizar($pub));
        echo $editor;
        $this->_generar_otros($id);
    }

    /**
     * share compartir
     */
    function w9($idfanpage, $id) {
        $m = $this->_sacarMedidas($id, $w, $h);
        $marca = "x" . mktime() . rand(0, 9);
        $editor = "";
        $pub = "";
        $settings = array();
        if ($m->edb_w3 != "")
            $settings[] = "'title':'" . $m->edb_w3 . "'";
        if ($m->edb_w1 != "")
            $settings[] = "'url':'" . $m->edb_w1 . "'";
        if ($m->edb_w4 == "")
            $m->edb_w4 = "ra-4df64a0f68cfdd03";
        switch ($m->edb_w2) {
            case 'compact':
                $editor = '<div style="float:left;width:136px; height:16px; background:url(' . $this->getURL("images/ico_share.jpg") . ') 0px 0px no-repeat;"></div>';
                $pub = '
                <!-- AddThis Button BEGIN -->
                <div class="addthis_toolbox addthis_default_style ">
                <a class="addthis_button_facebook"></a>
                <a class="addthis_button_twitter"></a>
                <a class="addthis_button_email"></a>
                <a class="addthis_button_linkedin"></a>
                <a class="addthis_button_compact"></a>
                <a class="addthis_counter addthis_bubble_style"></a>
                </div>';
                break;
            case 'big':
                $pub = '
                <!-- AddThis Button BEGIN -->
                <div class="addthis_toolbox addthis_default_style addthis_32x32_style">
                <a class="addthis_button_facebook"></a>
                <a class="addthis_button_twitter"></a>
                <a class="addthis_button_email"></a>
                <a class="addthis_button_linkedin"></a>
                <a class="addthis_button_compact"></a>
                <a class="addthis_counter addthis_bubble_style"></a>
                </div>';
                $editor = '<div style="float:left;width:242px; height:32px; background:url(' . $this->getURL("images/ico_share.jpg") . ') 0px -17px no-repeat;"></div>';
                break;
            case 'boxcount':
                $editor = '<div style="float:left;width:270px; height:20px; background:url(' . $this->getURL("images/ico_share.jpg") . ') 0px -50px no-repeat;"></div>';
                $pub = '
                <!-- AddThis Button BEGIN -->
                <div class="addthis_toolbox addthis_default_style ">
                <a class="addthis_button_facebook"></a>
                <a class="addthis_button_twitter"></a>
                <a class="addthis_button_email"></a>
                <a class="addthis_button_linkedin"></a>
                <a class="addthis_counter addthis_pill_style"></a>
                </div>';
                break;
        }
        $editor.='<script type="text/javascript">
                ' . $marca . 'fun=function(){
                    $("#' . $id . '").width("auto");
                    $("#' . $id . '").height("auto");
                    setTimeout(' . $marca . 'fun,200);
                }
                ' . $marca . 'fun();
            </script>';
        $pub.='<script type="text/javascript">
                    var addthis_share = {
                        ' . implode(",", $settings) . '
                        
                    };
                    var addthis_config = {
                        "data_track_clickback":true
                    };
                </script>
                <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=' . $m->edb_w4 . '"></script>
                <!-- AddThis Button END -->    
                ';
        $this->_guardarW($id, $editor, $pub);
        echo $editor;
        $this->_generar_otros($id);
    }

    /**
     * listado youtube
     */
    function w10($idfanpage, $id) {
        $m = $this->_sacarMedidas($id, $w, $h);
        $editor = '<img class="paresizar" src="' . $this->getURL("images/bg_youtubelist.jpg") . '"/>';
        $marca = "x" . mktime() . rand(0, 40000000);
        $prod = '';
        $prod.='<div id="' . $marca . '" style="float:left;width:' . $m->width . ';height:' . $m->height . ';"></div>';
        $prod.='
        <script type="text/javascript">
            videos=' . json_encode($m->edb_wc) . ';
            descs=' . json_encode($m->edb_wd) . ';
            $("#' . $marca . '").listadoYoutube(false,videos,descs,' . $m->width . ',' . $m->height . ');
        </script>';
        $prod.='<script type="text/javascript">
            ' . $marca . 'fun=function(){
                    $("#' . $id . '").height("auto");
                    setTimeout(' . $marca . 'fun,200);
                }
                ' . $marca . 'fun();
                </script>';
        if (count($m->edb_wc) > 0) {
            $editor = str_replace("false,videos,descs", "true,videos,descs", $prod);
        }
        $this->_guardarW($id, $editor, $prod);
        echo $editor;
        $this->_generar_otros($id);
    }

    /**
     * Imagen
     */
    function w12($idfanpage, $id) {
        $m = $this->_sacarMedidas($id, $w, $h);
        $editor = '<img class="paresizar" src="' . $m->edb_w1 . '" alt="" style="width:' . $m->width . 'px; height:' . $m->height . 'px;" />';
        $pub = '<img width="' . $m->width . '" height="' . $m->height . '" src="' . $m->edb_w1 . '" alt=""  />';
        if ($m->edb_w2 != "") {
            $pub = '<a href="' . ($_POST["edb_w2"] ? $_POST["edb_w2"] : $m->edb_w2) . '" target="_blank">' . $pub . '</a>';
        }
        $this->_guardarW($id, $editor, $pub);
        echo $editor;
        $this->_generar_otros($id);
    }

    /**
     * twitter
     */
    function w13($idfanpage, $id) {
        $m = $this->_sacarMedidas($id, $w, $h);
        $editor = '<img class="paresizar" src="' . $this->getURL("images/bg_twitter.jpg") . '" alt=""  />';
        $pub = '<iframe width="' . $m->width . '" height="' . $m->height . '" src="' . $this->getURL("widgets/twitter.php?query=" . urlencode(($_POST["edb_w1"] ? $_POST["edb_w1"] : $m->edb_w1)) . "&title=" . urlencode(($_POST["edb_w2"] ? $_POST["edb_w2"] : $m->edb_w2)) . "&subtitle=" . urlencode(($_POST["edb_w3"] ? $_POST["edb_w3"] : $m->edb_w3)) . "&bgcolor1=" . urlencode(($_POST["edb_w4"] ? $_POST["edb_w4"] : $m->edb_w4)) . "&bgcolor2=" . urlencode(($_POST["edb_w5"] ? $_POST["edb_w5"] : $m->edb_w5)) . "&ltcolor=" . urlencode(($_POST["edb_w6"] ? $_POST["edb_w6"] : $m->edb_w6)) . "&lkcolor=" . urlencode(($_POST["edb_w7"] ? $_POST["edb_w7"] : $m->edb_w7))) . '&w=' . $m->width . '&h=' . $m->height . '" frameborder="0" allowfullscreen></iframe>';
        $this->_guardarW($id, $editor, $pub);
        echo $editor;
        $this->_generar_otros($id);
    }

    /**
     * ustream
     */
    function w14($idfanpage, $id) {
        $m = $this->_sacarMedidas($id, $w, $h);
        $editor = '<div class="estadoarchivo paresizar"><span>' . $m->edb_w1 . '</span></div><img class="paresizar" src="' . $this->getURL("images/bg_ustream1-" . $_SESSION["lang"] . ".jpg") . '" alt=""  />';

        $uid = preg_replace("/(.+)([0-9]){0,8}/", "$2", $m->edb_w1);
        $uid = str_replace(array(
            "http://www.ustream.tv/channel/",
            "http://www.ustream.tv/recorded/"
                ), "", $m->edb_w1);
        $video = '<object width="100%" height="100%" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000">'
                . '<param name="flashvars" value="cid=' . $uid . '&amp;autoplay={autoplay}"/>'
                . '<param name="wmode" value="transparent"/>'
                . '<param name="allowfullscreen" value="true"/>'
                . '<param name="allowscriptaccess" value="always"/>'
                . '<param name="src" value="http://www.ustream.tv/flash/viewer.swf"/>'
                . '<embed flashvars="cid=' . $uid . '&amp;autoplay={autoplay}" width="100%" height="100%" allowfullscreen="true" allowscriptaccess="always" src="http://www.ustream.tv/flash/viewer.swf" type="application/x-shockwave-flash"></embed>'
                . '</object>';
        if (strpos($m->edb_w1, "channel") === false)
            $video = str_replace("\"cid", "\"vid", $video);
        $icorand = "vid_" . rand(0, 400000);
        if ($m->edb_w2 != "") {
            $pub = '<script type="text/javascript">' . "\n";
            $pub .= 'function ' . $icorand . '_click(a){' . "\n" . "\n";
            $pub .= $icorand . '=\'' . str_replace("{autoplay}", "true", $video) . '\';' . "\n";
            $pub .= 'a.parentNode.innerHTML=' . $icorand . ";" . "\n";
            $pub .= '}' . "\n";
            $pub .= '</script>' . "\n";
            $pub .= '<a href="#" onclick="' . $icorand . '_click(this);"><img src="' . $m->edb_w2 . '" style="width:' . $m->width . 'px;height:' . $m->height . 'px;"/></a>' . "\n";
        } else {
            $pub = str_replace("{autoplay}", "false", $video);
        }
        if ($m->edb_w1 != "")
            $editor = $pub;
        $this->_guardarW($id, $editor, $pub);
        echo $editor;
        $this->_generar_otros($id);
    }

    /**
     * me gusta
     */
    function w15($idfanpage, $id) {
        $m = $this->_sacarMedidas($id, $w, $h);
        $editor = '<img class="paresizar" src="' . $this->getURL("images/bg_like.png") . '" alt=""  />';
        $pub = '<fb:like href="' . $m->edb_w1 . '" send="' . $m->edb_w2 . '" layout="' . $m->edb_w3 . '" width="' . $m->width . '" show_faces="' . $m->edb_w4 . '" action="' . $m->edb_w5 . '" colorscheme="' . $m->edb_w6 . '" font=""></fb:like>';
        $pub.='<script>$("#' . $id . '").height("auto");</script>';
        $this->_guardarW($id, $editor, $pub);
        echo $editor;
        $this->_generar_otros($id);
    }

    /**
     * texto
     */
    function w17($idfanpage, $id) {
        $m = $this->_sacarMedidas($id, $w, $h);
        $texto = $m->texto;
        $editor = '<div class="paresizar" style="position:absolute; width:' . round($m->width) . 'px; height:' . round($m->height) . 'px;"></div>' . str_replace(array("iframe", "embed", "script"), "noscript", urldecode($this->_normalizar($texto)));
        $pub = urldecode($this->_normalizar($texto));
        $this->_guardarW($id, $editor, $pub);
        echo $editor;
        $this->_generar_otros($id);
    }

    /**
     * livestream chat
     */
    function w18($idfanpage, $id) {
        $m = $this->_sacarMedidas($id, $w, $h);
        $editor = '<img class="paresizar" src="' . $this->getURL("images/bg_chat_facebook.png") . '" style="width:300px; height:400px;"/>';
        $pub = '<fb:live-stream event_app_id="212144002139857" width="' . $m->width . '" height="' . $m->height . '" xid="" via_url="' . $m->edb_w1 . '" always_post_to_friends="' . $m->edb_w2 . '"></fb:live-stream>';
        $this->_guardarW($id, $editor, $pub);
        echo $editor;
        $this->_generar_otros($id);
    }

    /**
     * follow us
     */
    function w19($idfanpage, $id) {
        $m = $this->_sacarMedidas($id, $w, $h);
        $editor = '<div class="paresizar" style="float:left;background:url(' . $this->getURL("images/bg_followus.png") . ') no-repeat left top; width:' . $m->width . 'px; height:' . $m->height . 'px;"></div>';
        $pub = '';
        $pub .= '<div style="float:left; width:' . $m->width . 'px; height:85px; background:url(' . $this->getURL("images/bg_followus.png") . ') no-repeat"></div>';
        if ($m->edb_w1 != "")//twitter
            $pub.='<a target="_blank" href="http://twitter.com/' . strip_tags($m->edb_w1) . '" class="followusitem" style="width:' . $m->width . 'px; background-position:0px -' . (85 + 0 * 35) . 'px"></a>';
        if ($m->edb_w2 != "")//feed
            $pub.='<a target="_blank" href="' . $m->edb_w2 . '" class="followusitem" style="width:' . $m->width . 'px; background-position:0px -' . (85 + 1 * 35) . 'px"></a>';
        if ($m->edb_w3 != "")//windows live
            $pub.='<a href="mailto:' . $m->edb_w3 . '" class="followusitem" style="width:' . $m->width . 'px; background-position:0px -' . (85 + 2 * 35) . 'px"></a>';
        if ($m->edb_w4 != "")//delicious
            $pub.='<a target="_blank" href="' . $m->edb_w4 . '" class="followusitem" style="width:' . $m->width . 'px; background-position:0px -' . (85 + 3 * 35) . 'px"></a>';
        if ($m->edb_w5 != "")//my space
            $pub.='<a target="_blank" href="' . strip_tags($m->edb_w5) . '" class="followusitem" style="width:' . $m->width . 'px; background-position:0px -' . (85 + 4 * 35) . 'px"></a>';
        if ($m->edb_w6 != "")//yahoo
            $pub.='<a target="_blank" href="http://pulse.yahoo.com/' . strip_tags($m->edb_w6) . '" class="followusitem" style="width:' . $m->width . 'px; background-position:0px -' . (85 + 5 * 35) . 'px"></a>';
        if ($m->edb_w7 != "")//skype
            $pub.='<a href="skype:' . strip_tags($m->edb_w7) . '?add" class="followusitem" style="width:' . $m->width . 'px; background-position:0px -' . (85 + 6 * 35) . 'px"></a>';
        if ($m->edb_w8 != "")//messenger
            $pub.='<a href="mailto:' . $m->edb_w8 . '" class="followusitem" style="width:' . $m->width . 'px; background-position:0px -' . (85 + 7 * 35) . 'px"></a>';
        if ($m->edb_w9 != "")//google buzz
            $pub.='<a target="_blank" href="http://www.google.com/profiles/' . $m->edb_w9 . '" class="followusitem" style="width:' . $m->width . 'px; background-position:0px -' . (85 + 8 * 35) . 'px"></a>';
        if ($m->edb_w10 != "")//youtube
            $pub.='<a target="_blank" href="http://www.youtube.com/user/' . $m->edb_w10 . '" class="followusitem" style="width:' . $m->width . 'px; background-position:0px -' . (85 + 9 * 35) . 'px"></a>';
        if ($m->edb_w1 . $m->edb_w2 . $m->edb_w3 . $m->edb_w4 . $m->edb_w5 . $m->edb_w6 . $m->edb_w7 . $m->edb_w8 . $m->edb_w9 . $m->edb_w10 != "")
            $editor = $pub;
        $this->_guardarW($id, $editor, $pub);
        echo $editor;
        $this->_generar_otros($id);
    }

    /**
     * galeria fb
     */
    function w21($idfanpage, $id) {
        $m = $this->_sacarMedidas($id, $w, $h);
        $editor = '<img class="paresizar" src="' . $this->getURL("images/bg_galeria" . $m->edb_w1 . ".jpg") . '" style="width:' . $m->width . 'px; height:' . $m->height . 'px;"/>';
        $marca = "x" . mktime() . rand(0, 40000000);
        //echo '<pre>';print_r($m).'</pre>';
        switch ($m->edb_w1) {
            case 2:
                //el q hice
                $editor = '<div id="' . $marca . '">';
                $images = array();
                if (count($m->edb_wc) > 0) {
                    $editor.='<div class="g2c1">';
                    foreach ($m->edb_wc as $key => $i) {
                        $images[] = array("src" => $i, "title" => $m->edb_wd[$key]);
                        $editor.='<div class="g2mini"><img src="' . $i . '" style="width:100%" /></div>';
                    }
                    $editor.='</div>';
                }

                $editor.='<div class="g2big"><img src="' . $m->edb_wc[0] . '" style="max-width:' . $m->width . 'px; max-height:' . $m->height . 'px;" /></div>';
                $editor.='
                    <script type="text/javascript">
                        galeria' . $marca . '=function(){
                            $("#' . $marca . ' .g2c1").css({
                                width:260,
                                height:252,
                                overflow:"hidden",
                                "float":"left"
                            });
                            $("#' . $marca . ' .g2mini").css({
                                "float":"left",
                                width:116,
                                height:116,
                                overflow:"hidden",
                                border:"3px solid #CFCFCF",
                                margin:2
                            });
                            $("#' . $marca . ' .g2mini img").width(116);
                            if($("#' . $marca . '").width()>260){
                                $("#' . $marca . ' .g2big").css({
                                    "float":"left",
                                    width:$("#' . $id . '").width()-260,
                                    height:$("#' . $id . '").height(),
                                    display:"block"
                                });
                                $("#' . $marca . ' .g2big img").css({
                                    "float":"left",
                                    "max-width":$("#' . $id . '").width()-260,
                                    "max-height":$("#' . $id . '").height()
                                });
                            }else{
                                $("#' . $marca . ' .g2big").hide();
                            }
                            setTimeout(galeria' . $marca . ',200);
                        }
                        galeria' . $marca . '();
                    </script>';
                $editor.='</div>';
                $pub = '';
                $pub.='<div id="' . $marca . '" style="float:left; width:' . $m->width . 'px; height:' . $m->height . 'px;"></div>';
                $pub.='<script type="text/javascript">';
                $pub.='
                    $(document).ready(function(){
                        images=' . json_encode($images) . ';
                        $("#' . $marca . '").galeria1(images)
                    });';
                $pub.='</script>';

                break;
            case 3:
                //el del comercio---y aqui tb tengo que hacer uno mas para que me bote el xml
                $pub = '
                <div id="' . $marca . '"></div>
                <script type="text/javascript">
                    flashvars={
                        "paramXMLPath":"' . $this->getURL("tabs/galeria2_xml1/" . $id) . '",
                        "initialURL":"' . $this->getURL("") . '",
                        "wmode":"transparent",
                        "allowFullScreen":"true"
                    };
                    swfobject.embedSWF("' . $this->getURL("widgets/slideshowpro/slideshowpro.swf") . '","' . $marca . '","' . $m->width . '","' . $m->height . '", "9.0.0","expressInstall.swf",flashvars,null,flashvars);
                </script>    
                ';
                break;
            case 0:
                //este lo tengo que crear a full
                $images = array();
                if (count($m->edb_wc) > 0)
                    foreach ($m->edb_wc as $key => $i) {
                        $images[] = array("src" => $i, "title" => $m->edb_wd[$key]);
                    }
                $pub = '';
                $pub.='<div id="' . $marca . '" style="float:left; width:' . $m->width . 'px; height:' . $m->height . 'px;"></div>';
                $pub.='<script type="text/javascript">';
                $pub.='
                    $(document).ready(function(){
                        images=' . json_encode($images) . ';
                        $("#' . $marca . '").galeria3(images);
                        $("#' . $id . '").height("auto");
                    });';
                $pub.='</script>';
                $editor = '<div id="' . $marca . '" style="text-align:center;"><img src="' . $images[0]["src"] . '" /></div>
                <script type="text/javascript">
                    $(document).ready(function(){
                        galeria' . $marca . '=function(){
                            $("#' . $marca . ' img").css({
                                "max-width":$("#' . $id . '").width(),
                                "max-height":$("#' . $id . '").height()
                            });
                            setTimeout(galeria' . $marca . ',200);
                        }
                        galeria' . $marca . '();
                    });
                </script>';
                break;
            case 1:
                //el otro tb que hice
                $images = array();
                $editor = '';
                if (count($m->edb_wc) > 0)
                    foreach ($m->edb_wc as $key => $i) {
                        $images[] = array("src" => $i, "title" => $m->edb_wd[$key]);
                        $editor.='<div class="' . $marca . 'gal2"><img src="' . $i . '" style="width:100%" /></div>';
                    }
                $pub = '';
                $pub.='<div id="' . $marca . '" style="float:left; width:' . $m->width . 'px;"></div>';
                $pub.='<script type="text/javascript">';
                $pub.='
                    $(document).ready(function(){
                        images=' . json_encode($images) . ';
                        $("#' . $marca . '").galeria4(images);
                        $("#' . $id . '").height("auto");
                    });';
                $pub.='</script>';

                $editor.='
                    <script type="text/javascript">
                        galeria' . $marca . '=function(){
                            a=$("#' . $id . '").width()/2-10;
                            $(".' . $marca . 'gal2").css({
                                "float":"left",
                                width:a,
                                height:a,
                                border:"3px solid #ccc",
                                margin:2,
                                overflow:"hidden"
                            });
                            setTimeout(galeria' . $marca . ',200);
                            $("#' . $id . '").height("auto");
                        }
                        galeria' . $marca . '();
                    </script>';
        }
        $prod.='<script>$("#' . $id . '").height("auto");</script>';
        $this->_guardarW($id, $editor, $pub);
        echo $editor;
        $this->_generar_otros($id);
    }

    /**
     * google maps
     */
    function w22($idfanpage, $id) {
        $m = $this->_sacarMedidas($id, $w, $h);
        $editor = '<img class="paresizar" src="' . $this->getURL("images/bg_map.jpg") . '" alt=""  />';
        //$pub = '<iframe scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:' . $m->width . 'px; height:' . $m->height . 'px;" src="'.$this->getURL("widgets/maps.php").'?latlong='.urlencode($m->edb_w1).'"></iframe>';
        $m->edb_w1 = urlencode("$m->edb_w3, $m->edb_w2, $m->edb_w1, $m->edb_w4");
        $pub = '<iframe style="width:' . $m->width . 'px; height:' . $m->height . 'px; z-index:' . $m->sp_1 . ';" class="paresizar" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="' . $this->getURL("widgets/maps.php?f=".$_SESSION["lang"]."&q=") . $m->edb_w1 . '&z=' . $m->edb_w5 . '"></iframe>';
        if ($m->edb_w2 . $m->edb_w3 . $m->edb_w4 != "")
            $editor = $pub;
        $this->_guardarW($id, $editor, $pub);
        echo $editor;
        $this->_generar_otros($id);
    }

    /**
     * paypal donate
     */
    function w23($idfanpage, $id) {
        $m = $this->_sacarMedidas($id, $w, $h);
        $editor = "";
        switch ($m->edb_w2) {
            case 0://simple button
                $img = 'https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif';
                $_POST["width"] = 92;
                $_POST["height"] = 26;
                break;
            case 1://smaller button
                $img = 'https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif';
                $_POST["width"] = 74;
                $_POST["height"] = 21;
                break;
            case 2://button with flags
                $img = 'https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif';
                $_POST["width"] = 147;
                $_POST["height"] = 47;
                break;
        }
        $editor = '<img class="paresizar" src="' . $img . '" alt=""/>';
        $pub = '
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
            <!-- Identify your business so that you can collect the payments. -->  
            <input type="hidden" name="business" value="' . $m->edb_w5 . '">
            <!-- Specify a Donate button. -->  
            <input type="hidden" name="cmd" value="_donations">
            <!-- Specify details about the contribution -->  
            <input type="hidden" name="item_name" value="' . $m->edb_w3 . '"> 
            <input type="hidden" name="item_number" value="' . $m->edb_w6 . '">  
            <input type="hidden" name="currency_code" value="' . $m->edb_w4 . '">  
            <input class="paresizar" type="image" name="submit" border="0" src="' . $img . '" alt="PayPal - The safer, easier way to pay online" style="width:' . $r->width . 'px;height:' . $r->height . 'px;"/>
            <img alt="" border="0" width="1" height="1" src="https://www.paypal.com/en_US/i/scr/pixel.gif" >
        </form>
        ';
        $this->_guardarW($id, $editor, $pub);
        echo $editor;
        $this->_generar_otros($id);
        ?>
        <script type="text/javascript">
            $("#<?= $id ?> img").ready(function(){
                $("#<?= $id ?>").width($("#<?= $id ?> img").width());
                $("#<?= $id ?>").height($("#<?= $id ?> img").height());
            });
        </script>
        <?php
    }

    /**
     * flikr
     */
    function w24($idfanpage, $id) {
        $m = $this->_sacarMedidas($id, $w, $h);
        $editor = '<img class="paresizar" src="' . $this->getURL("images/bg_galeria" . $m->edb_w1 . ".jpg") . '"/>';
        $marca = "x" . mktime() . rand(0, 40000000);
        $a2 = $m->edb_w2;
        switch ($m->edb_w1) {
            case 2:
                //el q hice
                $pub = '';
                $pub.='<div id="' . $marca . '" style="float:left; width:' . $m->width . 'px; height:' . $m->height . 'px;"></div>';
                $pub.='<script type="text/javascript">';
                $pub.='
                    $.getJSON("' . $this->getURL("widgets/flikr/inFlikr.php?username=$m->edb_w2&estilo=0") . '", "", function(imgs){
                        $("#' . $marca . '").galeria1(imgs);
                    });';
                $pub.='</script>';

                $x = file_get_contents($this->getURL("widgets/flikr/inFlikr.php?username=$m->edb_w2&estilo=0"));
                $images = json_decode($x, true);

                $editor = '<div id="' . $marca . '">';
                $editor.='<div class="g2c1">';
                foreach ($images as $key => $i) {
                    $editor.='<div class="g2mini"><img src="' . $i["src"] . '" style="width:100%" /></div>';
                }
                $editor.='</div>';
                $editor.='<div class="g2big"><img src="' . $images[0]["src"] . '" style="max-width:' . $m->width . 'px; max-height:' . $m->height . 'px;" /></div>';
                $editor.='
                    <script type="text/javascript">
                        galeria' . $marca . '=function(){
                            $("#' . $marca . ' .g2c1").css({
                                width:260,
                                height:252,
                                overflow:"hidden",
                                "float":"left"
                            });
                            $("#' . $marca . ' .g2mini").css({
                                "float":"left",
                                width:116,
                                height:116,
                                overflow:"hidden",
                                border:"3px solid #CFCFCF",
                                margin:2
                            });
                            $("#' . $marca . ' .g2mini img").width(116);
                            if($("#' . $marca . '").width()>260){
                                $("#' . $marca . ' .g2big").css({
                                    "float":"left",
                                    width:$("#' . $id . '").width()-260,
                                    height:$("#' . $id . '").height(),
                                    display:"block"
                                });
                                $("#' . $marca . ' .g2big img").css({
                                    "float":"left",
                                    "max-width":$("#' . $id . '").width()-260,
                                    "max-height":$("#' . $id . '").height()
                                });
                            }else{
                                $("#' . $marca . ' .g2big").hide();
                            }
                            setTimeout(galeria' . $marca . ',200);
                        }
                        galeria' . $marca . '();
                    </script>';
                $editor.='</div>';
                break;
            case 3:
                //el del comercio---y aqui tb tengo que hacer uno mas para que me bote el xml
                $pub = '
                <div id="' . $marca . '"></div>
                <script type="text/javascript">
                    flashvars={
                        "paramXMLPath":"' . urlencode($this->getURL("tabs/galeria2_xml1/$id/$a2")) . '",
                        "initialURL":"' . urlencode($this->getURL("")) . '"
                    };
                    swfobject.embedSWF("' . $this->getURL("widgets/slideshowpro/slideshowpro.swf") . '","' . $marca . '","' . $m->width . '","' . $m->height . '", "9.0.0","expressInstall.swf",flashvars,flashvars);
                </script>    
                ';
                break;
            case 0:
                //el otro tb que hice
                $pub = '';
                $pub.='<div id="' . $marca . '" style="float:left; width:' . $m->width . 'px; height:' . $m->height . 'px;"></div>';
                $pub.='<script type="text/javascript">';
                $pub.='
                    $.getJSON("' . $this->getURL("widgets/flikr/inFlikr.php?username=$m->edb_w2&estilo=0") . '", "", function(imgs){
                        $("#' . $marca . '").galeria3(imgs);
                    });';
                $pub.='</script>';

                $x = file_get_contents($this->getURL("widgets/flikr/inFlikr.php?username=$m->edb_w2&estilo=0"));
                $images = json_decode($x, true);
                $editor = '<div id="' . $marca . '" style="text-align:center;"><img src="' . $images[0]["src"] . '" /></div>
                <script type="text/javascript">
                    galeria' . $marca . '=function(){
                        $("#' . $marca . ' img").css({
                            "max-width":$("#' . $id . '").width(),
                            "max-height":$("#' . $id . '").height()
                        });
                        setTimeout(galeria' . $marca . ',200);
                    }
                    galeria' . $marca . '();
                </script>';

                break;
            case 1:
                //el otro tb que hice
                //el q hice
                $pub = '';
                $pub.='<div id="' . $marca . '" style="float:left; width:' . $m->width . 'px; height:' . $m->height . 'px;"></div>';
                $pub.='<script type="text/javascript">';
                $pub.='
                    $.getJSON("' . $this->getURL("widgets/flikr/inFlikr.php?username=$m->edb_w2&estilo=0") . '", "", function(imgs){
                        $("#' . $marca . '").galeria4(imgs);
                    });';
                $pub.='</script>';

                $x = file_get_contents($this->getURL("widgets/flikr/inFlikr.php?username=$m->edb_w2&estilo=0"));
                $images = json_decode($x, true);

                $editor = '';
                foreach ($images as $key => $i) {
                    $editor.='<div class="' . $marca . 'gal2"><img src="' . $i["src"] . '" style="width:100%" /></div>';
                }
                $editor.='
                    <script type="text/javascript">
                        galeria' . $marca . '=function(){
                            a=$("#' . $id . '").width()/2-10;
                            $(".' . $marca . 'gal2").css({
                                "float":"left",
                                width:a,
                                height:a,
                                border:"3px solid #ccc",
                                margin:2,
                                overflow:"hidden"
                            });
                            setTimeout(galeria' . $marca . ',200);
                            $("#' . $id . '").height("auto");
                        }
                        galeria' . $marca . '();
                    </script>';
                break;
        }
        $this->_guardarW($id, $editor, $this->_normalizar($pub));
        echo $editor;
        $this->_generar_otros($id);
    }

    /**
     * galeria picasa
     */
    function w25($idfanpage, $id) {
        $m = $this->_sacarMedidas($id, $w, $h);
        $editor = '<img class="paresizar" src="' . $this->getURL("images/bg_galeria" . $m->edb_w1 . ".jpg") . '"/>';
        $marca = "x" . mktime() . rand(0, 40000000);
        $a2 = str_replace("https://picasaweb.google.com/", "", $m->edb_w2);
        $pars = explode("?authkey=", $a2);
        switch ($m->edb_w1) {
            case 2:
                //el q hice
                $pub = '';
                $pub.='<div id="' . $marca . '" style="float:left; width:' . $m->width . 'px; height:' . $m->height . 'px;"></div>';
                $pub.='<script type="text/javascript">';
                $pub.='
                    $.getJSON("' . $this->getURL("tabs/picasa1/" . $pars[0] . "/0/" . $pars[1]) . '", "", function(imgs){
                        $("#' . $marca . '").galeria1(imgs);
                    });';
                $pub.='</script>';

                $x = file_get_contents($this->getURL("tabs/picasa1/$a2/0"));
                $images = json_decode($x, true);

                $editor = '<div id="' . $marca . '">';
                $editor.='<div class="g2c1">';
                foreach ($images as $key => $i) {
                    $editor.='<div class="g2mini"><img src="' . $i["src"] . '" style="width:100%" /></div>';
                }
                $editor.='</div>';
                $editor.='<div class="g2big"><img src="' . $images[0]["src"] . '" style="max-width:' . $m->width . 'px; max-height:' . $m->height . 'px;" /></div>';
                $editor.='
                    <script type="text/javascript">
                        galeria' . $marca . '=function(){
                            $("#' . $marca . ' .g2c1").css({
                                width:260,
                                height:252,
                                overflow:"hidden",
                                "float":"left"
                            });
                            $("#' . $marca . ' .g2mini").css({
                                "float":"left",
                                width:116,
                                height:116,
                                overflow:"hidden",
                                border:"3px solid #CFCFCF",
                                margin:2
                            });
                            $("#' . $marca . ' .g2mini img").width(116);
                            if($("#' . $marca . '").width()>260){
                                $("#' . $marca . ' .g2big").css({
                                    "float":"left",
                                    width:$("#' . $id . '").width()-260,
                                    height:$("#' . $id . '").height(),
                                    display:"block"
                                });
                                $("#' . $marca . ' .g2big img").css({
                                    "float":"left",
                                    "max-width":$("#' . $id . '").width()-260,
                                    "max-height":$("#' . $id . '").height()
                                });
                            }else{
                                $("#' . $marca . ' .g2big").hide();
                            }
                            setTimeout(galeria' . $marca . ',200);
                        }
                        galeria' . $marca . '();
                    </script>';
                $editor.='</div>';

                break;
            case 3:
                //el del comercio---y aqui tb tengo que hacer uno mas para que me bote el xml
                $pub = '
                <div id="' . $marca . '"></div>
                <script type="text/javascript">
                    flashvars={
                        "paramXMLPath":"' . $this->getURL("tabs/galeria2_xml1/$id/" . $pars[0]) . '",
                        "initialURL":"' . $this->getURL("") . '"
                    };
                    swfobject.embedSWF("' . $this->getURL("widgets/slideshowpro/slideshowpro.swf") . '","' . $marca . '","' . $m->width . '","' . $m->height . '", "9.0.0","expressInstall.swf",flashvars,flashvars);
                </script>    
                ';
                break;
            case 0:
                //el otro tb que hice
                //el q hice
                $pub = '';
                $pub.='<div id="' . $marca . '" style="float:left; width:' . $m->width . 'px; height:' . $m->height . 'px;"></div>';
                $pub.='<script type="text/javascript">';
                $pub.='
                    $.getJSON("' . $this->getURL("tabs/picasa1/$a2/0") . '", "", function(imgs){
                        $("#' . $marca . '").galeria3(imgs);
                    });';
                $pub.='</script>';
                $x = file_get_contents($this->getURL("tabs/picasa1/$a2/0"));
                $images = json_decode($x, true);
                $editor = '<div id="' . $marca . '" style="text-align:center;"><img src="' . $images[0]["src"] . '" /></div>
                <script type="text/javascript">
                    galeria' . $marca . '=function(){
                        $("#' . $marca . ' img").css({
                            "max-width":$("#' . $id . '").width(),
                            "max-height":$("#' . $id . '").height()
                        });
                        setTimeout(galeria' . $marca . ',200);
                    }
                    galeria' . $marca . '();
                </script>';
                break;
            case 1:
                //el otro tb que hice
                //el q hice
                $pub = '';
                $pub.='<div id="' . $marca . '" style="float:left; width:' . $m->width . 'px; height:' . $m->height . 'px;"></div>';
                $pub.='<script type="text/javascript">';
                $pub.='
                    $.getJSON("' . $this->getURL("tabs/picasa1/$a2/0") . '", "", function(imgs){
                        $("#' . $marca . '").galeria4(imgs);
                    });';
                $pub.='</script>';

                $x = file_get_contents($this->getURL("tabs/picasa1/$a2/0"));
                $images = json_decode($x, true);
                $editor = '';
                foreach ($images as $key => $i) {
                    $editor.='<div class="' . $marca . 'gal2"><img src="' . $i["src"] . '" style="width:100%" /></div>';
                }
                $editor.='
                    <script type="text/javascript">
                        galeria' . $marca . '=function(){
                            a=$("#' . $id . '").width()/2-10;
                            $(".' . $marca . 'gal2").css({
                                "float":"left",
                                width:a,
                                height:a,
                                border:"3px solid #ccc",
                                margin:2,
                                overflow:"hidden"
                            });
                            setTimeout(galeria' . $marca . ',200);
                            $("#' . $id . '").height("auto");
                        }
                        galeria' . $marca . '();
                    </script>';
                break;
        }
        $this->_guardarW($id, $editor, $this->_normalizar($pub));
        echo $editor;
        $this->_generar_otros($id);
    }

    /**
     * video facebook
     */
    function w26($idfanpage, $id) {
        $m = $this->_sacarMedidas($id, $w, $h);
        $idy = preg_replace("/(.*v\=)(.+)(\&.+)?/", "$2", $m->edb_w1);
        //echo $m->edb_w1;
        //-----------------------
        $editor = '<div class="estadoarchivo paresizar"><span>' . $m->edb_w1 . '</span></div><img class="paresizar" src="' . $this->getURL("images/bg_video_facebook.jpg") . '" alt="Video"  />';
        //echo $m->edb_w3."YYYY";
        if ($m->edb_w3 != "") {
            $icorand = 'ico' . rand(0, 400000);
            $pub = '<script type="text/javascript">';
            $pub .= 'function ' . $icorand . '_click(a){' . "\n";
            $pub .= $icorand . '=\'<object width="' . $m->width . '" height="' . $m->height . '" ><param name="allowfullscreen" value="true" /><param name="wmode" value="transparent" /><param name="movie" value="http://www.facebook.com/v/' . $idy . '" /><embed src="http://www.facebook.com/v/' . $idy . '" type="application/x-shockwave-flash" allowfullscreen="true" width="' . $m->width . '" height="' . $m->height . '"></embed></object>\';' . "\n";
            $pub .= 'a.parentNode.innerHTML=' . $icorand . ";" . "\n";
            $pub .= '}' . "\n";
            $pub .= '</script>';
            $pub .= '<a href="#" onclick="' . $icorand . '_click(this);"><img src="' . $m->edb_w3 . '" style="width:' . $m->width . 'px;height:' . $m->height . 'px;"/></a>';
        }
        else
            $pub = '<object width="' . $m->width . '" height="' . $m->height . '" ><param name="allowfullscreen" value="true" /><param name="movie" value="http://www.facebook.com/v/' . $idy . '" /><param name="allowfullscreen" value="true" /><embed src="http://www.facebook.com/v/' . $idy . '" type="application/x-shockwave-flash" allowfullscreen="true" width="' . $m->width . '" height="' . $m->height . '"></embed></object>';
        if ($m->edb_w1 != "")
            $editor = $pub;
        $this->_guardarW($id, $editor, $this->_normalizar($pub));
        echo $editor;
        $this->_generar_otros($id);
    }

    /**
     * iframe
     */
    function w27($idfanpage, $id) {
        $m = $this->_sacarMedidas($id, $w, $h);
        $editor = '<img class="paresizar" src="' . $this->getURL("images/bg_iframe.jpg") . '" alt="Video"  />';
        $pub = '<iframe class="paresizar" src="' . $m->edb_w1 . '" frameborder="0" allowfullscreen style="border:none; width:' . $m->width . 'px; height:' . $m->height . 'px; z-index:' . $m->sp_1 . ';"/> ';
        if ($m->edb_w1 != "")
            $editor = $pub;
        $this->_guardarW($id, $editor, $pub);
        echo $editor;
        $this->_generar_otros($id);
    }

    /**
     * shape
     */
    function w29($idfanpage, $id) {
        $m = $this->_sacarMedidas($id, $w, $h);
        $editor = '
            <div class="shapetext paresizar" style="position:absolute; width:' . $m->width . 'px; height:' . $m->height . 'px;">' . $m->texto . '</div>
            <canvas width="' . $m->width . '" height="' . $m->height . '" class="paresizar shapedraw" style="position:relative!important; width:' . $m->width . 'px; height:' . $m->height . 'px; z-index:' . $m->sp_1 . '"></canvas>
            <script type="text/javascript">
                $("#' . $id . ' .shapedraw").shape(' . $m->edb_w1 . ',"' . $m->edb_w2 . '");
            </script>
            ';
        $this->_guardarW($id, $editor, $editor);
        echo $editor;
        $this->_generar_otros($id);
    }

    /**
     * contact form
     */
    function w30($idfanpage, $id) {
        $m = $this->_sacarMedidas($id, $w, $h);
        $marca = "x" . mktime() . rand(0, 400000);
        $cad.='';
        $pub = '';
        $pub.='
            <div id="' . $marca . '" style="overflow:hidden; background:' . $m->edb_w10 . ';">
                ' . ($m->edb_w3 != "" ? '<div class="cfdescription">' . $m->edb_w3 . '</div>' : '') . '
                <form id="form' . $marca . '" action="#" method="post">';
        $cad.='<div class="w30form" style="overflow:hidden; background:' . $m->edb_w10 . ';">
            ' . ($m->edb_w3 != "" ? '<div class="cfdescription">' . $m->edb_w3 . '</div>' : '');
        if ($m->edb_w4 == "1") {
            $pub.='<div class="cffila"><label>Name:</label>';
            $pub.='<input type="text" id="' . $marca . 'w4" class="required" rel="txt4" alt="Name"/>';
            $pub.='</div>';
            $cad.='<div class="cffila"><label>Name:</label>';
            $cad.='<div class="disqueinput"></div>';
            $cad.='</div>';
        }
        if ($m->edb_w5 == "1") {
            $pub.='<div class="cffila"><label>E-mail:</label>';
            $pub.='<input type="text" id="' . $marca . 'w5" class="required" rel="txt5" alt="E-mail"/>';
            $pub.='</div>';
            $cad.='<div class="cffila"><label>E-mail:</label>';
            $cad.='<div class="disqueinput"></div>';
            $cad.='</div>';
        }
        if ($m->edb_w10 == "1") {
            $pub.='<div class="cffila"><label>Phone:</label>';
            $pub.='<input type="text" id="' . $marca . 'w10" class="required" rel="txt10" alt="Phone"/>';
            $pub.='</div>';
            $cad.='<div class="cffila"><label>Phone:</label>';
            $cad.='<div class="disqueinput"></div>';
            $cad.='</div>';
        }
        if ($m->edb_w6 == "1") {
            $pub.='<div class="cffila"><label>Address:</label>';
            $pub.='<input type="text" id="' . $marca . 'w6" class="required" rel="txt6" alt="Address"/>';
            $pub.='</div>';
            $cad.='<div class="cffila"><label>Address:</label>';
            $cad.='<div class="disqueinput"></div>';
            $cad.='</div>';
        }
        if ($m->edb_w7 == "1") {
            $pub.='<div class="cffila"><label>Country:</label>';
            $pub.='<input type="text" id="' . $marca . 'w7" class="required" rel="txt7" alt="Country"/>';
            $pub.='</div>';
            $cad.='<div class="cffila"><label>Country:</label>';
            $cad.='<div class="disqueinput"></div>';
            $cad.='</div>';
        }
        if ($m->edb_w8 == "1") {
            $pub.='<div class="cffila"><label>City:</label>';
            $pub.='<input type="text" id="' . $marca . 'w8" class="required" rel="txt8" alt="City"/>';
            $pub.='</div>';
            $cad.='<div class="cffila"><label>City:</label>';
            $cad.='<div class="disqueinput"></div>';
            $cad.='</div>';
        }
        if ($m->edb_w9 == "1") {
            $pub.='<div class="cffila"><label>Comments:</label>';
            $pub.='<textarea id="' . $marca . 'w9" class="required" rel="txt9" alt="Comments"></textarea>';
            $pub.='</div>';
            $cad.='<div class="cffila"><label>Comments:</label>';
            $cad.='<div class="disqueinput disquearea"></div>';
            $cad.='</div>';
        }
        $pub.='<div class="cffila"><input type="submit" value="Send" />';
        $cad.='<div class="cffila"><div class="disquesubmit">Send</div></div>';
        $pub.='</div>';
        $pub .= '  </form>
            </div>';
        $cad.='</div>';
        $pub.='
            <script type="text/javascript">
                ajustes' . $marca . '={
                    "e2s":"' . $m->edb_w1 . '",
                    "e2r":"' . $m->edb_w2 . '"
                };
                $("#form' . $marca . '").contactForm(ajustes' . $marca . ');
                $("#' . $marca . '").parent().parent().height("auto");
            </script>';
        if ($m->edb_w1 != "" && $m->edb_w2 != "")
            $editor = $cad;
        else
            $editor = '<img src="' . $this->getURL("images/bg_contact.jpg") . '" class="paresizar"/>';
        $editor.='<script type="text/javascript">
                ' . $marca . 'fun=function(){
                    $("#' . $id . '").height("auto");
                    setTimeout(' . $marca . 'fun,200);
                }
                ' . $marca . 'fun();
            </script>';
        $this->_guardarW($id, $editor, $pub);
        echo $editor;
        $this->_generar_otros($id);
    }

    /**
     * skype
     */
    function w32($idfanpage, $id) {
        $m = $this->_sacarMedidas($id, $w, $h);
        $marca = str_replace("-", "", "x" . mktime() . rand(0, 40000));
        $editor = '';
        //edb_w1 = username
        //edb_w2 = skype status
        //edb_w3 = funcion
        //edb_w4 = foto
        $pub = '<script type="text/javascript" src="http://download.skype.com/share/skypebuttons/js/skypeCheck.js"></script>';
        $pub.='<a href="skype:' . $m->edb_w1 . '?' . $m->edb_w3 . '">';
        if (trim($m->edb_w4) == "") {
            switch (trim($m->edb_w2 . $m->edb_w3)) {
                case '1call':
                    $pub.='<img src="http://mystatus.skype.com/bigclassic/' . $m->edb_w1 . '" style="border: none;" width="' . $m->width . '" height="' . $m->height . '" alt="My status" />';
                    $editor.= '<img class="paresizar" src="http://mystatus.skype.com/bigclassic/' . $m->edb_w1 . '" style="border: none;" width="' . $m->width . '" height="' . $m->height . '" alt="My status" />';
                    break;
                case '0call':
                    $pub.='<img src="' . $this->getURL("images/call_green_white_124x52.png") . '" style="border: none;" width="' . $m->width . '" height="' . $m->height . '" alt="Skype Me™!" />';
                    $editor.='<img class="paresizar" src="' . $this->getURL("images/call_green_white_124x52.png") . '" style="border: none;" width="' . $m->width . '" height="' . $m->height . '" alt="Skype Me™!" />';
                    break;
                case '1add':
                    $pub.='<img src="http://mystatus.skype.com/bigclassic/' . $m->edb_w1 . '" style="border: none;" width="' . $m->width . '" height="' . $m->height . '" alt="My status" />';
                    $editor.='<img class="paresizar" src="http://mystatus.skype.com/bigclassic/' . $m->edb_w1 . '" style="border: none;" width="' . $m->width . '" height="' . $m->height . '" alt="My status" />';
                    break;
                case '0add':
                    $pub.='<img src="' . $this->getURL("images/add_green_white_194x52.png") . '" style="border: none;" width="' . $m->width . '" height="' . $m->height . '" alt="Add me to Skype" />';
                    $editor.='<img class="paresizar" src="' . $this->getURL("images/add_green_white_194x52.png") . '" style="border: none;" width="' . $m->width . '" height="' . $m->height . '" alt="Add me to Skype" />';
                    break;
            }
        } else {
            $pub.='<img src="' . $m->edb_w4 . '" style="border: none;" width="' . $m->width . '" height="' . $m->height . '" alt="My status" />';
            $editor = '<img class="paresizar" src="' . $m->edb_w4 . '" style="border: none;" width="' . $m->width . '" height="' . $m->height . '" alt="My status" />';
        }
        $pub.='</a>';
        $aux = '<script type="text/javascript">
                $("#' . $id . '").height("auto");
                $("#' . $id . '").width("auto");
            </script>';
        $pub.=$aux;
        $editor.=$aux;
        $this->_guardarW($id, $editor, $pub);
        echo $editor;
        $this->_generar_otros($id);
    }

    /**
     * yelp
     */
    function w33($idfanpage, $id) {
        $m = $this->_sacarMedidas($id, $w, $h);
        $business = str_replace("http://www.yelp.com/biz/", "", $m->edb_w1);
        $editor = '<img src="' . $this->getURL("images/bg_yelp.png") . '" class="paresizar"/>';
        $pub = '<iframe src="' . $this->getURL("widgets/yelp/yelp.php?business=" . $business) . '" frameborder="0" allowfullscreen style="border:none; width:100%; height:100%;"></iframe>';
        if ($m->edb_w1 != "") {
            $editor = $pub;
        }
        $this->_guardarW($id, $editor, $pub);
        echo $editor;
        $this->_generar_otros($id);
    }

    /**
     * scribd
     */
    function w34($idfanpage, $id) {
        $m = $this->_sacarMedidas($id, $w, $h);
        //http://es.scribd.com/doc/62604609/504v88n01a13134840pdf001
        $business = str_replace(array("http://es.scribd.com/doc/", "http://www.scribd.com/doc/"), "", $m->edb_w1);
        $business = "http://www.scribd.com/embeds/" . preg_replace("/(.+)\/(.+)/", "$1", $business) . "/content?start_page=1&view_mode=list";

        $editor = '<img src="' . $this->getURL("images/bg_scribd.jpg") . '" class="paresizar"/>';
        $pub = '<iframe src="' . $business . '" frameborder="0" allowfullscreen style="border:none; width:100%; height:100%;z-index:' . $m->sp_1 . ';" class="paresizar"></iframe>';
        if ($m->edb_w1 != "")
            $editor = $pub;
        $this->_guardarW($id, $editor, $pub);
        echo $editor;
        $this->_generar_otros($id);
    }

    /**
     * lastfm
     */
    function w35($idfanpage, $id) {
        $m = $this->_sacarMedidas($id, $w, $h);
        $marca = "x" . rand(0, 9999999) . mktime();
        /*
         * Your API Key is fd2ba71038ffd7e52a2419be379ba480
         * Your secret is 99aa25ccf65b0d32bf8310d91100cd1b
         */
        $editor = '<img src="' . $this->getURL("images/bg_lastfm.jpg") . '" class="paresizar" />';
        $pub = '<div id="' . $marca . '"></div>
            <script type="text/javascript">
                $.ajax({
                    url:"/widgets/lastfm.php?username=' . $m->edb_w1 . '",
                    success:function(data){
                        $("#' . $marca . '").html(data);
                    }
                });
                $("#' . $id . '").height("auto");
                $("#' . $id . '").width("auto");
            </script>';
        if ($m->edb_w1 != "")
            $editor = $pub;
        $this->_guardarW($id, $editor, $pub);
        $editor .= '
            <script type="text/javascript">
                ' . $marca . 'fun=function(){
                    $("#' . $id . '").height("auto");
                    setTimeout(' . $marca . 'fun,200);
                }
                ' . $marca . 'fun();
            </script>';
        echo $editor;
        $this->_generar_otros($id);
    }

    /**
     * digg
     */
    function w36($idfanpage, $id) {
        $m = $this->_sacarMedidas($id, $w, $h);
        $marca = "x" . rand(0, 9999999) . mktime();
        /*
         * Your API Key is fd2ba71038ffd7e52a2419be379ba480
         * Your secret is 99aa25ccf65b0d32bf8310d91100cd1b
         */
        $editor = '<img src="' . $this->getURL("images/bg_digg.jpg") . '" class="paresizar" style="width:' . $m->width . 'px;height:' . $m->height . 'px;" />';
        $pub = '<div id="' . $marca . '"></div>
            <script type="text/javascript">
                $.ajax({
                    url:"/widgets/digg.php?count=' . $m->edb_w1 . "&topic=" . $m->edb_w2 . '",
                    success:function(data){
                        $("#' . $marca . '").html(data);
                    }
                });
                $("#' . $id . '").height("auto");
                $("#' . $id . '").width("auto");
            </script>';
        $this->_guardarW($id, $editor, $pub);
        echo $editor;
        $this->_generar_otros($id);
    }

    /**
     * dailymotion
     */
    function w37($idfanpage, $id) {
        $m = $this->_sacarMedidas($id, $w, $h);
        $marca = "x" . rand(0, 9999999) . mktime();
        /*
         * Your API Key is fd2ba71038ffd7e52a2419be379ba480
         * Your secret is 99aa25ccf65b0d32bf8310d91100cd1b
         */
        $editor = '<img src="' . $this->getURL("images/bg_dailymotion-" . $_SESSION["lang"] . ".jpg") . '" class="paresizar" style="width:' . $m->width . 'px;height:' . $m->height . 'px;" />';
        //http://www.dailymotion.com/video/xkplxr_steve-jobs-lo-deja_tech#hp-sc-p-1
        $v1 = explode("#", str_replace("/video/", "/swf/video/", $m->edb_w1));
        $v2 = $v1[0] . "?" . implode("&", array(
                    "autoplay=" . $m->edb_w2,
                    "foreground=" . $m->edb_w3,
                    "background=" . $m->edb_w4,
                    "highlight=" . $m->edb_w5
                ));
        $pub = '
            <object width="100%" height="100%">
                <param name="movie" value="' . $v2 . '"></param>
                <param name="allowFullScreen" value="true"></param>
                <param name="allowScriptAccess" value="always"></param>
                <embed type="application/x-shockwave-flash" src="' . $v2 . '" width="100%" height="100%" allowfullscreen="true" allowscriptaccess="always"></embed>
            </object>
            ';
        if ($m->edb_w1 != "")
            $editor = $pub;
        $this->_guardarW($id, $editor, $pub);
        echo $editor;
        $this->_generar_otros($id);
    }

    /**
     * meetup
     */
    function w38($idfanpage, $id) {
        $m = $this->_sacarMedidas($id, $w, $h);
        $marca = "x" . rand(0, 9999999) . mktime();
        /*
         * Your API Key is 177365666a1c1b684168682d3351546f
         * http://www.meetup.com/Lima-Couture
         * (\#|\/)(.*)
         */
        $url = str_replace("http://www.meetup.com/", "", $m->edb_w1);
        $url = preg_replace("/(#|\/)(.*)/", "", $url);
        $editor = '<img src="' . $this->getURL("images/bg_meetup.jpg") . '" class="paresizar" style="width:' . $m->width . 'px;height:' . $m->height . 'px;" />';

        $pub = '<div id="' . $marca . '"></div>
            <script type="text/javascript">
                $.ajax({
                    url:"/widgets/meetup.php?group=' . $url . "&color1=" . urlencode($m->edb_w2) . "&color2=" . urlencode($m->edb_w3) . '",
                    success:function(data){
                        $("#' . $marca . '").html(data);
                    }
                });
                $("#' . $id . '").height("auto");
                $("#' . $id . '").width("auto");
            </script>';
        if ($m->edb_w1)
            $editor = $pub;
        $editor .= '
            <script type="text/javascript">
                ' . $marca . 'fun=function(){
                    $("#' . $id . '").width("auto");
                    $("#' . $id . '").height("auto");
                    setTimeout(' . $marca . 'fun,200);
                }
                ' . $marca . 'fun();
            </script>';
        $this->_guardarW($id, $editor, $pub);
        echo $editor;
        $this->_generar_otros($id);
    }

    /**
     * zillow
     */
    function w39($idfanpage, $id) {
        $m = $this->_sacarMedidas($id, $w, $h);
        $marca = "x" . rand(0, 9999999) . mktime();
        $editor = '<img src="' . $this->getURL("images/bg_zillow.jpg") . '" class="paresizar" style="width:' . $m->width . 'px;height:' . $m->height . 'px;" />';
        $pub = '
            <div id="my-listings-no-picture" class="zillow-widget" style="width:' . abs(round($m->width)) . 'px;height:358px;overflow:hidden;background-color:#eff3ff;border:1px solid #adcfff;line-height:13px;color:#555;font:normal normal normal 12px verdana,arial,sans-serif;text-align:left;text-transform:none;text-indent:0;letter-spacing:0;">
                <div id="title" style="margin:5px 0 0 5px;overflow:hidden;height:35px;">
                    <div style="margin:0;height:14px;overflow:hidden;">
                        <a href="https://www.zillow.com/profile/' . $m->edb_w1 . '/#{scid=gen-wid-list&scrnnm=' . $m->edb_w1 . '}" target="_blank" style="color:#3366bb;font-size:12px;font-weight:bold;font-style:normal;padding:0;text-decoration:none;">' . $m->edb_w1 . '</a>
                    </div>
                    <div class="business-name-container" style="height:14px;overflow:hidden;margin:0;">
                        <span style="font-size: 10px;font-weight:normal;color:gray;"> </span>
                    </div>
                </div>
                <iframe frameborder="0" height="' . (abs(round($m->height)) - 114) . '" style="display:block;" scrolling="no" width="' . abs(round($m->width)) . '" src="http://www.zillow.com/widgets/profile/NewListingsWidget.htm?aid=X1-ZUz8ya0f976wi1_89sjt"></iframe>
                <div id="widget-footer" style="height:73px;overflow:hidden;border-top:1px solid #adcfff;">
                    <div class="action-link-conatiner" style="height:28px;overflow:hidden;margin:7px 0 0 5px;">
                        <img src="http://www.zillow.com/widgets/GetVersionedResource.htm?path=/static/images/widgets/link-zbt.gif" style="display:inline;height:11px;overflow:hidden;vertical-align:bottom;"/>
                        <a href="http://www.zillow.com/profile/' . $m->edb_w1 . '/#{scid=gen-wid-list&scrnnm=' . $m->edb_w1 . '}" target="_blank" style="display:inline;text-decoration:underline;color:#3366bb;" class="action-link">
                            <span class="action-link-text" style="font-style:normal;font-weight:normal;font-size:11px;">See ' . $m->edb_w1 . '\'s listings</span>
                        </a>
                    </div>
                    <div class="more-get-links-container" style="text-align:center;margin:5px 0 5px 0;">
                        <div style="height:17px;overflow:hidden;">
                            <a href="http://www.zillow.com/#{scid=gen-wid-list&scrnnm=' . $m->edb_w1 . '}" target="_blank" style="color:#3366bb;font-size:11px;font-weight:normal;font-style:normal;text-decoration:none;">
                                <img src="http://www.zillow.com/widgets/GetVersionedResource.htm?path=/static/images/logo_zillow_small.gif" alt="Zillow Real Estate" style="border:0 none;height:17px;"/>
                            </a>
                        </div>
                        <div class="get-link-container">
                            <a href="http://www.zillow.com/webtools/widgets/MyListingsWidget.htm#{scid=gen-wid-list&scrnnm=' . $m->edb_w1 . '}" target="_blank" style="color:gray;font-size:10px;font-weight:normal;font-style:normal;text-decoration:none;">Get this widget</a>
                        </div>
                    </div>
                </div>
            </div>
            ';
        $this->_guardarW($id, $editor, $pub);
        echo $editor;
        $this->_generar_otros($id);
    }

    /**
     * countdown
     */
    function w40($idfanpage, $id) {
        $m = $this->_sacarMedidas($id, $w, $h);
        $marca = "x" . rand(0, 9999999) . mktime();
        $editor = '<div id="' . $marca . '" style="padding:5px; background:' . $m->edb_w2 . '; color:' . $m->edb_w3 . '; overflow:hidden; line-height:100%; float:left; width:100%; text-align:center;">0 days 00:00:00</div>
        <script type="text/javascript">
            ' . $marca . 'cambio=function(){
                a=$("#' . $id . '").height();
                $("#' . $marca . '").css({
                    "font-size":(a-10>60?60:a-10),
                    "font-family":"Verdana",
                    "font-weight":"bold"
                });
                $("#' . $id . '").height("auto");
                setTimeout(' . $marca . 'cambio,450);
            }
            ' . $marca . 'cambio();            

        </script>';
        $x = explode("/", $m->edb_w1);
        $f2 = mktime($m->edb_w4, $m->edb_w5, 0, $x[0], $x[1], $x[2]);
        $f1 = $f2 - mktime();
        $cad = '';
        $pub = '
            <style type="text/css">
                #' . $marca . ' *{
                    background:' . $m->edb_w2 . ';
                    color:' . $m->edb_w3 . '!important; 
                    overflow:hidden;
                    font-size:130%!important;
                    line-height:150%!important;
                    float:left;
                    width:100%;
                    text-align:center;
                    
                }
                #' . $id . '{
                    height:auto!important;
                }
            </style>
        <div id="' . $marca . '" time="' . $f2 . '" class="kkcount-down"></div>
        <script type="text/javascript">
            hacer' . $marca . '=function(){
                $("#' . $marca . '").kkCountDown("' . $f2 . '");
            }
            if(!$("#' . $marca . '").kkCountDown){
                $.getScript("' . $this->getURL("js/jquery.countdown.js") . '", function(){
                    hacer' . $marca . '();
                });
            }else
                hacer' . $marca . '();
        </script>
        ';
        if ($m->edb_w1 != "") {
            $editor = $pub;
        }
        $this->_guardarW($id, $editor, $pub);
        echo $editor;
        $this->_generar_otros($id);
    }

    /**
     * ebay
     */
    function w41($idfanpage, $id) {
        $m = $this->_sacarMedidas($id, $w, $h);
        $marca = "x" . rand(0, 9999999) . mktime();
        $pub = '<object width="' . $m->width . '" height="' . $m->height . '"><param name="wmode" value="transparent" /><param name="movie" value="http://togo.ebay.com/togo/seller.swf?2008013100" /><param name="flashvars" value="base=http://togo.ebay.com/togo/&lang=en-us&seller=' . $m->edb_w1 . '" /><embed src="http://togo.ebay.com/togo/seller.swf?2008013100" type="application/x-shockwave-flash" width="' . $m->width . '" height="' . $m->height . '" flashvars="base=http://togo.ebay.com/togo/&lang=en-us&seller=' . $m->edb_w1 . '"></embed></object>';
        if ($m->edb_w1 == "")
            $editor = '<img src="' . $this->getURL("images/bg_ebay.jpg") . '" class="paresizar" style="width:' . $m->width . 'px; height:' . $height . 'px;" />';
        else
            $editor = '<object width="100%" height="100%"><param name="movie" value="http://togo.ebay.com/togo/seller.swf?2008013100" /><param name="wmode" value="transparent" /><param name="flashvars" value="base=http://togo.ebay.com/togo/&lang=en-us&seller=' . $m->edb_w1 . '" /><embed src="http://togo.ebay.com/togo/seller.swf?2008013100" type="application/x-shockwave-flash" width="100%" height="100%" flashvars="base=http://togo.ebay.com/togo/&lang=en-us&seller=' . $m->edb_w1 . '"></embed></object>';
        $this->_guardarW($id, $editor, $pub);
        echo $editor;
        $this->_generar_otros($id);
    }

    /**
     * slideshare
     */
    function w42($idfanpage, $id) {
        $m = $this->_sacarMedidas($id, $w, $h);
        $marca = "x" . rand(0, 9999999) . mktime();
        $editor = '<img src="' . $this->getURL("images/bg_slideshare.jpg") . '" class="paresizar" style="width:' . $m->width . 'px; height:' . $m->height . 'px;" />';

        $apikey = "Jb5sYTIp";
        $secret = "USSzvzl2";
        $ts = mktime();
        $url = "http://www.slideshare.net/api/2/get_slideshow";
        $attachment = array(
            "api_key" => $apikey,
            "ts" => $ts,
            "hash" => sha1($secret . $ts),
            "slideshow_url" => $m->edb_w1,
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($attachment));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  //to suppress the curl output 
        $result = curl_exec($ch);
        curl_close($ch);

        $x = new DOMDocument("1.0", "utf-8");
        $x->loadXML($result);
        $r = $x->getElementsByTagName("ID");

        $pub = '<iframe src="http://www.slideshare.net/slideshow/embed_code/' . $r->item(0)->nodeValue . '" frameborder="0" marginwidth="0" marginheight="0" scrolling="no" style="width:100%;height:100%;"></iframe>';

        if ($m->edb_w1 != "") {
            $editor = $pub;
        }

        $this->_guardarW($id, $editor, $pub);
        echo $editor;
        $this->_generar_otros($id);
    }

    /**
     * linkedin apply
     */
    function w43($idfanpage, $id) {
        $m = $this->_sacarMedidas($id, $w, $h);
        $marca = "x" . rand(0, 9999999) . mktime();

        $companyid = explode("?", str_replace("http://www.linkedin.com/company/", "", cleancs($m->edb_w1)));

        $pub = '
            <script type="text/javascript" src="http://platform.linkedin.com/in.js">
              api_key: 6o0os289g2q5
            </script>';
        $pub.='
            <script type="IN/Apply" data-companyid="' . $companyid[0] . '" data-jobtitle="' . cleancs($m->edb_w3) . '" data-joblocation="' . cleancs($m->edb_w4) . '" data-logo="' . cleancs($m->edb_w5) . '" data-themecolor="' . cleancs($m->edb_w6) . '" data-email="' . strip_tags($m->edb_w2) . '"></script>
        ';
        if ($m->edb_w1 != "") {
            $editor = $pub;
        } else {
            $editor = '<img src="' . $this->getURL("images/bg_linkedinapply.jpg") . '" />';
        }
        $editor.='<script type="text/javascript">
                ' . $marca . 'fun=function(){
                    $("#' . $id . '").width("auto");
                    $("#' . $id . '").height("auto");
                    setTimeout(' . $marca . 'fun,200);
                }
                ' . $marca . 'fun();
            </script>';
        $this->_guardarW($id, $editor, $pub);
        echo "You need to refresh your <br/>
              page to see the changes";
        $this->_generar_otros($id);
    }

    /**
     * linkedin user profile
     */
    function w44($idfanpage, $id) {
        $m = $this->_sacarMedidas($id, $w, $h);
        $marca = "x" . rand(0, 9999999) . mktime();

        $pub = '
            <script src="http://platform.linkedin.com/in.js" type="text/javascript">
            api_key: 6o0os289g2q5
            </script>
            <script type="IN/MemberProfile" data-id="' . cleancs($m->edb_w1) . '" data-format="inline"></script>
            <script type="text/javascript">
                $("#' . $id . '").width("auto");
                $("#' . $id . '").height("auto");
            </script>';

        if ($m->edb_w1 != "") {
            $editor = $pub;
        } else {
            $editor = '<img src="' . $this->getURL("images/bg_linkedinuserprofile.jpg") . '" />';
        }

        $editor .= '
            <script type="text/javascript">
                ' . $marca . 'fun=function(){
                    $("#' . $id . '").width("auto");
                    $("#' . $id . '").height("auto");
                    setTimeout(' . $marca . 'fun,200);
                }
                ' . $marca . 'fun();
            </script>';

        $this->_guardarW($id, $editor, $pub);
        echo "You need to refresh your <br/>
              page to see the changes";
        ;
        $this->_generar_otros($id);
    }

    /**
     * linkedin company profile
     */
    function w45($idfanpage, $id) {
        $m = $this->_sacarMedidas($id, $w, $h);
        $marca = "x" . rand(0, 9999999) . mktime();

        $companyid = explode("?", str_replace("http://www.linkedin.com/company/", "", cleancs($m->edb_w1)));

        $pub = '
            <script src="http://platform.linkedin.com/in.js" type="text/javascript">
                api_key: 6o0os289g2q5            
            </script>
            <script type="IN/CompanyProfile" data-id="' . $companyid[0] . '" data-format="inline" data-related="false"></script>
            <script type="text/javascript">
                $("#' . $id . '").width("auto");
                $("#' . $id . '").height("auto");
            </script>
            ';

        if ($m->edb_w1 != "") {
            $editor = $pub;
        } else {
            $editor = '<img src="' . $this->getURL("images/bg_linkedincompanyprofile.jpg") . '" />';
        }

        $editor .= '
            <script type="text/javascript">
                ' . $marca . 'fun=function(){
                    $("#' . $id . '").width("auto");
                    $("#' . $id . '").height("auto");
                    setTimeout(' . $marca . 'fun,200);
                }
                ' . $marca . 'fun();
            </script>';

        $this->_guardarW($id, $editor, $pub);
        echo "You need to refresh your <br/>
              page to see the changes";
        $this->_generar_otros($id);
    }

    /**
     * product
     */
    function w46($idfanpage, $id) {
        $m = $this->_sacarMedidas($id, $w, $h);
        $marca = "x" . rand(0, 9999999) . mktime();
        $editor = '<img src="' . $this->getURL("images/bg_product.jpg") . '" class="paresizar" style="width:' . $m->width . 'px; height:' . $m->height . 'px;" />';

        $pub = '
            <div style="float:left; width:100%; overflow: hidden; border:1px solid ' . $m->edb_w5 . '">
                <img src="' . $m->edb_w2 . '" width="100%" />
            </div>
            <div class="txttitlecs" style="float:left;width:100%;padding: 5px;text-align: left;color:' . $m->edb_w5 . ';">' . $m->edb_w1 . '</div>
            <div class="txtpricecs" style="float:left;width:100%;padding: 5px;text-align: left;color:' . $m->edb_w7 . '">' . $m->edb_w3 . '</div>
            <div style="float:left;width:100%;text-align:center;clear:both;"><a target="_blank" href="' . $m->edb_w4 . '" class="btnproductcs" style="padding: 5px 10px;border: 1px solid black;line-height:24px; font-family: Arial; font-weight:bold; font-family: Arial;text-align: center;background: ' . $m->edb_w8 . ' url(' . $this->getURL("images/btn_buy.png") . ') repeat-x;font-size: 18px;text-decoration: none; color:' . $m->edb_w6 . ';">Buy Now</a></div>';
        $editor .= '
            <script type="text/javascript">
                ' . $marca . 'fun=function(){
                    $("#' . $id . '").height("auto");
                    setTimeout(' . $marca . 'fun,200);
                }
                ' . $marca . 'fun();
            </script>';
        $this->_guardarW($id, $editor, $pub);
        if ($m->edb_w1 != "") {
            $editor = $pub;
        }
        echo $editor;
        $this->_generar_otros($id);
    }

    /**
     * mail chimp
     */
    function w47($idfanpage, $id) {
        $m = $this->_sacarMedidas($id, $w, $h);
        $marca = "x" . rand(0, 9999999) . mktime();
        $editor = '<img src="' . $this->getURL("images/bg_product.jpg") . '" class="paresizar" style="width:' . $m->width . 'px; height:' . $m->height . 'px;" />';

        $pub = '
            <div id="'.$marca.'" class="w30form">
                <form id="frm'.$marca.'">
                    <div class="cfdescription"><strong>' . $m->edb_w1 . '</strong></div>
                    <div class="cffila" style="border-bottom:1px solid #cececf;"><label>' . $m->edb_w2 . '</label></div>
                    <div class="cffila" style="padding-right:2px;">
                        <label>Your Mail:</label>
                        <input type="text" id="' . $marca . 'w1" class="required" rel="txt1" style="width:100%;" />
                    </div>
                    <div class="cffila">
                        <input type="submit" value="Subscribe" class="disquesubmit" />
                    </div>
                </form>
                <script type="text/javascript">
                    $("#frm'.$marca.'").submit(function(){
                        if($("#'.$marca.'w1").val()!=""){
                            $.ajax({
                                url:"'.$this->getURL("tabs/processChimp/".  urlencode($id)).'",
                                data:"mail="+encodeURIComponent($("#'.$marca.'w1").val()),
                                type:"POST",
                                success:function(data){
                                    if(data.indexOf("okok")==-1){
                                        alert(data);
                                    }
                                    else{
                                        alert("You have successfully subscribed.");
                                    }
                                }
                            });
                        }
                        return false;
                    });
                </script>
            </div>
        ';
        if($m->edb_w3)
            $editor = $pub;
        $editor .= '
            <script type="text/javascript">
                ' . $marca . 'fun=function(){
                    $("#' . $id . '").height("auto");
                    setTimeout(' . $marca . 'fun,200);
                }
                ' . $marca . 'fun();
            </script>';
        $this->_guardarW($id, $editor, $pub);
        if ($m->edb_w1 != "") {
            $editor = $pub;
        }
        echo $editor;
        $this->_generar_otros($id);
    }

    /**
     * grupon, solo para USA
     */
    function w48($idfanpage, $id) {
        $m = $this->_sacarMedidas($id, $w, $h);
        $marca = "x" . rand(0, 9999999) . mktime();
        $editor = '<img src="http://groupon-latam.s3.amazonaws.com/groupon-web.png" class="paresizar" style="width:' . $m->width . 'px; height:' . $m->height . 'px;" />';
        $pub='';
        if($m->edb_w1!=""){
            $x=explode("?",$m->edb_w1);
            $y=explode("/",str_replace("http://www.groupon.com/deals/","",$x[0]));
            $url=$y[0];
            $pub='
                <div class="contw48" id="'.$marca.'">
                    <a href="" target="_blank" class="w48title"></a>
                    <img src="" class="w48image"/>
                    <div class="w48col1">
                        <div class="w48price_tag_inner">
                            <div class="w48amount"><span class="price_label">from</span><span class="w48precioreal">$</span></div>
                            <a target="_blank" href="" class="w48buy_btn">Buy</a>
                        </div>
                        <div class="w48col1_1">
                            <div class="w48preciocont">
                                <div class="w48p1">Value<br><span></span></div>
                                <div class="w48p2">Discount<br/><span></span></div>
                                <div class="w48p3">You Save<br/><span></span></div>
                            </div>
                            <div class="w48expire">
                                <img alt="Hourglasssoldout" class="w48hourglass" src="http://assets2.grouponcdn.com/images/groupon/icons/hourglass/hourglass003.gif?1DpNRbFz">
                                Expires At:<br/>
                                <span></span>
                            </div>
                        </div>
                    </div>
                    <div class="w48col2">
                        <span class="w48c2_1"></span>
                        <hr/>
                        <span class="w48c2_2"></span>
                    </div>
                </div>
                <script type="text/javascript">
                    $.ajax({
                        url:"'.$this->getURL("widgets/grupon.php?url=".$url).'",
                        dataType:"json",
                        success:function(data){
                            data=data.deal;
                            marca=$("#'.$marca.'");
                            marca.find(".w48title").attr("href",data.dealUrl);
                            marca.find(".w48title").html(data.merchant.name);
                            marca.find(".w48image").attr("src", data.largeImageUrl);
                            marca.find(".w48buy_btn").attr("href", data.options[0].buyUrl)
                            marca.find(".w48amount .w48precioreal").html("$"+(data.options[0].price.amount/100));
                            marca.find(".w48p1 span").html("$"+(data.options[0].value.amount/100));
                            marca.find(".w48p2 span").html(data.options[0].discountPercent+"%");
                            marca.find(".w48p3 span").html(data.options[0].discount.amount/100);
                            marca.find(".w48expire span").html(data.options[0].expiresAt.split("T").join(" ").split("Z").join(" "));
                            marca.find(".w48c2_1").html(data.highlightsHtml);
                            marca.find(".w48c2_2").html(data.finePrint);
                        }
                    });
                </script>
            ';
            $pub .= '
            <script type="text/javascript">
                ' . $marca . 'fun=function(){
                    $("#' . $id . '").width("auto");
                    $("#' . $id . '").height("auto");
                    setTimeout(' . $marca . 'fun,200);
                }
                ' . $marca . 'fun();
            </script>';
            $editor = $pub;
        }
        $this->_guardarW($id, $editor, $pub);
        echo $editor;
        $this->_generar_otros($id);
    }

    /**
     * contest concurso competition
     */
    function w49($idfanpage, $id){
        $m = $this->_sacarMedidas($id, $w, $h);
        $marca = "x" . rand(0, 9999999) . mktime();
        $editor = '<img src="' . $this->getURL("images/bg_contest.jpg") . '" class="paresizar" style="width:' . $m->width . 'px; height:' . $m->height . 'px;" />';

        $pub = '
            <div class="contest" id="'.$marca.'"></div>
            <script type="text/javascript">
                $.ajax({
                    url:"'.$this->getURL("tabs/wcontest/".$id).'",
                    success:function(data){
                        $("#'.$marca.'").html(data);
                    }
                });
            </script>
            ';
        if($m->edb_w1)
            $editor = $pub;
        $editor .= '
            <script type="text/javascript">
                ' . $marca . 'fun=function(){
                    $("#' . $id . '").height("auto");
                    $("#' . $id . '").width("auto");
                    setTimeout(' . $marca . 'fun,200);
                }
                ' . $marca . 'fun();
            </script>';
        $this->_guardarW($id, $editor, $pub);
        if ($m->edb_w1 != "") {
            $editor = $pub;
        }
        echo $editor;
        $this->_generar_otros($id);
    }
    
    function fbsetsettings($id) {
        echo $id;
        $db = $this->dbInstance();
        $sql = "select * from #_tab where uid='" . $_SESSION["fbconexion"]["id"] . "' and id=" . intval($id);
        if (count($db->loadObjectList($sql)) > 0) {
            $s = urlencode(json_encode($_POST));
            echo "$s";
            $db->update("#_tab", array(
                "settings" => $s
                    ), "uid='" . $_SESSION["fbconexion"]["id"] . "' and id=" . intval($id));
        }
    }

    function fbsetclone($id) {
        //primero inserto los widgets
        $db = $this->dbInstance();
        //esto es del lado de la fuente
        $sql = "select * from #_tab where id=" . intval($id) . " and uid='" . $_SESSION["fbconexion"]["uid"] . "'";
        $tab = $db->loadObjectRow($sql);
        $sql = "select * from #_widgeted where marca in ('" . str_replace(",", "','", $tab->estructura) . "')";
        $widgets = $db->loadObjectList($sql);
        //del lado del destino
        $sql = "select * from #_tab where id=" . intval($_POST["edb_w2"]) . " and uid='" . $_SESSION["fbconexion"]["uid"] . "'";
        $dtab = $db->loadObjectRow($sql);
        $db->delete("#_widgeted", "marca in ('" . str_replace(",", "','", $dtab->estructura) . "')");
        $idw = 0;
        $pw = array();
        foreach ($widgets as $w) {
            $idw++;
            $db->insert("#_widgeted", array(
                "marca" => $w->marca . $idw,
                "estructura" => $w->estructura,
                "contenido_ed" => $this->_normalizar($w->contenido_ed),
                "contenido_prod" => $this->_normalizar($w->contenido_prod),
            ));
            $pw[] = $w->marca . $idw;
        }
        $db->update("#_tab", array(
            "settings" => $tab->settings,
            "settings_pub" => $tab->settings_pub,
            "contenido_ed" => $contenido_ed,
            "estructura" => implode(",", $pw),
                ), "id=" . intval($_POST["edb_w2"]) . " and uid='" . $_SESSION["fbconexion"]["uid"] . "'");
        echo $this->getURL("fbconexion/page/" . $dtab->id);
    }

}
?>
