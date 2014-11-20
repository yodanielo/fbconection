<?php
include 'galleryfrompicasa.class.php';
$gallery=new GalleryFromPicasa(); 
$username="yangosinpistola";
$pictures=$gallery->getPictures($user_picasaweb, 'Imágenes de Blogger',"32c"); 
echo '<pre>';
print_r($pictures);
echo '</pre>';
?>
