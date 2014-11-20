<?php
/**
 * database settings
 */

$cfg["database"]["server"]="localhost";
$cfg["database"]["database"]="reymundo_fbconexion";
$cfg["database"]["user"]="reymundo_root";
$cfg["database"]["password"]="JwTX0D3TT0ol";
$cfg["database"]["prefix"]="fbc_";
/**
 * site settings
 */
$cfg["site"]["indexfile"]="index.php";//el index del sitio
$cfg["site"]["useFriendlyUrl"]=true;//determina si se usan urls amigables, poner un .htaccess para habilitar esta opcion
$cfg["site"]["livesite"]=($_SERVER["HTTPS"]?"https://":"http://") . str_replace("//", "/", $_SERVER["SERVER_NAME"] . dirname($_SERVER["SCRIPT_NAME"]) . "/");//no tocar
$cfg["site"]["charset"]="utf-8";//el charset
$cfg["site"]["permitted_uri_chars"]="a-z 0-9~%.:_\-";//caracteres permitidos para las url amigables
$cfg["site"]["sitename"]="FB Conexion";//nombre del site
$cfg["site"]["sitedescription"]="";
$cfg["site"]["keywords"]="";
$cfg["site"]["author"]="Daniel Pomalaza";
$cfg["site"]["owner"]="Online Conexion";
/**
 * system settings
 */
$cfg["system"]["default_controller"]="home";
$cfg["system"]["default_method"]="index";
$cfg["system"]["default_module"]="index";
/**
 * Boot settings
 */
$cfg["boot"][0]="classes";
$cfg["boot"][1]="modules";
/**
 * Sales settings
 */
$cfg["sales"]["paypal_account"]="kreymundo@gmail.com";
/**
 * Facebook Account
 */
$cfg["fb"]["id"]="225578674172065";
$cfg["fb"]["apikey"]="13065f1d416bab295adc92b23b16fde7";//---------------
$cfg["fb"]["appsecret"]="2c774f2ff33c8db433aee0beec8c25e3";

//grupon api: 817eca6ffcac06bf6943cb2b39048cfd0cb8f6ee
?>