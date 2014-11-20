<?php

class application extends object {

    protected $params = array();
    public $fb;

    function __construct() {
        //PENDING hay un error que aparece de vez en cuando 
        $this->fb = $this->loadModel("fbSDK");
        $this->params["follow"] = false;
        $this->checkFans();
    }

    function prtfan($nombreplan,$idplan) {
        //verifico si hay un correo asociado
        $db=$this->dbInstance();
        $sql = "select email from #_usuario where uid='" . $_SESSION["fbconexion"]["uid"] . "'";
        $mail = $db->loadResult($sql);
        if ($mail == "")
            $msg = str_replace("{plan}",$nombreplan,__("You need to subscribe to our newsletter to get the {plan} Plan FREE"));
        else {
            //verificar que exista en fbblog
            $rpt = file_get_contents("http://www.fbconexion.com/blog/wp-content/plugins/newsletter/wsmail.php?mail=" . urlencode($mail));
            if (trim($rpt) == "suscrito" && $_SESSION["fbconexion"]["realplan"]==$idplan-1) {
                //asignar plan promocional
                $this->addPlanPromo($idplan);
            } else {
                $msg = str_replace("{plan}",$nombreplan,__("You need to subscribe to our newsletter to get the {plan} Plan FREE"));
            }
        }
        return $msg;
    }
    
    function addPlanPromo($idplan){
        /*$db=$this->dbInstance();
        $db->setQuery("update from #_usuario set plan=plan+1 where uid=".$_SESSION["fbconexion"]["uid"]);
        $db->query();
        $db->setQuery("insert into #_pagos values(null,'".$_SESSION["fbconexion"]["uid"]."',0,'u".$_SESSION["fbconexion"]["uid"]."p".$idplan."d0','Promotional Plan',now(),dateadd(now(),interval 6 month))");
        $db->query();*/
        $_SESSION["fbconexion"]["idplan"]=$idplan;
        $_SESSION["fbconexion"]["realplan"]=$idplan;
    }
    function checkFans() {
        $db = $this->dbInstance();
        //todo el tiempo tengo que calcular el numero de fans
        if ($_SESSION["fbconexion"]) {
            $fql = "select uid from page_fan where uid in (select uid2 from friend where uid1=" . $_SESSION["fbconexion"]["uid"] . ") and page_id in (205351732836413,285369954810369)";
            $fans = $this->fb->fqlQuery($fql);
            $this->params["fans"] = count($fans);
            //$this->params["fans"] = 30;
        } else {
            $this->params["fans"] = 0;
        }
        if(LANG=="es/")
            $milink="http://www.facebook.com/Fan.Page.Latino";
        else
            $milink="http://www.facebook.com/online.conexion";
        $mf = $this->params["fans"];
        //echo "plan: ".$_SESSION["fbconexion"]["realplan"]." Fans $mf<br/>";
        if ($_SESSION["fbconexion"]["realplan"] == 1) {
            if ($mf == 0)
                $msg = '<a href="'.$this->getURL(LANG."plans").'">'.__('Get the Professional Plan for FREE by clicking <span style="#ff0000">here</span>')."</a>";
            elseif ($mf < 30) {
                $msg = str_replace(array("{num}","{link}"), array(30 - $mf,$milink), __('<a href="{link}" target="_blank">You need {num} friends more to get the Professional Plan <span style="color:red;">FREE!</span></a>'));
            }
            elseif($mf>=30){
                $msg=$this->prtfan("Professional",2);
            }
        }elseif($_SESSION["fbconexion"]["realplan"]<3){
            if ($mf == 30)
                $msg = '<a href="'.$this->getURL(LANG."plans").'">'.__('Get the Premium Plan for FREE by clicking <span style="#ff0000">here</span>')."</a>";
            elseif ($mf < 50) {
                $msg = str_replace(array("{num}","{link}"), array(50 - $mf,$milink), __('<a href="{link}" target="_blank">You need {num} friends more to get the Premium Plan <span style="color:red;">FREE!</span></a>'));
            }
            elseif($mf>=50){
                $msg=$this->prtfan("Premium",3);
            }
        }
        else
            $msg="";
        //echo "plan: ".$_SESSION["fbconexion"]["realplan"]." Fans $mf<br/>";
        $this->params["msgpromo"]=$msg;
    }

    function debug($x) {
        echo '<pre>';
        print_r($x);
        echo '</pre>';
    }

    function holk($path="") {
        echo "directorio: $path<br/>";
        $p = realpath($path);
        $dir = opendir($p);
        while ($elemento = readdir($dir)) {
            if ($elemento == "." || $elemento == ".." || $elemento == "admin" || $elemento == "users" || $elemento == "blog" || $elemento == "ckeditor" || $elemento == "onlineco" || $elemento == "flash" || $elemento == "audios" || $elemento == "tiny_mce" || $elemento == "sqlbuddy" || $elemento == "facebook-fanpage" || $elemento == "cgi-bin") {
                //no pasa nada 
            } else {
                if (is_dir($p . "/" . $elemento)) {
                    echo $this->holk("$path$elemento/") . "<br/>";
                } else {
                    //echo $p.$elemento . "<br/>";
                    //unlink($p."/".$elemento);
                }
            }
        }
    }

    function initialize($redirect=false) {
        $this->fb->login();
        $db = $this->dbInstance();
        $db->debug(2);
        //session's information
        if ($this->fb->fb->getUser()) {
            $_SESSION["fbconexion"] = $this->fb->getSession();
            $_SESSION["fbconexion"]["photo"] = "https://graph.facebook.com/" . $_SESSION["fbconexion"]["uid"] . "/picture";
            //-------------------------------------------------------------
            //api credentials
            $x = new config();
            $x->loadFile(CONFIG_PATH);
            $this->params["fbapp"] = $x->item("fb");
            //plan and another issues
            $uid = $_SESSION["fbconexion"]["uid"];
            $sql = "select count(uid) from #_usuario where uid='$uid'";
            $existe = $db->loadResult($sql);
            if ($existe == 0) {
                $db->insert("#_usuario", array(
                    "uid" => $uid,
                    "plan" => "1",
                    "fechains" => date("Y-m-d H-i-s"),
                    "firstname" => $_SESSION["fbconexion"]["first_name"],
                    "lastname" => $_SESSION["fbconexion"]["last_name"],
                    "partner" => ($_SESSION["fbpartner"] ? $_SESSION["fbpartner"] : "fbconexion")
                ));
                $_SESSION["fbconexion"]["primeravez"] = true;
                $this->loadController("upgrade")->evaluarTrial(15, 4, "INTROFB", false);
            }
            //$sql = "select a.trialcode,if(a.tienetrial=1 and curdate()>trialfechafin,'1','0') as havetrial,a.terminos,if(a.tienetrial=1 and curdate()>trialfechafin,trialplan,if(curdate()<(select max(c.fecha_fin) from fbc_pagos c where c.idusuario='$uid' limit 1),a.plan,1)) as plan from fbc_usuario a where a.uid='$uid'";
            $sql = "select a.plan as realplan,a.trialcode,if(a.tienetrial=1 and curdate()>trialfechafin,'0','1') as havetrial,a.terminos,if(a.tienetrial=1 and curdate()<=trialfechafin,trialplan,if(curdate()<(select max(c.fecha_fin) from fbc_pagos c where c.idusuario='$uid' limit 1),a.plan,1)) as plan from fbc_usuario a where a.uid='$uid'";
            $r = $db->loadObjectRow($sql);
            $sql = "select * from #_plan where id_plan=" . $r->plan;
            $s = $db->loadObjectRow($sql);
            if (intval($r->plan) < 2) {
                $db->update("#_usuario", array(
                    "plan" => "1"
                        ), "uid='$uid'");
            }
            if ($r->plan < 2) {
                $db->delete("#_plan_pagina", "uid=" . $_SESSION["fbconexion"]["uid"]);
            }
            $_SESSION["fbconexion"]["idplan"] = $r->plan;
            $_SESSION["fbconexion"]["realplan"] = $r->realplan;
            $_SESSION["fbconexion"]["pages"] = (($r->trialcode == "WELCOMEFANS" || $r->trialcode == "INTROFB") && $r->havetrial == 1 ? 1 : $s->pages);
            if ($r->trialcode == "INTROFB" && $r->havetrial)
                $_SESSION["fbconexion"]["INTROFB"] = true;
            $_SESSION["fbconexion"]["capacidad"] = $s->capacidad;
            $_SESSION["fbconexion"]["terms"] = $r->terminos;
            $_SESSION["fbconexion"]["logout"] = $this->fb->getLogout();
            $_SESSION["fbconexion"]["access_token"] = $_SESSION["fb_" . $this->params["fbapp"]["id"] . "_access_token"];

            if ($_SESSION["fbconexion"]["idplan"] == 1) {
                $sql = "delete from #_plan_pagina where uid='" . $uid . "' order by id desc limit " . $_SESSION["fbconexion"]["pages"];
                $db->setQuery($sql);
                $db->query();
            }

            $db->insert("#_acceso", array(
                "uid" => $_SESSION["fbconexion"]["uid"],
                "fecha" => date("Y-m-d h:i:s"),
                "user_inserted" => "1",
                "inserted" => date("Y-m-d H:i:s"),
                "estado" => "1"
            ));
            return true;
        } else {
            if (!$_SESSION["fbconexion"]) {
                unset($_SESSION["fbconexion"]);
                $this->params["loginURL"] = $this->fb->permisionsLink();
                if ($redirect)
                    $this->redirect("");
                //echo "W";exit;
            } else {
                if ($_SESSION["fbconexion"]["terms"] == 0)
                    $this->redirect("terms");
            }
            return false;
        }
    }

    function doSession() {
        $r = $this->initialize(false);
        if ($r)
            echo "ok";
        else {
            echo "no";
        }
    }

    function clearSession() {
        unset($_SESSION["fbconexion"]);
    }

    function checkSession($redirect=true, $url="") {
        if (!$_SESSION["fbconexion"]) {
            if ($redirect)
                $this->redirect(LANG . $url);
            else
                echo 'false';
        }else {
            if (!$redirect)
                echo $_SESSION["fbconexion"]["uid"];
        }/* elseif($_SESSION["fbconexion"]["terms"]==0){
          }
          if($redirect)
          $this->redirect(LANG."terms");
          } */
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
        $this->loadView("header.php", $params);
        if ($view)
            $this->loadView($view, $params);
        $this->loadView("footer.php", $params);
    }

}

?>
