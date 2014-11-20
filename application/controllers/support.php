<?php

class CSupport extends application {

    function __construct() {
        $this->params["pagetitle"] = __("ptsoporte");
        $this->params["sitedescription1"] = __("pdsoporte");
        parent::__construct();
    }

    function index() {
        $this->params["scripts"][] = "jquery.cycle.js";
        $this->loadHtml("support_home.php", $this->params);
    }

    function normalizar($valor) {
        $valor = str_replace("\'", "'", $valor);
        $valor = str_replace("'", "\'", $valor);
        return $valor;
    }

    function loadHtml($view="", $params=array()) {
        //pasarle los parametros por defecto para estilos y scripts
        $x = new config();
        $x->loadFile(CONFIG_PATH);
        $defecto["scripts"] = array(
            "http://www.fbconexion.com/onlineco/js/jquery-1.4.4.min.js",
            "jquery-ui-1.8.9.custom.min.js",
            "flexcroll.js",
            "http://www.fbconexion.com/onlineco/js/plugins.js",
        );
        $defecto["css"] = array(
            "jquery-ui-1.8.12.custom.css",
            "flexcrollstyles.css",
        );
        $defecto["config"] = $x->item("site");
        $defecto["tripas"] = $this->destripar();
        $params = $this->mergeVars($defecto, $params);
        $this->loadView("support_header.php", $params);
        if ($view)
            $this->loadView($view, $params);
        $this->loadView("support_footer.php", $params);
    }

    function faqs($id=null) {
        if (LANG == "es/") {
            $this->params["fbcred"]["id"] = "219161961492807";
            $this->params["fbcred"]["apikey"] = "73a9ebb35c23dd60746edc5f4769dc1f";
            $this->params["fbcred"]["appsecret"] = "e65ea793b92633c724ab411271389769";
        } else {
            $this->params["fbcred"]["id"] = "243019195764316";
            $this->params["fbcred"]["apikey"] = "fcf342e5ebcdd531c2f57ca0d676fe89";
            $this->params["fbcred"]["appsecret"] = "bf31b63199d146fe58a22410f38c2ee8";
        }
        $id = intval($id);
        $db = $this->dbInstance();
        $db->debug(2);
        if (trim($_GET["query"]) == "") {
            if ($_POST["faqsettitle"]) {
                //insertar pregunta
                if (trim($_POST["faqsettitle"]) != "") {
                    $db->insert("#_faq", array(
                        "idusuario" => $_SESSION["fbconexion"]["uid"],
                        "pregunta" => mysql_escape_string($this->normalizar(trim($_POST["faqsettitle"]))),
                        "descripcion" => mysql_escape_string($this->normalizar(trim($_POST["faqsetdescripcion"]))),
                        "destacada" => "0",
                        "escerrado" => "0",
                        "esbetado" => "0",
                        "idioma" => $_SESSION["lang"],
                        "fecha"=>mktime(),
                    ));
                }
            }
            if ($id == 0) {
                $secret= $this->_parse_signed_request($_REQUEST["signed_request"].$_POST["signed"], $this->params["fbcred"]["appsecret"]);
                /*echo '<!--';
                $this->debug($secret);
                echo '-->';*/
                if(is_array($secret)){
                    $fql = "select name,page_url from page where page_id=" . $secret["page"]["id"];
                    $res = $this->fb->fqlQuery($fql);
                    $this->params["pageurl"] = $res[0]["page_url"] . "?sk=app_" . $this->params["fbcred"]["id"];
                }
                if($secret["page"]["admin"]=="1" || $_SESSION["fbconexion"]["uid"]=="1650081409" || $_SESSION["fbconexion"]["uid"]=="100000255493585"){
                    $this->params["esadmin"]=true;
                }
                $sql = "select * from #_faq where destacada=1 and esbetado=0 and idioma='" . $_SESSION["lang"] . "' order by id desc";
                $this->params["des"] = $db->loadObjectList($sql);
                $sql = "select * from #_faq where destacada=0 and esbetado=0 and idioma='" . $_SESSION["lang"] . "' order by id desc";
                $this->params["nodes"] = $db->loadObjectList($sql);
                $sql = "select distinct idusuario from #_faq";
                $usuarios = $db->loadObjectList($sql);
                $arusers = array();
                if (count($usuarios) > 0) {
                    foreach ($usuarios as $u) {
                        $arusers[] = $u->idusuario;
                    }
                    $fql = "select uid,name,pic_square,profile_url from user where uid in (" . implode(",", $arusers) . ")";
                    $arusers2 = $this->fb->fqlQuery($fql);
                    $arusers3 = array();
                    foreach ($arusers2 as $au) {
                        $arusers3["x" . $au["uid"]] = $au;
                    }
                    $this->params["usuarios"] = $arusers3;
                }
                if(!$_POST["accion"])
                    if ($_REQUEST["signed_request"]) {
                        $this->loadView("facebook_faq1.php", $this->params);
                    } else {
                        $this->loadHTML("support_faq.php", $this->params);
                    }
            } else {
                $secret= $this->_parse_signed_request($_GET["secret"], $this->params["fbcred"]["appsecret"]);
                if(is_array($secret)){
                    $fql = "select name,page_url from page where page_id=" . $secret["page"]["id"];
                    $res = $this->fb->fqlQuery($fql);
                    $this->params["pageurl"] = $res[0]["page_url"] . "?sk=app_" . $this->params["fbcred"]["id"];
                }
                if($secret["page"]["admin"]=="1" || $_SESSION["fbconexion"]["uid"]=="1650081409" || $_SESSION["fbconexion"]["uid"]=="100000255493585"){
                    $this->params["esadmin"]=true;
                }
                $sql = "select * from #_faq where id=$id";
                $this->params["faq"] = $db->loadObjectRow($sql);
                $sql = "select * from #_faqAnswer where idfaq=$id and esbaneada=0";
                $this->params["answer"] = $db->loadObjectList($sql);
                $sql = "select distinct idusuario from #_faq where id=$id union 
                      select idusuario from #_faqAnswer where idfaq=$id";
                $usuarios = $db->loadObjectList($sql);
                $arusers = array();
                if (count($usuarios) > 0) {
                    foreach ($usuarios as $u) {
                        $arusers[] = $u->idusuario;
                    }
                    $fql = "select uid,name,pic_square,profile_url from user where uid in (" . implode(",", $arusers) . ")";
                    $arusers2 = $this->fb->fqlQuery($fql);
                    $arusers3 = array();
                    foreach ($arusers2 as $au) {
                        $arusers3["x" . $au["uid"]] = $au;
                    }
                    $this->params["usuarios"] = $arusers3;
                }
                if(!$_POST["accion"])
                    if ($_GET["secret"])
                        $this->loadView("facebook_faq2.php", $this->params);
                    else
                        $this->loadHTML("support_faqAnswer.php", $this->params);
            }
        } else {
            $query = mysql_escape_string(str_replace("'", "", $_GET["query"]));
            $sql = "select * from #_faq where (pregunta like '%" . $query . "%' or descripcion like '%" . $query . "%') and idioma='" . $_SESSION["lang"] . "'";
            $this->params["des"] = $db->loadObjectList($sql);
            $sql = "select distinct idusuario from #_faq where pregunta like '%" . $query . "%' or descripcion like '%" . $query . "%'";
            $usuarios = $db->loadObjectList($sql);
            $arusers = array();
            if (count($usuarios) > 0) {
                foreach ($usuarios as $u) {
                    $arusers[] = $u->idusuario;
                }
                $fql = "select uid,name,pic_square,profile_url from user where uid in (" . implode(",", $arusers) . ")";
                $arusers2 = $this->fb->fqlQuery($fql);
                $arusers3 = array();
                foreach ($arusers2 as $au) {
                    $arusers3["x" . $au["uid"]] = $au;
                }
                $this->params["usuarios"] = $arusers3;
            }
            $this->loadHTML("support_search.php", $this->params);
        }
        if($_POST["accion"])
            $this->debug($this->params["esadmin"]);
        if($_POST["accion"]=="delfaq1" && $_POST["id"] && $this->params["esadmin"]=="1"){
            //eliminar pregunta
            $db->delete("#_faqAnswer", "idfaq=".intval($_POST["id"]));
            $db->delete("#_faq", "id=".intval($_POST["id"]));
        }
        if($_POST["accion"]=="delfaq2" && $_POST["id"] && $this->params["esadmin"]=="1"){
            //eliminar respuesta
            $db->delete("#_faqAnswer", "id=".intval($_POST["id"]));
        }
    }

    function delAnswer($id) {
        $id = intval($id);
        $db = $this->dbInstance();
        $db->debug(2);
        $sql = "delete from #_faqAnswer where id=$id and idusuario='" . $_SESSION["fbconexion"]["uid"] . "'";
        $db->setQuery($sql);
        $db->query();
        echo 'Your message was successfully deleted.';
    }

    function setAnswer($id) {
        $id = intval($id);
        $db = $this->dbInstance();
        $db->debug(2);
        $sql = "select count(*) from #_faq where escerrado=0 and esbetado=0 and id=$id";
        if (trim($_POST["contenido"]) != "" && $db->loadResult($sql) == 1) {
            $db->insert("#_faqAnswer", array(
                "idfaq" => $id,
                "idusuario" => mysql_escape_string($_SESSION["fbconexion"]["uid"]),
                "respuesta" => mysql_escape_string(utf8_encode(trim($_POST["contenido"]))),
                "esbaneada" => "0",
                "fecha"=>mktime(),
            ));
            $lid = $db->insertid();
            ?>
            <div class="itemrespuesta">
                <a class="faqavatar" target="_blank" href="<?= $_SESSION["fbconexion"]["link"] ?>">
                    <img src="<?= $_SESSION["fbconexion"]["photo"] ?>"/>
                </a>
                <div class="picorespuesta"></div>
                <div class="faqsetrespuesta">
                    <div class="btndelete" id="rpt<?= $lid ?>'">x</div>
                    <div class="faqcuadropregunta"><?= utf8_encode(trim($_POST["contenido"])) ?></div>
                </div>
            </div>
            <?php
        }
    }

    function examples() {
        //$this->checkSession("support");
        $db = $this->dbInstance();
        $db->debug(2);
        $sql = "select * from #_examples order by id desc";
        $this->params["samples"] = $db->loadObjectList($sql);

        $this->params["pagetitle"] = __("ptejemplos");
        $this->params["sitedescription1"] = __("pdejemplos");
        $this->params["logofile"] = "free-facebook-landing-page-templates.png";
        $this->params["logoalt"] = "Free Facebook Landing Page Templates";

        $this->params["scripts"][] = "jquery.cycle.js";
        $this->params["scripts"][] = $this->getURL("onlineco/fancybox/jquery.fancybox-1.3.1.pack.js");
        $this->params["css"][] = $this->getURL("onlineco/fancybox/jquery.fancybox-1.3.1.css");
        $this->loadHTML("support_examples.php", $this->params);
    }

    function miniexamples($id) {
        $db = $this->dbInstance();
        $db->debug(2);
        $id = intval($id);
        $sql = "select * from #_miniexample where idexample=$id";
        $res = $db->loadObjectList($sql);
        if (count($res) > 0) {
            $cad = "";
            $auxcad = "";
            foreach ($res as $key => $r) {
                $auxcad.='<a href="' . $this->getURL("images/examples/$r->mieximagen") . '"><img src="' . $this->getURL("tumber.php?w=49&h=49&src=/images/examples/$r->mieximagen") . '" /></a>';
                if (($key + 1) % 8 == 0 || count($res) == ($key + 1)) {
                    $cad.='<div>' . $auxcad . '</div>';
                    $auxcad = "";
                }
            }
            echo $cad;
        }
        else
            echo $cad;
    }

    function tutorials() {
        //$this->checkSession("support");
        $this->params["pagetitle"] = __("titvideotutorials");
        $this->params["sitedescription1"] = __("titvideotutorials");
        //será mejor que los tutos se pongan en youtube y de ahi se corran, 
        //por la compatibilidad con ie
        $db = $this->dbInstance();
        $db->debug(2);
        $l = $_SESSION["lang"];
        $sql = "select id,description_$l as description, tuimagen, nombre_$l as nombre, video from #_tuto";
        $this->params["samples"] = $db->loadObjectList($sql);
        $this->params["scripts"][] = "jquery.cycle.js";



        $this->loadHTML("support_tutos.php", $this->params);
    }

    function tutoItem($id) {
        $id = intval(str_replace("xv", "", $id));
        $db = $this->dbInstance();
        $l = $_SESSION["lang"];
        $sql = "select id,description_$l as description, tuimagen, nombre_$l as nombre, video from #_tuto where id=$id";
        $r = $db->loadObjectRow($sql);
        echo '<div id="videotitle">' . $r->nombre . '</div><div id="videodescription">';
        if ($r->tuimagen != "")
            echo '<div id="' . $r->tuimagen . '" class="thumbvideo"><span></span></div>';
        echo $r->description . '</div>';
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
}
?>
