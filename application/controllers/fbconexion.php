<?php

class Cfbconexion extends application {

    function __construct() {
        parent::__construct();
        $this->checkSession();
    }

    function normalizar($valor) {
        $valor = str_replace("\'", "'", $valor);
        $valor = str_replace("'", "\'", $valor);
        return $valor;
    }

    function setmail(){
        if($_SESSION["fbconexion"] && trim($_POST["mail"])!=""){
            $db=$this->dbInstance();
            if(preg_match("/(.[^ ]+)@(.[^ ]+)\.(.*)/", $_POST["mail"])>0){
                $db->update("#_usuario",array(
                    "email"=>  mysql_escape_string($_POST["mail"])
                ), "uid='".$_SESSION["fbconexion"]["uid"]."'");
            }
        }
    }
    
    /**
     * paso1
     */
    function index() {
        $db = $this->dbInstance();
        $db->debug(2);
        $fql = "select page_id,name from page where page_id in (select page_id from page_admin where uid='" . $_SESSION["fbconexion"]["uid"] . "') and type <> 'APPLICATION' order by page_id asc";
        $this->params["pags"] = $this->fb->fqlQuery($fql);
        $sql = "select * from #_plan_pagina where uid='" . $_SESSION["fbconexion"]["uid"] . "'";
        $pp = $db->loadObjectList($sql);
        $this->params["freepremium"] = $_SESSION["fbconexion"]["pages"] - count($pp);
        $sql = "select #_tab.*,#_aplicacion.nombre as nombreapp from #_tab inner join #_aplicacion on #_tab.idapp=#_aplicacion.id where #_tab.uid='" . $_SESSION["fbconexion"]["uid"] . "' order by idpagina asc";
        $this->params["tabs"] = $db->loadObjectList($sql);
        $sql = "select * from #_aplicacion where visible=1 and idioma='" . $_SESSION["lang"] . "' order by nombre";
        $this->params["apps"] = $db->loadObjectList($sql);
        $this->params["upgraded"] = $pp;
        $this->params["scripts"][] = "jquery.dd.js";
        $this->params["css"][] = "dd.css";
        $this->params["hayzopim"] = false;
        
        $this->loadHtml("intranet1.php", $this->params);
    }

    /**
     * TODO la primera pantalla del cupon
     */
    function coupon($id, $pag=1) {
        $db = $this->dbInstance();
        $sql = "select * from #_tab where uid=" . $_SESSION["fbconexion"]["uid"] . " and id=" . intval($id);
        $res = $db->loadObjectList($sql);
        if (!$id || count($res) != 1) {
            $this->redirect(LANG . "/fbconexion");
        } else {
            if ($res[0]->idapp != 10 && $res[0]->idapp != 31)
                $this->redirect(LANG . "/fbconexion/page/$id");
            else {
                if ($pag == 1) {
                    if ($_POST["cou1"] != "") {
                        $db->update("#_tab", array(
                            "settings" => json_encode(array(
                                "pagetitle" => urlencode(trim($_POST["cou1"])),
                                "pagedesc" => urlencode(trim($_POST["cou2"])),
                                "topbarcolor" => urlencode(trim($_POST["cou3_1"])),
                                "couponscolor" => urlencode(trim($_POST["cou3_2"])),
                                "buttoncolor" => urlencode(trim($_POST["cou3_3"])),
                                "topbarfont" => urlencode(trim($_POST["cou3_4"])),
                                "couponsfont" => urlencode(trim($_POST["cou3_5"])),
                                "buttonfont" => urlencode(trim($_POST["cou3_6"])),
                            ))
                                ), "id=$id");
                        $this->redirect(LANG . "fbconexion/coupon/$id/2");
                    }
                    $this->params["data"] = json_decode($res[0]->settings);
                    //$this->params["scripts"][] = "../tiny_mce/tiny_mce.js";
                    $this->params["scripts"][] = "colorpicker.js";
                    $this->params["css"][] = "colorpicker.css";

                    $this->loadHtml("coupon1.php", $this->params);
                } else {
                    $sql = "select * from #_coupon where idtab=$id order by id desc";
                    $this->params["tab"] = $res[0];
                    $this->params["coupons"] = $db->loadObjectList($sql);
                    //$this->params["scripts"][] = "../tiny_mce/tiny_mce.js";
                    $this->params["scripts"][] = "http://www.tinymce.com/js/tinymce/jscripts/tiny_mce/tiny_mce.js";
                    $this->loadHtml("coupon2.php", $this->params);
                }
            }
        }
    }

    /**
     * agrega un nuevo tab
     */
    function addTab($idpag) {
        $idpag = mysql_escape_string($idpag);
        $db = $this->dbInstance();
        $db->debug(2);
        $permitido = true;
        if ($_SESSION["fbconexion"]["idplan"] == 1 || $_SESSION["fbconexion"]["INTROFB"]) {
            $sql = "select count(*) from #_tab where idpagina='$idpag' and uid='" . $_SESSION["fbconexion"]["uid"] . "'";
            if (intval($db->loadResult($sql)) >= 1) {
                $permitido = false;
            }
        }
        $permitido = true;
        if ($permitido) {
            $db->insert("#_tab", array(
                "uid" => $_SESSION["fbconexion"]["uid"],
                "espremium" => "0",
                "idapp" => intval($_POST["idapp"]),
                "idpagina" => htmlspecialchars($idpag),
                "fechains" => date("Y-m-d H:i:s")
            ));
            if ($_POST["idapp"] != 10 && $_POST["idapp"] != 31)
                echo $this->getURL(LANG . "fbconexion/page/" . $db->insertid());
            else
                echo $this->getURL(LANG . "fbconexion/coupon/" . $db->insertid());
        }else {

            echo "nada de tabs";
        }
    }

    function deletePage($idtab) {
        $db = $this->dbInstance();
        $db->delete("#_tab", "id=" . intval($idtab) . " and uid=" . $_SESSION["fbconexion"]["uid"]);
        if (!$db->getErrorMsg()) {
            echo "ok";
        }
    }

    function cleanPage($idtab) {
        $db = $this->dbInstance();
        $db->debug(2);
        $sql = "select * from #_tab where id=" . intval($idtab);
        $r = $db->loadObjectRow($sql);
        if ($r->estructura != "") {
            $sql = "delete from #_widgeted where marca in ('" . str_replace(",", "','", $r->estructura) . "')";
            $db->setQuery($sql);
            $db->query();
        }
        $sql = "update #_tab set settings='', estructura='' where id=" . intval($idtab);
        echo $sql;
        $db->setQuery($sql);
        $db->query();
    }

    function removeWidget($idtab, $idwidget) {
        echo $idwidget;
        $db = $this->dbInstance();
        $sql = "select estructura from #_tab where id=" . intval($idtab) . " and uid=" . $_SESSION["fbconexion"]["uid"];
        $widgets = explode(",", $db->loadResult($sql));
        if (in_array($idwidget, $widgets)) {
            print_r($db->loadObjectList("select * from #_widgeted where marca='" . $idwidget . "'"));
            $db->delete("#_widgeted", "marca='" . $idwidget . "'");
        }
    }

    /**
     * paso2
     */
    function page($id=null) {
        $db = $this->dbInstance();
        $sql = "select idapp from #_tab where uid=" . $_SESSION["fbconexion"]["uid"] . " and id=" . intval($id);
        $res = $db->loadResult($sql);
        if (!$id || count($res) != 1) {
            $this->redirect(LANG . "/fbconexion");
        } else {
            if ($res[0]->idapp == 10)
                $this->redirect(LANG . "/fbconexion/coupon/$id");
            else {
                $this->params["hayzopim"]=false;
                $this->params["idobj"] = $id;
                $sql = "select a.*,b.nombre as appname,b.appid from #_tab a inner join #_aplicacion b on a.idapp=b.id where a.uid=" . $_SESSION["fbconexion"]["id"] . " and a.id=" . intval($id);
                $this->params["registro"] = $db->loadObjectRow($sql);
                if ($this->params["registro"]->estructura == "" && $this->params["registro"]->settings == "") {
                    //quiere decir que es nuevo
                    $this->params["esnuevo"] = true;
                }
                //ya tengo el nombre del tab, ahora saco el nombre de la pagina
                $res = $this->fb->fqlQuery("select name from page where page_id='" . $this->params["registro"]->idpagina . "'");
                $this->params["registro"]->nompagina = $res[0]["name"];
                $pp = $db->loadResult("select count(*) from #_plan_pagina where id_pagina='" . $this->params["registro"]->idpagina . "' and uid='" . $_SESSION["fbconexion"]["uid"] . "'");
                if ($pp > 0) {
                    $this->params["registro"]->espremium = $_SESSION["fbconexion"]["idplan"];
                } else {
                    $this->params["registro"]->espremium = 1;
                }
                $this->params["settings"] = json_decode(rawurldecode($this->params["registro"]->settings));
                $this->params["pagina"] = json_decode(file_get_contents("https://graph.facebook.com/" . $this->params["registro"]->idpagina . "?access_token=" . $_SESSION["fbconexion"]["access_token"]));
                //$this->debug($this->params["pagina"]);
                //carga de widgets
                //$sql = "select * from #_widgeted where marca in ('".str_replace(",","','",$this->params["registro"]->estructura)."')";
                $inicio = "select * from #_widgeted where marca = '";
                $fin = "' ";
                $sql = $inicio . str_replace(",", $fin . " union " . $inicio, $this->params["registro"]->estructura) . $fin;
                $this->params["widgets"] = $db->loadObjectList($sql);
                //carga de scripts
                //$this->params["scripts"][] = "../ckeditor/ckeditor.js";
                //$this->params["scripts"][] = "http://ckeditor.com/apps/ckeditor/3.6.1/ckeditor.js?1314724611";
                $this->params["scripts"][] = "../tiny_mce/tiny_mce.js";
                $this->params["scripts"][] = "jquery.ui.touch-punch.js";
                $this->params["scripts"][] = "colorpicker.js";
                $this->params["scripts"][] = "jQuery.gradient.js";
                $this->params["scripts"][] = "jquery.shape.js";
                $this->params["scripts"][] = "canvas.js";
                $this->params["css"][] = "editor.css";
                $this->params["css"][] = "filemanager.css";
                $this->params["css"][] = "colorpicker.css";
                $this->params["css"][] = "colorpicker.css";
                $this->loadHtml("intranet2.php", $this->params);
            }
        }
    }

    function saveTab($idtab) {
        $db = $this->dbInstance();
        $sql = "select count(*) from #_tab where uid='" . $_SESSION["fbconexion"]["uid"] . "' and id=" . intval($idtab);
        if ($db->loadResult($sql) == 1) {
            $db->update("#_tab", array(
                //"contenido_ed" => $_POST["body"],
                "estructura" => $_POST["estructura"]
                    ), "id=" . intval($idtab));
            if (!$db->getErrorMsg())
                echo "ok";
            else
                echo $db->getErrorMsg();
        }else {
            echo "no";
        }
    }

    function guardared($id) {
        $db = $this->dbInstance();
        $sql = "select count(*) from #_fbpages where idregistro=" . $_SESSION["fbconexion"]["id"] . " and id=" . intval($id);
        $res = $db->loadResult($sql);
        if (!$id || intval($res) != 1) {
            //$this->redirect(LANG."/fbconexion");
        } else {
            $sql = "update #_fbpages set contenido='" . $this->normalizar($_POST["contenido"]) . "' where id=" . intval($id);
            $db->setQuery($sql);
            $db->query();
            echo $sql;
        }
    }

    function unpublish($id){
        $db=$this->dbInstance();
        $db->debug(2);
        $sql="select estructura_pub from #_tab where id='".  mysql_escape_string($id)."'";
        $res="'".str_replace(",","','",$db->loadResult($sql))."'";
        $db->delete("#_widgetprod", "marca in ($res)");
        $sql="update #_tab set estructura_pub='',espublicado=1,settings_pub='' where id='$id'";
        $db->setQuery($sql);
        $db->query();
        echo "okok";
    }
    
    /**
     * publica la pagina
     * @param type $id 
     */
    function paso3($id) {
        $db = $this->dbInstance();
        $db->debug(2);
        $sql = "select count(*) from #_tab where uid='" . $_SESSION["fbconexion"]["id"] . "' and id=" . intval($id);
        if ($db->loadResult($sql) == 1) {
            //preparar para la publicación
            $sql = "select a.*,b.appid, b.appsecret,b.appkey from #_tab a inner join #_aplicacion b on a.idapp=b.id where a.uid='" . $_SESSION["fbconexion"]["id"] . "' and a.id=" . intval($id);
            $r = $db->loadObjectRow($sql);
            $a = explode(",", $r->estructura);
            if (count($a) > 0) {
                $b = "'" . implode("','", $a) . "'";
                $sql = "delete from #_widgetprod where marca in (" . $b . ")";
                $db->setQuery($sql);
                $db->query();
                $sql = "insert into #_widgetprod(marca,estructura,contenido_ed,contenido_prod) select marca,estructura,contenido_ed,contenido_prod from #_widgeted where marca in (" . $b . ")";
                $db->setQuery($sql);
                $db->query();
            }
            $db->update("#_tab", array(
                "espublicado" => "1",
                "fechapub" => date("Y-m-d h:i:s"),
                "settings_pub" => $r->settings,
                "estructura_pub" => $r->estructura,
                    ), "uid='" . $_SESSION["fbconexion"]["id"] . "' and id=" . intval($id));
            $db->setQuery("update #_tab set fechapub=now() where uid='" . $_SESSION["fbconexion"]["uid"] . "' and id=" . intval($id));
            $db->query();
            $fb = $this->loadModel("fbSDK");
            $fb->login($r->appid, $r->appsecret);
            $fql = "select has_added_app from page where page_id=" . $r->idpagina;
            $res = $fb->fqlQuery($fql, $r->appid, $r->appsecret);
            if ($res[0]["has_added_app"] == "true" || $res[0]["has_added_app"] == true || $res[0]["has_added_app"] == 1) {
                echo "ok";
            } else {
                echo "http://facebook.com/add.php?api_key=" . $r->appkey . "&pages=1&page=$r->idpagina";
            }
            /* if ($r->espublicado == 1) {
              //ya fue añadido
              echo "ok";
              } else {
              echo "http://facebook.com/add.php?api_key=" . $r->appkey . "&pages=1&page=$r->idpagina";
              } */
        }
    }

    function boxTemplates() {
        $db = $this->dbInstance();
        $sql = "select * from #_plantilla where estado=1 order by idcat";
        $res1 = $db->loadObjectList($sql);
        $sql = "select *,nombre_" . $_SESSION["lang"] . " as ncat from #_catplantilla order by nombre_" . $_SESSION["lang"];
        $res2 = $db->loadObjectList($sql);
        $this->params["datos"] = $res1;
        $this->params["cats"] = $res2;
        $this->loadView("plantilla.php", $this->params);
    }

    function _generar_otros($id, &$s) {
        $contenido = '';
        $contenido.='<script type="text/javascript">';
        //new line
        if ($s->sp_1 == "Yes") {
            $contenido.='document.getElementById("' . $marca . '").style.clear="both";';
        } else {
            $contenido.='document.getElementById("' . $marca . '").style.clear="none";';
        }
        $contenido.='</script>';
        return $contenido;
    }

    function applyTemplate($idtab, $idtpl) {
        echo "<pre>";
        $db = $this->dbInstance();
        $db->debug(2);
        //elimino rastros
        $sql = "select estructura from #_tab where uid='" . $_SESSION["fbconexion"]["id"] . "' and id=" . intval($idtab);
        if (count($db->loadObjectList($sql)) > 0) {
            //elimino widgets
            $db->delete("#_widgeted", "marca in ('" . str_replace(",", "','", $db->loadResult($sql)) . "')");
            //instalo la plantilla
            //leo los widgets de la plantilla
            $sql = "select * from #_plantilla where id=$idtpl";
            $tpl = $db->loadObjectRow($sql);
            $idps = explode(",", $tpl->estructura);
            $marcas = array();
            //ingresando widgets
            foreach ($idps as $idp) {
                $sql = "select * from #_widplantilla where id=$idp";
                $wpl = $db->loadObjectRow($sql);
                $marca = $wpl->widget . "_" . mktime() . rand(0, 4000000000);
                $marcas[] = $marca;
                $sql = "insert into #_widgeted values(null,'$marca','$wpl->estructura','" . mysql_escape_string(str_replace("{fbwidgetid}", $marca, $wpl->contenido_ed)) . "','" . mysql_escape_string(str_replace("{fbwidgetid}", $marca, $wpl->contenido_prod)) . "')";
                $db->setQuery($sql);
                $db->query();
            }
            $db->update("#_tab", array(
                "estructura" => implode(",", $marcas),
                "settings" => $tpl->settings,
                "contenido_ed" => $contenido,
                    ), "uid='" . $_SESSION["fbconexion"]["id"] . "' and id=" . intval($idtab));
        }
        /*
          $antes = "select * from #_widplantilla where id=";
          $despues = " union ";
          $sql = $antes . str_replace(",", $despues, $res->estructura);
          $res = $db->loadObjectList($sql);
         */
        echo "</pre>";
    }

    /**
     * 
     * los parametros se pasan por tabs
     * @param type $idtab
     * @param type $idpplantilla 
     */
    function hacerPlantilla($idtab, $idpplantilla) {
        $db = $this->dbInstance();
        $db->debug(2);

        $tpls = array(75, 92, 98, 99, 100, 107, 141, 143, 148, 151, 152, 153, 155, 156, 157, 158, 159, 160, 435, /* 20 */437, 443, 250,638);
        if ($idtab . "" . $idpplantilla != "00")
            $tpls = array($idpplantilla-1 => $idtab);
        echo '<table border="1" cellpaddin="1" cellspacing="2"><tr><td>Tab</td><td>ID de Plantilla</td></tr>';
        foreach ($tpls as $k => $t) {
            $idtab = $t;
            $idpplantilla = $k + 1;
            //elimino plantilla
            $sql = "select estructura from #_plantilla where id=$idpplantilla";
            $sw = $db->loadResult($sql);
            if ($sw != "")
                $db->delete("#_widplantilla", "id in (" . $sw . ")");
            $db->delete("#_plantilla", "id=$idpplantilla");

            //obtengo widgets
            $sql = "select * from #_tab where id=$idtab";
            $sw = $db->loadObjectRow($sql);
            $sql = "select * from #_widgeted where marca in ('" . str_replace(",", "','", $sw->estructura) . "')";
            $widgets = $db->loadObjectList($sql);
            //ingreso wigets
            $wps = array();
            foreach ($widgets as $w) {
                $db->delete("#_widplantilla", "id=".$w->id);
                $db->insert("#_widplantilla", array(
                    "id" => $w->id,
                    "widget" => preg_replace("/(.+)(_.*)/", "$1", $w->marca),
                    "estructura" => $this->normalizar($w->estructura),
                    "contenido_ed" => $this->normalizar(str_replace($w->marca, "{fbwidgetid}", $w->contenido_ed)),
                    "contenido_prod" => $this->normalizar(str_replace($w->marca, "{fbwidgetid}", $w->contenido_prod))
                ));
                $wps[] = $db->insertid();
            }
            //ingreso plantilla
            $db->insert("#_plantilla", array(
                "id" => (String) $idpplantilla,
                "settings" => $sw->settings . " ",
                "estructura" => implode(",", $wps),
                "imgpreview" => "plantilla$idpplantilla.jpg",
                "estado" => 1,
                "plan" => 1,
            ));
            echo "<tr><td>" . $t . "</td><td>" . $idpplantilla . "</td></tr>";
        }
        echo "</table>";
    }

    function getUsuarios($pag) {
        print_r($this->fb->getUsers($pag));
        include_once "org_netbeans_saas_facebook/FacebookSocialNetworkingService.php";
        try {
            $format = null;
            $flid = null;

            $result = FacebookSocialNetworkingService::friendsGet($format, $flid);
            echo $result->getResponseBody();
        } catch (Exception $e) {
            echo "Exception occured: " . $e;
        }
    }

    function encuesta() {
        if ($_POST["pb1"] != "") {
            $db = $this->dbInstance();
            $db->insert("#_encuesta", array(
                "uid" => $_SESSION["fbconexion"]["uid"],
                "fecha" => date("Y-m-d H:i:s"),
                "preg1" => mysql_escape_string($_POST["pb1"]),
                "preg2" => mysql_escape_string($_POST["pb2"]),
                "preg3" => mysql_escape_string($_POST["pb3"]),
                "preg4" => mysql_escape_string($_POST["pb4"]),
                "preg5" => mysql_escape_string($_POST["pb5"]),
                "comentario" => mysql_escape_string(trim(strip_tags($_POST["pb6"])) . " "),
                "idioma" => $_SESSION["lang"]
            ));
        }
    }

    function boxdiseno($id=0) {
        $db=$this->dbInstance();
        $body='
            <strong>Name:</strong> '.strip_tags($_POST["txt1"]).'<br/>
            <strong>E-mail:</strong> <a href="mailto:'.  strip_tags($_POST["txt3"]).'">'.  strip_tags($_POST["txt3"]).'</a><br/>
            <strong>Fan Page:</strong> <a href="'.strip_tags($_POST["txt2"]).'">'.strip_tags($_POST["txt2"]).'</a><br/>
            <strong>Country:</strong> '.  strip_tags($_POST["txt4"]).'<br/>
            <strong>Phone:</strong> '.  strip_tags($_POST["txt5"]).'<br/>
            <strong>Comments:</strong>'.strip_tags($_POST["txt6"]).'<br/>
            ';
        
        $Mail = $this->loadLib("phpmailer");
        $Mail->From = "info@fbconexion.com";
        $Mail->FromName = "FB Conexion";
        $Mail->AddAddress("info@fbconexion.com");
//        $Mail->AddAddress("danichalay@yahoo.es");
        $Mail->AddReplyTo($Mail->From);
        $Mail->Subject = "Design Fan Page - FBConexion";
        $Mail->IsHTML(true);
        $Mail->Body = utf8_decode($body);
        $Mail->Send();
    }

}

?>
