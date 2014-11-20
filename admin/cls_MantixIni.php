<?php
include("cls_MantixMenu.php");
$menu =new MantixMenu();
$menu->opciones = array(
        array("titulo"=>"Admins"   ,"url"=>"usuarios.php"      ,"id"=>"usuarios"),
        array("titulo"=>"Reports"   ,"url"=>"accesosusuarios.php"        ,"id"=>"usuarios", "sub"=>array(
            array("titulo"=>"User Access"    ,"url"=>"accesosusuarios.php"      ,"id"=>"usuarios"),
            array("titulo"=>"Created Tabs"     ,"url"=>"createdtabs.php"          ,"id"=>"usuarios"),
        )),
        array("titulo"=>"Newsletter","url"=>"newsletter.php"        ,"id"=>"usuarios", "sub"=>array(
            array("titulo"=>"Newsletter"       ,"url"=>"newsletter.php"           ,"id"=>"usuarios"),
            array("titulo"=>"Suscriptores"     ,"url"=>"suscriptores.php"         ,"id"=>"usuarios"),
        )),
);
$img_top="bg-top.gif";
$usuario="";
?>