<?php
function fechainexacta($t) {
    $s = mktime() - $t+3600;
    $l=$_SESSION["lang"];
    //echo mktime()." / ".$t;
    if ($s < 60) {
        return ($l=="es"?"Hace pocos segundos":"Few seconds ago");
    }
    else{
        //minutos
        $m=($s-($s%60))/60;
        if($m==1){
            $cad=($l=="es"?"1 minuto":"1 minute");
        }elseif($m>1){
            $aux=$m%60;
            $cad=($l=="es"?"$aux minutos":"$aux minutes");
        }
        //horas
        $h=($m-($m%60))/60;
        if($h==1){
            $cad=($l=="es"?"1 hora":"1 hour").($cad!=""?($l=="es"?" y ":" and ").$cad:"");
        }elseif($h>1){
            $aux=$h%24;
            $cad=($l=="es"?"$aux horas":"$aux hours").($cad!=""?($l=="es"?" y ":" and ").$cad:"");
        }
        //days
        $d=($h-($h%24))/24;
        if($d==1){
            $cad=($l=="es"?"1 día":"1 day").($cad!=""?", ".$cad:"");
        }elseif($d>1 && $d<=2){
            $cad=($l=="es"?"$d días":"$d days").($cad!=""?", ".$cad:"");
        }else{
            $cad="";
        }
        if($cad!="")
            return ($l=="es"?"Hace ".$cad:$cad." ago").".";
        else{
            $fecha=date("l F d, Y \a\t h:i a", $t);
            if($l=="es"){
                $fecha=date("l d \d\e F \d\e Y \a \l\a\s  h:i a",$t);
                $meses_en=array("January","February","March","April","May","June","July","August","September","October","November","December");
                $meses_es=array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
                $dias_en=array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
                $dias_es=array("Lunes","Martes","Miércoles","Jueves","Viernes","Sábado","Domingo");
                $fecha=str_replace($meses_en,$meses_es,$fecha);
                $fecha=str_replace($dias_en,$dias_es,$fecha);
            }
            return $fecha;
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>a</title>
        <link type="text/css" rel="stylesheet" href="<?= $this->getURL("application/views/customized/fbconexion/nav.css") ?>" />
        <script type="text/javascript" src="http://www.fbconexion.com/onlineco/js/jquery-1.4.4.min.js"></script>
    </head>
    <body>
        <div id="fb-root"></div>
        <script type="text/javascript">
            window.fbAsyncInit = function() {
                FB.init({
                    appId: '<?= $params["fbcred"]["id"] ?>',
                    status: true, 
                    cookie: true,
                    xfbml: true,
                    //channelUrl  : 'http://www.fbconexion.com/channel.html',
                    oauth : true
                });
                function updateButton(response) {
                    $("#btnfacebook").click(function(){
                        //if (response.status == 'connected')
                        FB.logout(function(response){});
                        FB.login(function(response) {
                            if (response.status === 'connected') {
                                $.ajax({
                                    url:"<?= $this->getURL("/doSession") ?>",
                                    success:function(data){
                                        if(data.indexOf("ok")>-1){
                                            top.location.href="<?= $this->getURL($_SESSION["lang"] . "/fbconexion") ?>";
                                        }
                                    }
                                })
                            }
                        },{
                            "scope":"manage_pages,user_likes,offline_access,publish_stream,email"
                        });
                        return false;
                    })
                }

                // run it once with the current status and also whenever the status changes
                FB.getLoginStatus(updateButton);
                
                function autores(){
                    FB.Canvas.setAutoResize();
                    setTimeout(autores, 450);
                }
                autores();
            };
            (function() {
                e = document.createElement('script'); 
                e.async = true;
                e.src = document.location.protocol +
                    '//connect.facebook.net/en_US/all.js';
                document.getElementById('fb-root').appendChild(e);
            }());
        </script>
        <div id="wrapper">
            <div style="float:right">
                <a style="padding: 5px;" target="_parent" href="http://www.facebook.com/Fan.Page.Latino?sk=app_323933867623019"><img src="http://www.fbconexion.com/images/flag_peru.png"></a>
                <a style="padding: 5px;" target="_parent" href="http://www.facebook.com/online.conexion?sk=app_323933867623019"><img src="http://www.fbconexion.com/images/usa_flag.png"></a>
            </div>
            <div id="combarrasep"></div>
            <div id="contcomentarios">
                <?php
                if (count($params["res"]) > 0) {
                    foreach ($params["res"] as $r) {
                        ?>
                        <div class="comitem">
                            <div class="comglobo1">
                                <img src="<?= $this->getURL("images/comments-quote.png") ?>" class="comquote" />
                                <div class="comglobo2">
                                    <div class="comglobo3">
                                        <div class="comtexto">
        <?= trim($r->comentario) ?>
                                        </div>
                                        <div class="contestrellas">
                                            <div class="scrollstrella" style="width:<?= ceil($r->promedio) * 20 ?>px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a class="comavatar" target="_blank" href="http://www.facebook.com/<?= $r->uid ?>"><img style="width:30px; float:left; margin-right: 5px;" src="http://graph.facebook.com/<?= $r->uid ?>/picture"/><?= $r->firstname . " " . $r->lastname ?><br/><span><?= fechainexacta($r->fecha2) ?></span></a>
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <div class="nohay"><?= __("txtnoitemstoshow") ?></div>
                    <?php
                }
                ?>
            </div>
        </div>
    </body>
</html>
