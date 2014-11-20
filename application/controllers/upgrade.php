<?php

class Cupgrade extends application {

    function __construct() {
        parent::__construct();
    }

    function index($idplan) {
        $this->checkSession();
        $db = $this->dbInstance();
        $_POST["pbi13"]=strtoupper($_POST["pbi13"]);
        $sql = "select * from #_usuario where uid='" . $_SESSION["fbconexion"]["uid"] . "'";
        $this->params["usuario"] = $db->loadObjectRow($sql);
        $this->params["selectedplan"] = $idplan;
        if ($_POST["pbi1"] != "") {
            $db->update("#_usuario", array(
                "firstname" => $_POST["pbi1"],
                "lastname" => $_POST["pbi3"],
                "company" => $_POST["pbi5"] . " ",
                "phone" => $_POST["pbi8"],
                "email" => $_POST["pbi10"],
                "country" => $_POST["pbi17"],
                "state" => $_POST["pbi9"],
                "city" => $_POST["pbi2"],
                "address" => $_POST["pbi4"],
                "zipcode" => $_POST["pbi6"] . " ",
                    //"duracion"=>$_POST["pbi12"],
                    ), "uid='" . $_SESSION["fbconexion"]["uid"] . "'");
            if ($_POST["pbi13"]) {
                switch ($_POST["pbi13"]) {
                    case "5ENTERPRISE":
                        $this->evaluarTrial(5, 4,$_POST["pbi13"]);
                        break;
                    case "30ENTERPRISE":
                        $this->evaluarTrial(30, 4,$_POST["pbi13"]);
                        break;
                    case "15PREMIUM":
                        $this->evaluarTrial(15, 3,$_POST["pbi13"]);
                        break;
                    case "30PREMIUM":
                        $this->evaluarTrial(30, 3,$_POST["pbi13"]);
                        break;
                    case "5PROFESSIONAL":
                        $this->evaluarTrial(5, 2,$_POST["pbi13"]);
                        break;
                    case "30PROFESSIONAL":
                        $this->evaluarTrial(30, 2,$_POST["pbi13"]);
                        break;
                    case "WELCOMEFANS";
                        $this->evaluarTrial(180, 4,$_POST["pbi13"]);
                        break;
                    default:
                        $this->params["cuponmalo"] = true;
                        $this->loadHtml("pago1.php", $this->params);
                }
            } else {
                $this->loadHtml("pago2.php", $this->params);
            }
        } else {
            $this->loadHtml("pago1.php", $this->params);
        }
    }

    public function evaluarTrial($dias, $plan, $code,$mostrar=true) {
        $this->checkSession();
        $sql = "select count(*) from #_usuario where uid='" . $_SESSION["fbconexion"]["uid"] . "' and tienetrial=0";
        $db = $this->dbInstance();
        $db->debug(2);
        //echo $db->loadResult($sql) . $sql;
        if ($db->loadResult($sql) == 1) {
            $db->setQuery("update #_usuario set tienetrial=1, trialcode='".  mysql_escape_string($code)."', trialfechafin=date_add(curdate(),interval $dias day), trialplan=$plan where uid=" . $_SESSION["fbconexion"]["uid"]);
            $db->query();
            $_SESSION["fbconexion"]["idplan"]=$plan;
            $_SESSION["fbconexion"]["pages"]=$db->loadResult("select pages from #_plan where id_plan=".$plan);
            if($mostrar)
                $this->loadHtml("feliz_upgrade.php");
        } else {
            $this->params["cuponmalo"] = true;
            if($mostrar)
                $this->loadHtml("pago1.php", $this->params);
        }
    }

    function success() {
        $this->checkSession();
        $this->loadHtml("feliz_upgrade.php");
    }

    function processIPN() {
        $x = $_POST;
        //mail("danichalay@yahoo.es", "IPN", print_r($x, true));
        $planes = array(2 => "Professional", 3 => "Premium", 4 => "Enterprise");
        $fijos = array(
            //array(2 => 1, 3 => 29.99, 4 => 99.99),
            array(2 => 9.99, 3 => 29.99),
            array(2 => 99.99, 3 => 299.99)
        );
        preg_match_all("/u(.[^p]*)p(.[0-9]*)d(.[0-9]*)(_(.[0-9|\.]*))?/", $x["item_number"], $matches);

        //if ($x["payment_status"] == "Completed") {
        if ($x["txn_type"] == "subscr_payment" && $x["receiver_email"]=="onlineconexion@gmail.com") {
            $usuario = $matches[1][0];
            $plan = $planes[$matches[2][0]];
            $periodo = $matches[3][0];
            $dcto = $matches[4][0] / 100;
            $pago = ($x["mc_gross"] ? $x["mc_gross"] : $x["amount3"]);
            $pago = $x["mc_gross"];
            //hago fecha
            if ($periodo == 0)
                $adate = "MONTH";
            else
                $adate = "YEAR";
            
            //agregar a la db
            $db = $this->dbInstance();

            if ($fijos[$periodo][$matches[2][0]] * (1 - doubleval($dcto)) <= $pago) {
                $sql = "insert into #_pagos values(null,'$usuario','$pago','" . $x["item_number"] . "','" . $x["item_name"] . "',curdate(),date_add(curdate(),INTERVAL 1 $adate))";
                $db->setQuery($sql);
                $db->query();

                $campos = array(
                    "plan" => $matches[2][0],
                    "duracion" => $periodo
                );
                if($_SESSION["fbconexion"]){
                    $_SESSION["fbconexion"]["plan"]=$matches[2][0];
                    $_SESSION["fbconexion"]["pages"]=$db->loadResult("select pages from #_plan where id_plan=".$matches[2][0]);
                }
                
                $db->update("#_usuario", $campos, "uid='$usuario'");
                mail("danichalay@yahoo.es", "IPN-completed", $db->getErrorMsg()."<br/>".print_r($x, true));
            }
        }
    }

    function dopago($page) {
        $db = $this->dbInstance();
        $result = array();
        $sql = "select * from #_plan_pagina where uid='" . $_SESSION["fbconexion"]["uid"] . "' and id_pagina='" . $page . "'";
        $res = $db->loadObjectList($sql);
        if (count($res) > 0) {
            $result["msg"] = "This page has already been upgraded.";
            $result["estado"] = -1;
        } elseif (count($res) == 0) {
            $db->insert("#_plan_pagina", array(
                "id_pagina" => $page,
                "uid" => $_SESSION["fbconexion"]["uid"]
            ));
            $result["msg"] = "This page has been upgraded successfully.";
            $result["estado"] = $_SESSION["fbconexion"]["idplan"];
        }
        echo json_encode($result);
    }

}

?>