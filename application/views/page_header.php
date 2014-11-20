<?php
$settings = $this->params["settings"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
    <head>
        <!--<?=$params["espremium"]?>-->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo ($params["pagetitle"] ? $params["pagetitle"] . " | " : "") . $params["sitename"]; ?></title>
        <meta name="Description" content="<?php echo $params["sitedescription1"]; ?>" />
        <meta name="Keywords" content="<?php echo $params["keywords"]; ?>" />
        <meta name="author" content="<?php echo $params["author"]; ?>" />
        <meta name="owner" content="<?php echo $params["owner"]; ?>" />
        <meta name="robots" content="index, follow" />
        <meta property="fb:admins" content="<?=$params["idadmin"]?>"/>
        <link rel="icon" href="<?php echo $this->getURL("images/favicon.ico") ?>" type="image/x-icon" />
        <?php
        if (count($params["css"]) > 0) {
            foreach ($params["css"] as $key => $sc) {
                if (substr($sc, 0, 7) == "http://" || substr($sc, 0, 8) == "https://")
                    echo '<link rel="stylesheet" type="text/css" href="' . $sc . '" />' . "\n";
                else
                    echo '<link rel="stylesheet" type="text/css" href="' . $this->getURL('/css/' . $sc) . '" />' . "\n";
            }
        }
        ?>
        <link rel="stylesheet" type="text/css" href="<?= $this->getURL("/css/canvas.css") ?>" />
        <!--[if IE ]>
	<link rel="stylesheet" type="text/css" href="<?= $this->getURL("/css/canvas_ie.css") ?>" />
        <![endif]-->
        <!--[if lte IE 7]>
	<link rel="stylesheet" type="text/css" href="<?= $this->getURL("/css/canvas_ie7.css") ?>" />
        <![endif]-->
        <?php
        if (count($params["scripts"]) > 0) {
            foreach ($params["scripts"] as $key => $sc) {
                if (substr($sc, 0, 7) == "http://" || substr($sc, 0, 8) == "https://")
                    echo '<script type="text/javascript" src="' . $sc . '"></script>' . "\n";
                else
                    echo '<script type="text/javascript" src="' . $this->getURL('/js/' . $sc) . '"></script>' . "\n";
            }
        }
        ?>
        <script type="text/javascript" src="<?= $this->getURL("js/generales.js") ?>"></script>
    </head>
    <body>
        <div id="fb-root"></div> 
        <script>
            window.fbAsyncInit = function() {
                FB.init({
                    appId: '<?= $params["appid"] ?>',
                    status: true, 
                    cookie: true,
                    xfbml: true
                });
                FB.Canvas.setAutoResize();
            };
            (function() {
                var e = document.createElement('script'); 
                e.async = true;
                e.src = document.location.protocol +
                    '//connect.facebook.net/en_US/all.js';
                document.getElementById('fb-root').appendChild(e);
            }());
        </script>
        <?php
        $cadpre='';
        //print_r($params);
        if ($params["espremium"] !=4 || $params["showbrand"])
            $cadpre.='<a href="'.$this->getURL("") .'" target="_blank">
                    <img  style="height:20px; float:right;" src="'.$this->getURL("images/ico_poweredby.png") .'" alt="FB Conexion"/>
                </a>';
        if ($params["admin"] == 1){
            $urladmin="";
            if($params["escupon"])
                $urladmin=$this->getURL("fbconexion/coupon/".$params["idtab"]);
            else
                $urladmin=$this->getURL("fbconexion/page/".$params["idtab"]);
            $cadpre.='<span style="float:left;height:25px;width:100px;"><a id="linkeditar" href="' . $urladmin. '" target="_blank">Edit this tab</a></span>';
        }
        if($cadpre!=""){
            ?>
            <div style="text-align: center; background: #fff; position:relative; z-index:9999; float:left; width:100%;">
                <?php
                echo $cadpre;
                ?>
                
            </div>
            <?php
        }
        ?>
        <canvas id="bgeditor" style="<?=$cadpre==""?"margin-top:0px;":""?>"></canvas>
        <script type="text/javascript">
            function redim_canvas(){
                //$("#bgeditor").attr("height",$("#conteditor").height());
                if($("#wrapper").height()<520)
                    $("#wrapper").height(520)
                $("#bgeditor").attr("width",$("#wrapper").width());
                $("#bgeditor").attr("height",$("#wrapper").height());
                $("#bgeditor").height($("#wrapper").height());
                $("#bgeditor").gradient({
                    type:"<?= strtolower($settings->edb_w1c) ?>",
                    width:520,
                    height:$("#wrapper").height(),
                    colors:[
                        <?php
                        $fc = ($settings->edb_w1a != "" ? $settings->edb_w1a : "#ffffff");
                        echo "'" . $fc . "',\n";
                        $sc = (trim($settings->edb_w1b) != "" ? $settings->edb_w1b : $fc);
                        echo "'" . $sc . "'\n";
                        ?>
                    ]
                });
                $("#bgeditor").css("background-color","<?= $sc ?>");

            }
            <?php
            if(!$params["escupon"]){
            ?>
            $(document).ready(function(){
                <?php
                if($settings->edb_w7!=""){
                    ?>
                            $("#wrapper").height(<?=$settings->edb_w7?>);
                    <?php
                }
                else{
                    ?>
                    redim=function(){
                        mayor=0;
                        $(".wm_editor").each(function(){
                            medida=$(this).outerHeight()+$(this).position().top;
                            if(medida>mayor){
                                mayor=medida;
                            }
                        });
                        $("#contador").html(mayor)
                        if(mayor+10<520)
                            $("#wrapper").height(520)
                        else
                            $("#wrapper").height(mayor+10);
                    }
                    setInterval(redim, 450);
                    <?php
                }
                ?>
                setInterval(redim_canvas,3000);
            })
            <?php
            }
            ?>
        </script>
        <div id="wrapper" style="background-image: url(<?= $settings->edb_w2 ?>); background-position: <?= str_replace("+"," ",$settings->edb_w3) ?>; background-repeat: <?= $settings->edb_w4 ?>;<?= (intval($settings->edb_w7) > 0 ? "height:" . $settings->edb_w7 . "px;" : "") ?>overflow:hidden; position:relative; z-index:10; clear:both;">
