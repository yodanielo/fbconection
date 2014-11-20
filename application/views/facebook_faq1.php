<?php
$lib=$this->loadLib("textlibs");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Support | FB Conexion</title>
        <link rel="stylesheet" type="text/css" href="http://www.fbconexion.com/css/jquery-ui-1.8.12.custom.css" />
        <link rel="stylesheet" type="text/css" href="http://www.fbconexion.com/css/nav.css" />
        <script type="text/javascript" src="http://www.fbconexion.com/onlineco/js/jquery-1.4.4.min.js"></script>
        <script type="text/javascript" src="http://www.fbconexion.com/js/jquery-ui-1.8.9.custom.min.js"></script>
        <script type="text/javascript" src="http://www.fbconexion.com/onlineco/js/plugins.js"></script>
        <script type="text/javascript" src="http://www.fbconexion.com//js/generales.js"></script>
        <script type="text/javascript">

            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-22314845-2']);
            _gaq.push(['_trackPageview']);

            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();

        </script>
    </head>
    <body style="background: none;">
        <div id="fb-root"></div>
        <script type="text/javascript">
            window.fbAsyncInit = function() {
                FB.init({
                    appId: '225578674172065',
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
                var e = document.createElement('script'); 
                e.async = true;
                e.src = document.location.protocol +
                    '//connect.facebook.net/en_US/all.js';
                document.getElementById('fb-root').appendChild(e);
            }());
        </script>
        <?php
        $nodes = $params["nodes"];
        $des = $params["des"];
        $usuarios = $params["usuarios"];
        ?>
        <div class="wrappersup" id="esapp" style="min-height:542px;">
            <div style="float:right">
                <a style="padding: 5px;" target="_parent" href="http://www.facebook.com/Fan.Page.Latino?sk=app_219161961492807"><img src="http://www.fbconexion.com/images/flag_peru.png"></a>
                <a style="padding: 5px;" target="_parent" href="http://www.facebook.com/online.conexion?sk=app_243019195764316"><img src="http://www.fbconexion.com/images/usa_flag.png"></a>
            </div>
            <div id="faqtabs">
                <div class="faqlbltab"><?= __("titfeaturedquestions") ?></div>
                <div class="faqlbltab"><?= __("titquestions") ?></div>
                <div class="faqlbltab"><?= __("titask") ?></div>
            </div>
            <div id="faqdettabs">
                <!--featured questions-->
                <div class="faqdettab">
                    <?php
                    if (count($des) > 0) {
                        foreach ($des as $nd) {
                            ?>
                            <div class="itempregunta">
                                <?php
                                if($params["esadmin"]){
                                    echo '<div class="faqdel" alt="'.$nd->id.'">x</div>';
                                }
                                ?>
                                <a class="faqavatar" target="_blank" href="<?= $usuarios["x" . $nd->idusuario]["profile_url"] ?>">
                                    <img src="https://graph.facebook.com/1418715186/picture"/>
                                </a>
                                <div class="picopregunta"></div>
                                <div class="faqsetpregunta">
                                    <div class="faqcuadropregunta"><?= $nd->pregunta ?></div>
                                    <div class="faqgoanswers">
                                        <span><?=$lib->fechainexacta($nd->fecha)?></span>
                                        <a href="<?= $this->getURL(LANG . "support/faqs/" . $nd->id . "?secret=" . $_REQUEST["signed_request"]) ?>"><?= __("txtviewanswers") ?></a>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <!--questions-->
                <div class="faqdettab">
                    <?php
                    if (count($nodes) > 0) {
                        foreach ($nodes as $nd) {
                            ?>
                            <div class="itempregunta">
                                <?php
                                if($params["esadmin"]){
                                    echo '<div class="faqdel" alt="'.$nd->id.'">x</div>';
                                }
                                ?>
                                <a class="faqavatar" target="_blank" href="<?= $usuarios["x" . $nd->idusuario]["profile_url"] ?>">
                                    <img src="<?= $usuarios["x" . $nd->idusuario]["pic_square"] ?>"/>
                                </a>
                                <div class="picopregunta"></div>
                                <div class="faqsetpregunta">
                                    <div class="faqcuadropregunta"><?= $nd->pregunta ?></div>
                                    <div class="faqgoanswers">
                                        <span><?=$lib->fechainexacta($nd->fecha)?></span>
                                        <a href="<?= $this->getURL(LANG . "support/faqs/" . $nd->id . "?secret=" . $_REQUEST["signed_request"]) ?>"><?= __("txtviewanswers") ?></a>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <!--ask-->
                <div class="faqdettab">
                    <form action="" method="post" id="frmfaqpregunta">
                        <a class="faqavatar" target="_blank" href="<?= $_SESSION["fbconexion"]["link"] ?>">
                            <img src="<?= ($_SESSION["fbconexion"]["photo"] ? $_SESSION["fbconexion"]["photo"] : $this->getURL("images/img_avatar-faq.png")) ?>"/>
                        </a>
                        <div class="picopregunta"></div>
                        <div class="faqsetpregunta">
                            <label><?= __("txtyourquestions") ?></label>
                            <input type="text" id="faqsettitle" name="faqsettitle" />
                            <label><?= __("txtdescription") ?></label>
                            <textarea id="faqsetdescripcion" name="faqsetdescripcion"></textarea>
                        </div>
                        <input type="submit" id="faqsetsubmit" value="<?= __("btnpublish") ?>" />
                    </form>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            <?php
            if($params["esadmin"]){
                ?>
                    $(".faqdel").click(function(){
                        esto=this;
                        $.ajax({
                            url:"<?=$this->getURL(LANG."support/faqs/")?>",
                            type:"POST",
                            data:"accion=delfaq1&signed=<?=urlencode($_REQUEST["signed_request"])?>&id="+$(this).attr("alt"),
                            success:function(data){
                                alert(data);
                                $(esto).parent().fadeOut(450, function(){});
                            }
                        })
                    })
                <?php
            }
            ?>
            $(".faqlbltab").Dtabs(".faqdettab");
            logged=<?= $_SESSION["fbconexion"] ? 'true' : 'false' ?>;
            enviarinfo=function(){
                $.ajax({
                    url:"<?= $this->getURL(LANG."support/faqs") ?>",
                    data:"faqsettitle="+encodeURIComponent($("#faqsettitle").val())+"&faqsetdescription="+encodeURIComponent($("#faqsetdescription").val()),
                    type:"POST",
                    success:function(data){
                        top.location.href="<?= $params["pageurl"] ?>";
                    }
                });
            }
            $("#frmfaqpregunta").submit(function(){
                if($("#faqsettitle").val()==""){
                    $( "#faqsettitle" ).effect( "highlight", {}, 500, function(){});
                }else{
                    if(logged==false){
                        $.ajax({
                            url:"<?= $this->getURL("checkSession/0") ?>",
                            success:function(data){
                                if(data.indexOf("false")==-1){
                                    logged=true;
                                    enviarinfo();
                                }else{
                                    logged=false;
                                    FB.login(function(response){
                                        if (response.status === 'connected'){ 
                                            $.ajax({
                                                url:"<?= $this->getURL("doSession") ?>",
                                                success:function(data){
                                                    logged=true;
                                                    enviarinfo()
                                                }
                                            })
                                        }
                                    });
                                }
                            }
                        },{
                            "scope":"manage_pages,user_likes,offline_access,publish_stream,email"
                        })
                    }else{
                        FB.login(function(response){
                            if (response.authResponse) {
                                $.ajax({
                                    url:"<?=$this->getURL("doSession")?>",
                                    success:function(data){
                                        if(data.indexOf("ok")>-1){
                                            enviarinfo();
                                        }
                                    }
                                })
                            }
                        });
                    }
                }
                return false;
            })
        </script>
    </body>
</html>