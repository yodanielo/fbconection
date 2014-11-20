<?php

/**
 * Qype API
 * API Key: DBTnZ96EFKIOykmEuRcEvw (Request a Pro Account)
 * API Secret: i3Utmz09hK8akCF0u1nsa6KKFwuJjj9BJ6xKAPQo
 */
class modules extends application {

    function __construct() {
        parent::__construct();
        $this->fb = $this->loadModel("fbSDK");
        $this->fb->login();
    }

    function plans() {
        $this->params["follow"] = true;
        $this->params["pagetitle"] = __("ptplanes");
        $this->params["sitedescription1"] = __("pdplanes");
        $this->params["css"][]="internalpages.css";
//        $this->params["logofile"]="free-facebook-fan-page-creator.png";
//        $this->params["logoalt"]="Free Facebook Fan Page Creator";
        $this->loadHtml("plans_" . $_SESSION["lang"] . ".php", $this->params);
    }

    function examples() {
        $this->loadHtml("onbuild.php", $this->params);
    }

    function privacy_policy() {
        $this->params["pagetitle"] = __("ptpoliticas");
        $this->params["sitedescription1"] = __("pdpoliticas");
        $this->loadHtml("privacy.php", $this->params);
    }

    function contact_us() {
        if (LANG != "")
            $this->redirect(LANG."contactanos");
        if ($_POST["txt1"]) {
            $body = "Message sent: " . date("D F d, Y") . " at " . date("h:i a") . "<br/>";
            $body.='<strong>Issue</strong>&nbsp;' . $_POST["txt1"] . "<br/>";
            $body.='<strong>Subject</strong>&nbsp;' . $_POST["txt2"] . "<br/>";
            $body.='<strong>Name</strong>&nbsp;' . $_POST["txt3"] . "<br/>";
            $body.='<strong>E-mail</strong>&nbsp;' . $_POST["txt4"] . "<br/>";
            $body.='<strong>Message</strong>&nbsp;' . $_POST["txt5"] . "";

            $Mail = $this->loadLib("phpmailer");
            $Mail->From = "info@fbconexion.com";
            $Mail->FromName = "FB Conexion";
            //$Mail->AddAddress("kreymundo@gmail.com");
            $Mail->AddAddress("info@fbconexion.com");
            $Mail->AddReplyTo($Mail->From);
            $Mail->Subject = "Contact Message - " . $_POST["txt1"];
            $Mail->IsHTML(true);
            $Mail->Body = utf8_decode($body);
            $Mail->Send();
        }
        $this->params["follow"] = true;
        $this->params["pagetitle"] = __("ptcontactenos");
        $this->params["sitedescription1"] = __("pdcontactenos");
        $this->loadHtml("contact.php", $this->params);
    }

    function contactanos() {
        if ($_POST["txt1"]) {
            $body = "Message sent: " . date("D F d, Y") . " at " . date("h:i a") . "<br/>";
            $body.='<strong>Issue</strong>&nbsp;' . $_POST["txt1"] . "<br/>";
            $body.='<strong>Subject</strong>&nbsp;' . $_POST["txt2"] . "<br/>";
            $body.='<strong>Name</strong>&nbsp;' . $_POST["txt3"] . "<br/>";
            $body.='<strong>E-mail</strong>&nbsp;' . $_POST["txt4"] . "<br/>";
            $body.='<strong>Message</strong>&nbsp;' . $_POST["txt5"] . "";

            $Mail = $this->loadLib("phpmailer");
            $Mail->From = "info@fbconexion.com";
            $Mail->FromName = "FB Conexion";
            //$Mail->AddAddress("kreymundo@gmail.com");
            $Mail->AddAddress("info@fbconexion.com");
            $Mail->AddReplyTo($Mail->From);
            $Mail->Subject = "Contact Message - " . $_POST["txt1"];
            $Mail->IsHTML(true);
            $Mail->Body = utf8_decode($body);
            $Mail->Send();
        }
        $this->params["pagetitle"] = __("ptcontactenos");
        $this->params["sitedescription1"] = __("pdcontactenos");
        $this->loadHtml("contact_es.php", $this->params);
    }

    function about_us() {
        $this->params["follow"] = true;
        $this->params["pagetitle"] = __("ptnosotros");
        $this->params["sitedescription1"] = __("pdnosotros");
        $this->params["logofile"]="facebook-fan-page-generator-software.png";
        $this->params["logoalt"]="Facebook Fan Page Generator Software";
        $this->loadHtml("aboutus_" . $_SESSION["lang"] . ".php", $this->params);
    }

    function partnerships() {
        $this->params["pagetitle"] = __("ptasociados");
        $this->params["sitedescription1"] = __("pdasociados");
        $this->loadHtml("partners.php", $this->params);
    }

    function terms_of_service() {
        $this->params["pagetitle"] = __("ptterminos");
        $this->params["sitedescription1"] = __("pdterminos");
        $this->loadHtml("terms2.php", $this->params);
    }

    function incompatible() {
        $this->loadView("incompatible_" . $_SESSION["lang"] . ".php");
    }

    function register() {
        $this->loadView("register_" . $_SESSION["lang"]) . ".php";
    }

    function unsuscribe() {
        $token = mysql_escape_string($_GET["token"]);
        $mail = mysql_escape_string($_GET["mail"]);
        $db = $this->dbInstance();
        if ($token == md5($mail))
            $db->delete("#_suscriptores", "md5(email)='$mail'");
        $this->loadHtml("unsuscribe.php");
    }

    function landing($index=0) {
        if (intval($index) == 0) {
            $this->redirect("landing/1");
        }

        switch ($index) {
            case 2:
                $this->params["pagetitle"] = "Facebook-Diseño-Fan-Page-Empresa";
                $this->params["sitedescription1"] = "Mejora tu negocio en Facebook, Diseña tu Fan Page Gratis, Obten Clicks Me Gusta";
                break;
            case 3:
                $this->params["pagetitle"] = "Facebook-Diseño-Fan-Page-Redes-Sociales-Comunidad";
                $this->params["sitedescription1"] = "Crea, Diseña tu Facebook Page Gratis, Conectate con las Redes Sociales, Fideliza a tu comunidad en Facebook";
                break;
            case 1:
                $this->params["pagetitle"] = "Facebook-Diseño-Fan-Page-Tabs-Me-Gusta-Like";
                $this->params["sitedescription1"] = "Con creatividad aumenta tus Fans, Sorprende tu club de Fans, Resalta tu imagen en Facebook, Mejora tu pagina Facebook Diseños Gratis";
                break;
        }
        $this->loadView("landing_header.php", $this->params);
        $this->loadView("landing_body$index.php", $this->params);
        $this->loadView("landing_footer.php", $this->params);
    }

    function pagina_fan_facebook_empresa_web_2_0_landing_page() {
        $this->params["pagetitle"] = "Facebook-Diseño-Fan-Page-Redes-Sociales-Comunidad";
        $this->params["sitedescription1"] = "Crea, Diseña tu Facebook Page Gratis, Conectate con las Redes Sociales, Fideliza a tu comunidad en Facebook";
        $this->loadView("landing_header.php", $this->params);
        $this->loadView("landing_body1.php", $this->params);
        $this->loadView("landing_footer.php", $this->params);
    }

    function como_crear_hacer_personalizar_facebook_fan_pages_templates_marketing_viral() {
        $this->params["pagetitle"] = "Facebook-Diseño-Fan-Page-Empresa";
        $this->params["sitedescription1"] = "Mejora tu negocio en Facebook, Diseña tu Fan Page Gratis, Obten Clicks Me Gusta";
        $this->loadView("landing_header.php", $this->params);
        $this->loadView("landing_body2.php", $this->params);
        $this->loadView("landing_footer.php", $this->params);
    }

    function facebook_fan_page_web_2_0_empresa_redes_sociales() {
        $this->params["pagetitle"] = "Facebook-Diseño-Fan-Page-Tabs-Me-Gusta-Like";
        $this->params["sitedescription1"] = "Con creatividad aumenta tus Fans, Sorprende tu club de Fans, Resalta tu imagen en Facebook, Mejora tu pagina Facebook Diseños Gratis";
        $this->loadView("landing_header.php", $this->params);
        $this->loadView("landing_body3.php", $this->params);
        $this->loadView("landing_footer.php", $this->params);
    }
    
    function customizedfanpage(){
        $this->checkSession();
        if ($_SESSION["fbconexion"]["idplan"] <= "1") {
            $this->redirect(LANG . "plans");
        }
        $this->loadHtml("customize1.php", $this->params);
    }
    function customizedfanpageorder(){
        if ($_POST["txt1"]) {
            $body = "Message sent: " . date("D F d, Y") . " at " . date("h:i a") . "<br/>";
            $body.='<strong>Issue</strong>&nbsp;Customized page<br/>';
            $body.='<strong>First Name</strong>&nbsp;' . $_POST["txt1"] . "<br/>";
            $body.='<strong>Last Name</strong>&nbsp;' . $_POST["txt2"] . "<br/>";
            $body.='<strong>E-mail</strong>&nbsp;' . $_POST["txt3"] . "<br/>";
            $body.='<strong>Phone</strong>&nbsp;' . $_POST["txt4"] . "<br/>";
            $body.='<strong>Description</strong>&nbsp;' . $_POST["txt5"] . "<br/>";

            $Mail = $this->loadLib("phpmailer");
            $Mail->From = "info@fbconexion.com";
            $Mail->FromName = "FB Conexion";
            //$Mail->AddAddress("kreymundo@gmail.com");
            $Mail->AddAddress("info@fbconexion.com");
            $Mail->AddReplyTo($Mail->From);
            $Mail->Subject = "Customized Fan Page - " . $_POST["txt1"];
            $Mail->IsHTML(true);
            $Mail->Body = utf8_decode($body);
            $Mail->Send();
        }
    }
    
    function linksDirectory($pag=1){
        $pag=intval($pag);
        $db=$this->dbInstance();
        $sql="select * from #_directory";
        $r=$this->loadLib("paginacion");
        $this->params["pagetitle"] = __("Links Directory");
        $this->params["sitedescription1"] = __("Links Directory");
        $this->params["res"]=$r->doPagination($db,$sql,10,$pag,$numpags);
        $this->params["pag"]=$pag;
        $this->params["numpags"]=$numpags;
        $this->loadHtml("directory.php", $this->params);
    }
    
    function mexico(){
        $_SESSION["fbpartner"]='mexico';
        if(LANG!="es/")
            $this->redirect("es/mexico");
        $_SERVER['ORIG_PATH_INFO']="";
        //$this->redirect("es");
        $h=$this->loadController("home");
        $h->params["otroindex"]="mexico";
        $h->index();
    }
    
    function webmap(){
        $this->loadHtml("mapaweb.php");
    }

    function toggleAudio($sto){
        $_SESSION["audio"]=intval($sto);
    }
}

?>
