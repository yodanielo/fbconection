<?php
class Mautenticacion extends application{
    function checkLogin(){
        if(!$_SESSION["fbconexion"]){
            $this->redirect("login");
            exit;
        }
    }
    function autenticar($u,$p){
        $u=str_replace("'","",$u);
        $p=md5($p);
        $db=$this->dbInstance();
        $sql="select * from #_registro where usuario='$u' and password='$p'";
        $res=$db->loadObjectList($sql);
        if(count($res)==1){
            $r=$res[0];
            $_SESSION["fbconexion"]["id"]=$r->id;
            $_SESSION["fbconexion"]["usuario"]=$r->usuario;
            $_SESSION["fbconexion"]["nombre"]=$r->nombre;
            $_SESSION["fbconexion"]["apellidos"]=$r->apellidos;
            return true;
        }
        else
            return false;
    }
    function loggout(){
        unset($_SESSION["fbconexion"]);
        $this->checkLogin();
    }
}
?>
