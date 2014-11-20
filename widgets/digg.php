
<?php

$x = $_GET;
$x["count"]=($x["count"] ? $x["count"] : "10");
$arreglo = array(
    "count=" . ($x["count"] ? $x["count"] : "10"),
    "topic=" . ($x["topic"] && $x["topic"] != "all" ? $x["topic"] : ""),
);
$rpt = json_decode(file_get_contents("http://services.digg.com/2.0/digg.getAll?" . implode("&", $arreglo)));
$cad = '';
if (count($rpt->diggs) > 0)
    foreach ($rpt->diggs as $key => $d) {
        if ($key < $x["count"]) {
            $url = $d->item->link;
            $cad.='
            <div class="diggitem">
                <div class="digg-btn">
                    <a target="_blank" class="digg-count" href="' . $url . '">' . $d->item->diggs . '</a>
                    <a target="_blank" class="digg-it"></a>
                </div>
                <div class="digg-story">
                    <h3><a target="_blank" href="' . $url . '">' . $d->item->title . '</a></h3>
                    <a target="_blank" href="' . $url . '"><span>' . $d->item->description . '</span></a>
                </div>
            </div>';
        }
    }
echo $cad;
?>
