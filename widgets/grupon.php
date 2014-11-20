<?php
$url="http://api.groupon.com/v2/deals/".$_GET["url"]."?client_id=817eca6ffcac06bf6943cb2b39048cfd0cb8f6ee";
$x=  file_get_contents($url);
echo $x;
?>
