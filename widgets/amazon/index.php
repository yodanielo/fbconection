<?php
//http://www.phpclasses.org/package/3687-PHP-Access-Amazon-e-commerce-Web-services.html
include("amazon.class.php");
$amazonItem = new AmazonECS_Item(); 
$xmlDocument = $amazonItem->ItemSearch('Matrix', 'DVD');
?>
