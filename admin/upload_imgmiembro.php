<?php
if (!empty($_FILES)) {
    $narchivo= str_replace(" ","",basename(strtolower($_FILES['Filedata']['name'])));
    $ruta0 = ("../recursos/".strtolower($narchivo));
    move_uploaded_file($_FILES['Filedata']['tmp_name'], $ruta0);
    //chmod($ruta0, 755);
    //include_once("fimagenes.php");
    //ajuste_imgmax($ruta0, $ruta0, 226, 166);
    echo $narchivo;
    exit;
}
?>