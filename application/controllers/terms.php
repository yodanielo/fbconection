<?php
class Cterms extends application{
    function __construct() {
        parent::__construct();
    }
    function index(){
        if($_POST["aceptado"]==1){
            $db=$this->dbInstance();
            $campos=array(
                "terminos"=>"1"
            );
            $db->update("#_usuario", $campos, "uid=".$_SESSION["fbconexion"]["uid"]);
            unset($_SESSION["fbconexion"]);
            $this->redirect("fbconexion");
        }
        $this->loadHtml("terms.php", $this->params);
    }
}
?>
