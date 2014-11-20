<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of partners
 *
 * @author daniel
 */
class Cpartners extends application {

    /**
     * pantalla de login para partnership
     */
    function index() {
        if ($_GET["logout"] == 1) {
            unset($_SESSION["partners"]);
        }
        if ($_POST["txt1"]) {
            $db = $this->dbInstance();
            $sql = "select id,username,keypartner,email,nombre,apellidos from #_partner where username='" . mysql_escape_string($_POST["txt1"]) . "' and password=md5('" . mysql_escape_string($_POST["txt2"]) . "')";
            $res = $db->loadAssocList($sql);
            if (count($res) == 1) {
                $_SESSION["partners"] = $res[0];
                if ($res[0]["username"] == "e.reymundo") {
                    $_SESSION["partners"]["keypartner"] = "%";
                }
                if ($res[0]["username"] == "e.reymundo" || $res[0]["username"] == "trial") {
                    $_SESSION["partners"]["esjefe"] = true;
                }
                $this->redirect("partners/report1");
            }
        }
        $this->loadView("partner_login.php", $this->params);
    }

    /**
     * imprime el reporte 1
     */
    function report1($pagActual="") {
        $this->checkSession();
        $db = $this->dbInstance();
        $lib = $this->loadLib("paginacion");
        if (!$_POST["sortby"])
            $_POST["sortby"] = 0;
        $sortable = array("a.fechains", "b.fechapub");
        $sql = "
            select distinct a.*,date_format(a.fechains,'" . __("formatofechamysql") . "') as fechains2 from #_usuario a
            left join #_tab b on a.uid=b.uid
            where a.partner like '" . $_SESSION["partners"]["keypartner"] . "' and concat(a.firstname,' ',a.lastname) like '%".  mysql_escape_string(trim($_POST["searchfor"]))."%' order by " . $sortable[$_POST["sortby"]] . " desc";
        if ($pagActual == "") {
            $pagActual = 1;
            $todo = true;
        }
        $res = $lib->doPagination($db, $sql, 10, $pagActual, $numPags);
        if ($todo) {
            $this->params["registros"] = $this->getReport1($res);
            $this->params["numpags"] = $numPags;
            $this->params["reporte"] = "report1";
            $this->loadHtml("partner_report1.php", $this->params);
        } else {
            echo $this->getReport1($res, false);
            echo '
                <script type="text/javascript">
                    numpags='.$numPags.';
                </script>';
        }
    }

    /**
     * imprime los usuarios
     */
    private function getReport1($res, $showmessage=true) {
        $plan = array("", "Personal", "Professional", "Premium");
        $cad = '';
        if (count($res) > 0) {
            foreach ($res as $r) {
                $cad.='<div class="regitem" alt="' . $r->uid . '">';
                $cad.='    <div class="r1user">
                                <a target="_BLANK" href="http://www.facebook.com/' . $r->uid . '"><img class="r1userfoto" src="https://graph.facebook.com/' . $r->uid . '/picture" /></a>
                                <div class="btnexpandir" onclick="return expandir(this,\'' . $r->uid . '\')"></div>
                                <a target="_BLANK" href="http://www.facebook.com/' . $r->uid . '">
                                    <span class="r1nombres">' . $r->firstname . " " . $r->lastname . '</span><br/>
                                </a>
                                <span class="r1inscrito">' . __("Register date") . ": " . $r->fechains2 . '</span><br/>
                                <span class="r1inscrito">Plan: ' . $plan[$r->plan] . '</span><br/>
                           </div>
                           <div class="r1pages"></div>';
                $cad.='</div>';
            }
        } else {
            $cad.= '<div class="nohay">' . __("txtnoitemstoshow") . '</div>';
        }
        return $cad;
    }

    /**
     * lo que carga las paginas de los usuarios
     */
    function report1_aux() {
        $this->checkSession();
        $sql = "select group_concat(idpagina) from #_tab where uid='" . mysql_escape_string($_POST["uid"]) . "'";
        $db = $this->dbInstance();
        $res2 = $db->loadResult($sql);
        $fql = "select page_id, name, fan_count, page_url,type from page where page_id in ($res2)";
        $res = $this->fb->fqlquery($fql);
        if (count($res) > 0) {
            foreach ($res as $r) {
                $cad.='
                    <div class="r1pageitem">
                        <a target="_BLANK" href="' . $r["page_url"] . '"><img src="http://graph.facebook.com/' . $r["page_id"] . '/picture"/></a>
                        <a target="_BLANK" class="r1nombres" href="' . $r["page_url"] . '">' . $r["name"] . '</a><br/>
                        <span class="r2type">' . __("Category") . ': ' . $r["type"] . '</span>
                        <span class="r2fans">' . __("Likes") . ': ' . $r["fan_count"] . '</span>
                    </div>';
            }
            echo $cad;
        }
    }

    /**
     * imprime el reporte 2
     */
    function report2($pagActual="") {
        $this->checkSession();
        $db = $this->dbInstance();
        $lib = $this->loadLib("paginacion");
        if (!$_POST["sortby"])
            $_POST["sortby"] = 0;
        $sortable = array("a.fechains", "b.fechapub");
        $sql = "
            select distinct a.*,date_format(a.fechains,'" . __("formatofechamysql") . "') as fechains2 from #_usuario a
            left join #_tab b on a.uid=b.uid
            where a.partner like '" . $_SESSION["partners"]["keypartner"] . "' and concat(a.firstname,' ',a.lastname) like '%".  mysql_escape_string(trim($_POST["searchfor"]))."%' and a.plan>1 order by " . $sortable[$_POST["sortby"]] . " desc";
        if ($pagActual == "") {
            $pagActual = 1;
            $todo = true;
        }
        $res = $lib->doPagination($db, $sql, 10, $pagActual, $numPags);
        if ($todo) {
            $this->params["registros"] = $this->getReport1($res);
            $this->params["numpags"] = $numPags;
            $this->params["reporte"] = "report2";
            $this->loadHtml("partner_report1.php", $this->params);
        } else {
            echo $this->getReport1($res, false);
            echo '
                <script type="text/javascript">
                    numpags='.$numPags.';
                </script>';
        }
    }

    function change_password() {
        $this->checkSession();
        if ($_POST["txt1"] != "" && $_POST["txt2"] != "") {
            $db = $this->dbInstance();
            $sql = "select * from #_partner where username='" . $_SESSION["partners"]["username"] . "' and password=md5('" . mysql_escape_string($_POST["txt1"]) . "')";
            if (count($db->loadObjectList($sql)) == 1) {
                $db->update("#_partner", array(
                    "password" => md5(mysql_escape_string($_POST["txt2"]))
                        ), "username='" . $_SESSION["partners"]["username"] . "'");
                echo __("Password changed successfully");
            } else {
                echo __("Current password don't match");
            }
        } else {
            $this->params["css"][] = "jquery-ui-1.8.12.custom.css";
            $this->params["scripts"][] = "jquery-ui-1.8.9.custom.min.js";
            $this->loadHtml("partner_changepass.php", $this->params);
        }
    }

    function transferTab() {
        $this->checkJefe();
        $db = $this->dbInstance();
        $db->debug(2);
        if (!$_POST["txt1"]) {
            //cargo los tabs del select
            $sql = "select id, nombre from #_aplicacion order by idioma";
            $this->params["tabs"] = $db->loadObjectList($sql);

            $this->loadHtml("partner_transfertab.php", $this->params);
        } else {
            //a grabar se ha dicho
            //esto es del lado de la fuente
            $sql = "select * from #_tab where id=" . intval($_POST["txt1"]);
            $tab = $db->loadObjectRow($sql);
            $sql = "select * from #_widgeted where marca in ('" . str_replace(",", "','", $tab->estructura) . "')";
            $widgets = $db->loadObjectList($sql);
            //del lado del destino
            //creando el tab
            $db->insert("#_tab", array(
                "uid" => $_POST["txt2"],
                "espremium" => 4,
                "idapp" => $_POST["txt4"],
                "idpagina" => $_POST["txt3"],
                "espublicado" => "0",
                "fechains" => date("Y-m-d H:i:s")
            ));
            $nid = $db->insertid();
            echo "<pre>".print_r($nid,true)."</pre>";
            //del lado del destino
            $sql = "select * from #_tab where id=" . $nid;
            $dtab = $db->loadObjectRow($sql);
            $db->delete("#_widgeted", "marca in ('" . str_replace(",", "','", $dtab->estructura) . "')");
            $idw = 0;
            $pw = array();
            foreach ($widgets as $w) {
                $idw++;
                $db->insert("#_widgeted", array(
                    "marca" => $w->marca . $idw,
                    "estructura" => $w->estructura,
                    "contenido_ed" => mysql_escape_string($w->contenido_ed),
                    "contenido_prod" => mysql_escape_string($w->contenido_prod),
                ));
                $pw[] = $w->marca . $idw;
            }
            $db->update("#_tab", array(
                "settings" => $tab->settings,
                "settings_pub" => $tab->settings_pub,
                "contenido_ed" => $contenido_ed,
                "estructura" => implode(",", $pw),
                    ), "id=" . $nid);
            echo __("Transfer made successfully");
        }
    }

    function checkJefe() {
        if (!$_SESSION["partners"]["esjefe"])
            $this->redirect("partners");
    }

    function checkSession() {
        if (!$_SESSION["partners"])
            $this->redirect("partners");
    }

    function loadHtml($view="", $params=array()) {
        //pasarle los parametros por defecto para estilos y scripts
        $x = new config();
        $x->loadFile(CONFIG_PATH);
        $defecto["scripts"] = array(
            "http://www.fbconexion.com/onlineco/js/jquery-1.4.4.min.js",
            "jquery-ui-1.8.9.custom.min.js",
            //"http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js",
            "flexcroll.js",
            "http://www.fbconexion.com/onlineco/js/plugins.js",
        );
        $defecto["css"] = array(
            "jquery-ui-1.8.12.custom.css",
            "flexcrollstyles.css",
        );
        $defecto["sitedescription1"] = "";
        $defecto["config"] = $x->item("site");
        $defecto["tripas"] = $this->destripar();
        $params = $this->mergeVars($defecto, $params);
        $this->loadView("partner_header.php", $params);
        if ($view)
            $this->loadView($view, $params);
        $this->loadView("partner_footer.php", $params);
    }

}

?>
