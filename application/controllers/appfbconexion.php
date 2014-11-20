<?php

class Cappfbconexion extends application{
    function __construct() {
        parent::__construct();
    }
    function index(){
        $db = $this->dbInstance();
        $db->debug(2);
        $this->fb->login();
        $cfg=$this->loadConfig("fb");
        if($this->fb->fb->getUser()==0){
            ?>
            <script type="text/javascript">top.location.href='<?=$this->fb->permisionsLink()?>'</script>
            <?php
        }
        else{
            //$u=json_decode(file_get_contents("https://graph.facebook.com/".$this->fb->fb->getUser()."?access_token=".$this->fb->fb->getAccessToken()));
            if(!$_SESSION["fbconexion"])
                $this->initialize();
            $fql = "select page_id,name from page where page_id in (select page_id from page_admin where uid='" . $_SESSION["fbconexion"]["uid"] . "') order by page_id asc";
            $this->params["pags"] = $this->fb->fqlQuery($fql);
            $sql = "select * from #_plan_pagina where uid='" . $_SESSION["fbconexion"]["uid"] . "'";
            $pp = $db->loadObjectList($sql);
            $this->params["freepremium"] = $_SESSION["fbconexion"]["pages"] - count($pp);
            $sql = "select #_tab.*,#_aplicacion.nombre as nombreapp from #_tab inner join #_aplicacion on #_tab.idapp=#_aplicacion.id where #_tab.uid='" . $_SESSION["fbconexion"]["uid"] . "' order by idpagina asc";
            $this->params["tabs"] = $db->loadObjectList($sql);
            $sql = "select * from #_aplicacion where visible=1 and idioma='".$_SESSION["lang"]."' order by nombre";
            $this->params["apps"] = $db->loadObjectList($sql);
            $this->params["upgraded"] = $pp;
            $this->params["esapp"]=true;
            $this->params["scripts"][] = "jquery.dd.js";
            $this->params["css"][] = "dd.css";
            $this->loadHtml("intranet1.php", $this->params);
        }
    }
}

?>
