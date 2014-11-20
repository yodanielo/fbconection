<?php
$fbcx=explode("?",$_SERVER["REQUEST_URI"]);
if(in_array($fbcx[0],array("/es","/en"))){
    Header( "HTTP/1.1 301 Moved Permanently" ); 
    Header( "Location: http://test.fbconexion.com/es/" ); 
    exit;
}
ini_set('display_errors', '1');
ini_set('session.use_trans_sid', 0);
ini_set('session.use_cookies', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.gc_maxlifetime', 172800);
session_cache_limiter('private,must-revalidate');
session_start();
header("Cache-control: private");
//constantes del sistema
define("PHISICAL_PATH", dirname(__FILE__));
define("SYSTEM_PATH", dirname(__FILE__) . "/../sistema");
define("APP_PATH", dirname(__FILE__) . "/application");
define("MODULES", APP_PATH . "/modules.php");
define("CONTROLLERS", APP_PATH . "/controllers");
define("MODELS", APP_PATH . "/models");
define("VIEWS", APP_PATH . "/views");
define("LIBRARIES", APP_PATH . "/libraries");
define("CONFIG_PATH", APP_PATH . "/../config.php");

$_SESSION["contador"] = intval($_SESSION["contador"]) + 1;

//files to load at start system
$files = array(
    CONTROLLERS . "/application.php",
        //CONTROLLERS."/cpmodule.php"
);

//call to main files to start the system
require SYSTEM_PATH . "/lang.php";
require SYSTEM_PATH . "/object.php";
require SYSTEM_PATH . "/start.php";
//require MODULES;
if ($_GET["lang"] != "") {
    $_SESSION["lang"] = $_GET["lang"];
} else {
    $_SESSION["lang"] = "en";
}
if ($_SESSION["lang"] != "en")
    define("LANG", $_SESSION["lang"] . "/");
else
    define("LANG", "");
//idioma detectado, ahora carga de pot
//$gt=new GetTextReader($_SESSION["lang"].'.pot');
$gt = new GetTextReader($_SESSION["lang"] . '.pot');

//call to secondary files to start the system
for ($i = 0; $i < count($files); $i++) {
    if (file_exists($files[$i]))
        require $files[$i];
    else
        die('Error loading secondary file ' . $files[$i]);
}

$app = new start(CONFIG_PATH);
exit;
?>