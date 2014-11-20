<?php
include 'rss/rayfeedreader.php';
include 'rss/rayfeedwidget.php';
$url = "http://" . $_GET["feed"];
$showtitle=($_GET["showtitle"]=="no"?false:true);
$display=($_GET["display"]==""?"brief":$_GET["display"]);
$posts=($_GET["posts"]==""?"5":$_GET["posts"]);

function limitarLetras($str, $n = 500, $end_char = '&#8230;') {
    $str = strip_tags($str);
    if (strlen($str) < $n)
        return $str;
    $str = preg_replace("/\s+/", ' ', str_replace(array("\r\n", "\r", "\n"), ' ', $str));
    if (strlen($str) <= $n)
        return $str;
    $out = "";
    foreach (explode(' ', trim($str)) as $val) {
        $out .= $val . ' ';
        if (strlen($out) >= $n) {
            $out = trim($out);
            return (strlen($out) == strlen($str)) ? $out : $out . $end_char;
        }
    }
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <style type="text/css">
            *{
                padding: 0px;
                margin:0px;
                font-family: Arial;
                font-size: 12px;
                text-decoration: none;
                /*color:#000;*/
            }
            .feed-title{
                line-height: 20px;
                background: #F0F0F0;
                padding: 10px;
            }
            .feed-item{
                line-height: 16px;
                padding: 5px 10px;
            }
            .feed-title h2{
                font-size: 16px;
                font-weight: bold;
            }
            .feed-item-description *{
                text-align: justify;
            }
            .feed-item-description{
                overflow: hidden;
                text-align: justify;
            }
            #cuerpo{
                overflow: hidden;
                width: 100%;
            }
        </style>
    </head>
    <body>
        <div id="cuerpo">
            <?php
            $opciones = array(
                'url' => $url,
                'widget' => 'RayFeedWidget',
            );
            $widget =array(
                'showTitle' => $showtitle,
                'widget' => $display,
                'posts' => $posts,
            );
            $reader1 = RayFeedReader::getInstance()->setOptions($opciones)->parse()->widget($widget);
            echo $reader1;
            ?> 
        </div>
        <div id="marca"></div>
    </body>
</html>
