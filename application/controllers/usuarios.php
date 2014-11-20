<?php

class Cusuarios extends application {

    function registrate() {
        $db = $this->dbInstance();
        $sql = "select * from fbc_estaticos where id=5";
        $this->params["registro"] = $db->loadObjectRow($sql);
        $this->params["scripts"][] = "plugins.js";
        $this->loadHtml("registrate.php", $this->params);
    }

    function login() {
        $u = str_replace(array("%", "'"), "", $_POST["logusuario"]);
        $p = md5($_POST["logpassword"]);
        $sql = "select * from #_registro where usuario like '$u' and password='$p'";
        $db = $this->dbInstance();
        $res = $db->loadObjectList($sql);
        if (count($res) == 1) {
            $_SESSION["fbconexion"]["id"] = $res[0]->id;
            $_SESSION["fbconexion"]["nombres"] = $res[0]->nombres;
            $_SESSION["fbconexion"]["apellidos"] = $res[0]->apellidos;
            $_SESSION["fbconexion"]["usuario"] = $res[0]->usuario;
            $this->redirect("fbconexion");
        }
        else
            $this->redirect("");
    }

    function exist_user() {
        $db = $this->dbInstance();
        $sql = "select id from fbc_registro where usuario like '" . str_replace(array("'", "%"), "", $_POST["value"]) . "'";
        $res = $db->loadObjectList($sql);
        if (count($res) > 0) {
            echo "1";
        }
    }

    function set_register() {
        $db = $this->dbInstance();
        $db->insert("fbc_registro", array(
            "nombres" => $_POST["txt4"],
            "apellidos" => $_POST["txt5"],
            "usuario" => $_POST["txt1"],
            "password" => md5($_POST["txt2"]),
            "empresa" => $_POST["txt6"],
            "estado" => "1"
        ));
        echo $db->getErrorMsg();
        if ($db->getErrorMsg() != "")
            echo $db->getErrorMsg();
        else
            echo "1";
    }

}

?>
