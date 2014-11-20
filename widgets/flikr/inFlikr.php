<?php

include 'phpFlickr.php';
$key = "20f1d9198e9dc5b5f8876c4ed03c95f3";
$username = $_REQUEST["username"];

$f = new phpFlickr($key);
$f->enableCache("fs", "./cache");
$result = $f->people_findByUsername($username);
// grab our unique user id from the $result array 
$nsid = $result["id"];
$photos = $f->people_getPublicPhotos($nsid, NULL, NULL, null, null);

$pages = $photos[photos][pages]; // returns total number of pages  
$total = $photos[photos][total]; // returns how many photos there are in total 

switch ($_REQUEST["estilo"]) {
    case 0:
        $result = array();
        if (count($photos['photos']['photo']) > 0)
            foreach ($photos['photos']['photo'] as $photo) {
                $result[] = array("src" => $f->buildPhotoURL($photo, "medium_640"), "title" => $photo["title"]);
            }
        echo json_encode($result);
        break;
    case 1:
        if (count($photos['photos']['photo']) > 0)
            foreach ($photos['photos']['photo'] as $photo) {
                echo '<img src="' . $f->buildPhotoURL($photo, "medium_640") . '" title="Description:" caption="' . $m->edb_wd[$key] . '" link="" target="_blank" pause="" vidpreview="" />';
            }
        break;
}
?>