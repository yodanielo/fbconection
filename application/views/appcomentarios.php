<?php

function fechainexacta($t) {
    $s = mktime() - $t + 3600;
    $l = $_SESSION["lang"];
    //echo mktime()." / ".$t;
    if ($s < 60) {
        return ($l == "es" ? "Hace pocos segundos" : "Few seconds ago");
    } else {
        //minutos
        $m = ($s - ($s % 60)) / 60;
        if ($m == 1) {
            $cad = ($l == "es" ? "1 minuto" : "1 minute");
        } elseif ($m > 1) {
            $aux = $m % 60;
            $cad = ($l == "es" ? "$aux minutos" : "$aux minutes");
        }
        //horas
        $h = ($m - ($m % 60)) / 60;
        if ($h == 1) {
            $cad = ($l == "es" ? "1 hora" : "1 hour") . ($cad != "" ? ($l == "es" ? " y " : " and ") . $cad : "");
        } elseif ($h > 1) {
            $aux = $h % 24;
            $cad = ($l == "es" ? "$aux horas" : "$aux hours") . ($cad != "" ? ($l == "es" ? " y " : " and ") . $cad : "");
        }
        //days
        $d = ($h - ($h % 24)) / 24;
        if ($d == 1) {
            $cad = ($l == "es" ? "1 día" : "1 day") . ($cad != "" ? ", " . $cad : "");
        } elseif ($d > 1 && $d <= 2) {
            $cad = ($l == "es" ? "$d días" : "$d days") . ($cad != "" ? ", " . $cad : "");
        } else {
            $cad = "";
        }
        if ($cad != "")
            return ($l == "es" ? "Hace " . $cad : $cad . " ago") . ".";
        else {
            $fecha = date("l F d, Y \a\t h:i a", $t);
            if ($l == "es") {
                $fecha = date("l d \d\e F \d\e Y \a \l\a\s  h:i a", $t);
                $meses_en = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
                $meses_es = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                $dias_en = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
                $dias_es = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
                $fecha = str_replace($meses_en, $meses_es, $fecha);
                $fecha = str_replace($dias_en, $dias_es, $fecha);
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
        <link type="text/css" rel="stylesheet" href="<?= $this->getURL("css/embedapp.css") ?>" />
        <script type="text/javascript" src="http://www.fbconexion.com/onlineco/js/jquery-1.4.4.min.js"></script>
    </head>
    <body>
        <!--
        
        -->
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
            <div id="comform">
                <form id="frmsubcom" method="post" action="#">
                    <label><?= __("teq6") ?></label>
                    <textarea id="comarea"></textarea>
                    <input id="comsubmit" type="submit" value="<?= __("btnsend") ?>"/>
                </form>
                <script type="text/javascript">
                    $("#frmsubcom").submit(function(){
                        FB.getLoginStatus(function(response) {
                            if (response.status=="connected") {
                                enviarcom(response.authResponse.userID);
                            } else {
                                FB.login(function(response) {
                                    if (response.status=="connected") {
                                        enviarcom(response.authResponse.userID);
                                    }
                                }, {scope: 'email'});
                            }
                        });
                        return false;
                    })
                    enviarcom=function(x){
                        if($("#comarea").val().split(" ").join("").split("\n").join("")!="" && x!=""){
                            $("#comsubmit").val("<?= __("Sending") ?>...");
                            $("#comsubmit").attr("disabled", "disabled");
                            $.ajax({
                                url:"<?= $this->getURL(LANG . "otherapps/comments") ?>",
                                data:"signed=<?= urlencode($_REQUEST["signed_request"]) ?>&txt1="+encodeURIComponent($("#comarea").val())+"&txt2="+encodeURIComponent(x),
                                type:"POST",
                                success:function(data){
                                    
                                    top.location.href="<?= $params["pageurl"] ?>";
                                }
                            })
                        }
                    }
                </script>
            </div>
            <div id="combarrasep"></div>
            <div id="contcomentarios">
                <?php
                if (count($params["res"]) > 0) {
                    foreach ($params["res"] as $r) {
                        ?>
                        <div class="comitem">
                            <?php
                            if ($params["isadmin"] == "1") {
                                echo '<a href="#" class="comdel" alt="' . $r->id . '">X</a>';
                            }
                            ?>
                            <div class="comglobo1">
                                <img src="<?= $this->getURL("images/comments-quote.png") ?>" class="comquote" />
                                <div class="comglobo2">
                                    <div class="comglobo3">
                                        <div class="comtexto">
                                            <?= trim(strip_tags($r->descripcion)) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a class="comavatar" target="_blank" href="http://www.facebook.com/<?= $r->uid ?>"><img style="width:30px; float:left; margin-right: 5px;" src="http://graph.facebook.com/<?= $r->uid ?>/picture"/><span><fb:name uid="<?= $r->uid ?>" linked="false" capitalize="true" /></span><br/><span><?= fechainexacta($r->fecha2) ?></span></a>
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
        <?php
        if ($params["isadmin"] == "1") {
            ?>
            <script type="text/javascript">
                $(".comdel").click(function(){
                    esto=$(this);
                    if(confirm("<?=__("Are you sure, you want to delete this comment?")?>")){
                        $.ajax({
                            url:"<?=$this->getURL(LANG."otherapps/comments")?>",
                            data:"signed=<?= urlencode($_REQUEST["signed_request"]) ?>&idc="+encodeURIComponent($(this).attr("alt")),
                            type:"POST",
                            success:function(data){
                                esto.parent().fadeOut(450, function(){});
                            }
                        })
                    }
                    return false;
                })
            </script>
            <?php
        }
        ?>
    </body>
</html>
