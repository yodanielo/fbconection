<?php
if($_SESSION["fbconexion"]["INTROFB"])
    $params["espremium"]=4;
function semuestra($marca,$params){
    $widgets=array(
        array(17,1,2,3,5,7,9,12,15,18,23,29),
        array(4,8,10,13,14,19,21,22,24,25,26,27),
        array(30,31,32,33),
        array(),
    );
    $marca=preg_replace("/(w)([^\_]+)(.+)/","$2",$marca);
    $p=4;//para que no salga en ninguno de los casos
    for($i=0;$i<4;$i++){
        $f=false;
        foreach($widgets[$i] as $j){
            if($marca*1-$j==0){
                $f=true;
            }
        }
        if($f==true){
            $p=$i;
        }
    }
    if($params["espremium"]>=$p)
        return true;
    else
        return false;
}
$mast=0;
/*if ($params["espremium"] !=4)
    $mast=28;
if ($params["admin"] == 1)
    $mast=28;*/
if ($params["liked"] == 0 && trim($params["settings"]->edb_w6) != "") {
    echo '<img class="wm_editor" src="' . $params["settings"]->edb_w6 . '"/>';
} else {
    $a = explode(",", $params["estructura"]);
    if (count($a) > 0)
        foreach ($a as $b) {
            if (count($params["widgets"]) > 0)
                foreach ($params["widgets"] as $c) {
                    if ($b == $c->marca) {
                        $wm = explode("_", str_replace("w", "wm", $c->estructura));
                        $r = json_decode(rawurldecode($c->estructura));
                        echo '<div class="wm_editor ' . $wm . '" id="' . $b . '" style="top:'.abs($r->top+$mast).'px; left:'.abs($r->left).'px; width:' . ($r->width ? $r->width : 150) . 'px; height:' . ($r->height ? $r->height : 150) . 'px; ' .($r->sp_1!=""?"z-index:$r->sp_1;":"") . ';'.($r->sp_2=="1"?'border: '.$r->sp_4.'px solid '.$r->sp_3:"").'"><div class="wm_edco">';
                        if(semuestra($c->marca,$params) || 1==1)
                            echo $c->contenido_prod;
                        else
                            echo '<img src="'.$this->getURL("images/premium-feature.jpg").'" alt=""/>';
                        echo '</div></div>';
                    }
                }
        }
}
?>
