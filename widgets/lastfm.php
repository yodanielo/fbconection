<?php
if($_GET["username"]){
    $url="http://ws.audioscrobbler.com/2.0/?method=user.getplaylists&user=".$_GET["username"]."&api_key=fd2ba71038ffd7e52a2419be379ba480";
    $obj=new DOMDocument("1.0", "utf-8");
    $obj->load($url);
    $pl=$obj->getElementsByTagName("playlist");
    $cad='';
    for($i=0;$i<$pl->length;$i++){
        $img=$pl->item($i)->getElementsByTagName("image")->item(1)->nodeValue;
        $cad.='
            <div class="lfitem">
                <a target="_blank" class="lfmimage" href="'.$pl->item($i)->getElementsByTagName("url")->item(0)->nodeValue.'">
                    <div><img src="'.($img?$img:"/images/lastfm_default_playlist.jpg").'"/></div>
                </a>
                <a target="_blank" class="lfcuerpo" href="'.$pl->item($i)->getElementsByTagName("url")->item(0)->nodeValue.'">
                    <span class="lfmtitle">'.$pl->item($i)->getElementsByTagName("title")->item(0)->nodeValue.'</span></br>
                    <span class="lfmdesc">'.$pl->item($i)->getElementsByTagName("description")->item(0)->nodeValue.'</span>
                </a>
            </div>';
    }
    echo $cad;
}
?>
