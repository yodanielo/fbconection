<?php ?>
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
            <div style="position: absolute;right: 17px;top: 10px;">
                    <a style="padding: 5px;" target="_parent" href="http://www.facebook.com/Fan.Page.Latino?sk=app_194757327280771"><img src="http://www.fbconexion.com/images/flag_peru.png"></a>
                    <a style="padding: 5px;" target="_parent" href="http://www.facebook.com/online.conexion?sk=app_194757327280771"><img src="http://www.fbconexion.com/images/usa_flag.png"></a>
                </div>
            <div id="blogbanner">
                <a href="<?=$params["datos"]["link"]?>"><img src="<?=$this->getURL("images/fbconexion_logo.png")?>"/></a>
            </div>
            <div id="blogseparador"></div>
            <div id="blogcontenido">
                <?php
                $d = $params["datos"]["items"];
                if (count($d) > 0) {
                    foreach ($d as $r) {
                        ?>
                        <div class="comglobo1 ">
                            <img src="http://www.fbconexion.com/images/comments-quote.png" class="comquote"/>
                            <div class="comglobo2">
                                <div class="comglobo3">
                                    <a class="bititle" href="<?=$r["link"]?>"><?=$r["title"]?></a>
                                    <div class="bidescription"><?=$r["description"]?></div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
        <script type="text/javascript">
            $("a").attr("target", "_blank");
        </script>
    </body>
</html>
