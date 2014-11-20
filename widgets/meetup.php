<?php
$color1=($_GET["color1"]?$_GET["color1"]:"#8E466C");
$color2=($_GET["color2"]?$_GET["color2"]:"#FFE7D8");
$url = "http://api.meetup.com/groups.xml/?group_urlname=" . $_GET["group"] . "&order=members&key=177365666a1c1b684168682d3351546f";
$xml = new DOMDocument("1.0", "utf-8");
$xml->load($url);
$res = $xml->getElementsByTagName("item");
$r = $res->item(0);
?>
<?php/*
<style type="text/css">
    .muptodo{
        float:left;
        width:100%;
    }
    .muptop{
        float:left;
        width:100%;
        margin-bottom:10px;
        padding: 10px 0px;
    }
    .mupmapa,
    .mupavatar{
        float:left;
        width:180px;
        height:180px;
        border:1px solid #CFCFCF;
        margin-left: 10px;
    }
    .mupmapa{
        float:right;
        margin-right: 10px;
    }
    .mupchars td{
        font-family: verdana, geneva, sans-serif;
        font-size:12px;
        padding-left: 15px;
        line-height: 20px;
        height:20px;
    }
    .mupcontent{
        float:left;
        width:100%;
    }
    .muptitle{
        font-family: Georgia, palatino, 'times new roman', serif;
        font-size: 23px;
        padding: 10px 10px 0px 10px;
        font-weight: bold;
    }
    .mupdescription{
        font-family: verdana, geneva, sans-serif;
        font-size: 12px;
        padding: 10px;
        text-align: justify;
    }
</style>
 */?>
<div class="muptodo">
    <div class="muptop" style="background:<?=$color1?>">
        <div class="mupavatar" style="background:#fff url(<?= $r->getElementsByTagName("photo_url")->item(0)->nodeValue ?>) center no-repeat;"></div>
        <?php
        $lat = $r->getElementsByTagName("lat")->item(0)->nodeValue;
        $lon = $r->getElementsByTagName("lon")->item(0)->nodeValue;
        if ($lat != "" && $lon != "")
            echo $img = '<a target="_blank" href="http://maps.google.com/maps?q=' . $lat . ',' . $lon . '&hl=es&sll=' . $lat . ',' . $lon . '&sspn=' . $lat . ',' . $lon . '&vpsrc=0&t=h&z=16"><img class="mupmapa" src="http://maps.google.com/maps/api/staticmap?center=' . $lat . ',' . $lon . '&zoom=16&size=180x180&sensor=false&maptype=roadmap&markers=' . $lat . ',' . $lon . '" /></a>';
        ?>
        <div class="mupchars" style="clear: both;width: 100%;float: left;">
            <table border="0" cellpaddin="0" cellspacing="0" style="color:<?=$color2?>">
                <tr><td>Members:</td><td><?= $r->getElementsByTagName("members")->item(0)->nodeValue ?></td></tr>
                <tr><td>Rating:</td><td><?= $r->getElementsByTagName("rating")->item(0)->nodeValue ?></td></tr>
                <tr><td>Created:</td><td><?= $r->getElementsByTagName("created")->item(0)->nodeValue ?></td></tr>
                <tr><td>Country:</td><td><?= $r->getElementsByTagName("country")->item(0)->nodeValue ?></td></tr>
                <tr><td>City:</td><td><?= $r->getElementsByTagName("city")->item(0)->nodeValue ?></td></tr>
                <tr><td>Organizer:</td><td><a style="color:<?=$color2?>" href="<?= $r->getElementsByTagName("organizerProfileURL")->item(0)->nodeValue ?>"><?= $r->getElementsByTagName("organizer_name")->item(0)->nodeValue ?></a></td></tr>
            </table>
        </div>
    </div>
    <div class="mupcontent" style="background:<?=$color2?>">
        <div class="muptitle"><a href="<?= $r->getElementsByTagName("link")->item(0)->nodeValue ?>" style="color: <?=$color1?>"><?= $r->getElementsByTagName("name")->item($r->getElementsByTagName("name")->length-1)->nodeValue ?></a></div>
        <div class="mupdescription" style="color: <?=$color1?>"><?= nl2br($r->getElementsByTagName("description")->item(0)->nodeValue) ?></div>
    </div>
</div>