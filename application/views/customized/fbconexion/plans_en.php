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
        <div id="wrapper" id="bodyplans">
                        <div style="float:right">
                <a style="padding: 5px;" target="_parent" href="http://www.facebook.com/Fan.Page.Latino?sk=app_145042652271489"><img src="http://www.fbconexion.com/images/flag_peru.png"></a>
                <a style="padding: 5px;" target="_parent" href="http://www.facebook.com/online.conexion?sk=app_145042652271489"><img src="http://www.fbconexion.com/images/usa_flag.png"></a>
            </div>
            <div id="barrashare" style="left: 17px; top: 0px; z-index: 100;">
                    <div class="addthis_toolbox addthis_default_style ">
                        <a class="addthis_button_facebook"></a>
                        <a class="addthis_button_twitter"></a>
                        <a class="addthis_button_linkedin"></a>
                        <a class="addthis_button_google_plusone" g:plusone:annotation="none" g:plusone:size="small"></a>
                    </div>
                    <script type="text/javascript">
                        var addthis_share = {
                            title:"<?= $params["sitename"] ?>"
                        };
                        var addthis_config = {
                            "data_track_clickback":true
                        };
                    </script>
                    <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4ee3898d34d8c215"></script>
                </div>
                
            <div id="headerplans">
                <img src="<?= $this->getURL("images/personaje_disenando.png") ?>" id="logoplans" />
                <div id="hptitle">
                    Our<br/>Plans
                </div>
            </div>
            <div class="itemplans1">
                <div class="fppricebox" id="fpp1">
                    Free
                </div>
                <div class="fptitle">Personal Plan</div>
                <div class="fpcuerpo">
                    <span>1Mb</span><br/>
                    Drag and Drop Designer<br/>
                    Public Relationship Manager<br/>
                    Coupon Manager<br/>
                    FBConexion Logo<br/>
                    Full access to ALL the widgets<br/>
                    1 Facebook Fan Page<br/>
                    1 tab
                </div>
                <div class="fbimgplan"><img src="<?= $this->getURL("images/fpbg_plan1.png") ?>" /></div>
            </div>
            <div class="itemplans1">
                <div class="fppricebox" id="fpp2">
                    If you invite 30 friends to LIKE our FB page & subscribe to our newsletter.
                </div>
                <div class="fptitle">Professional Plan</div>
                <div class="fpcuerpo">
                    <span>25Mb</span><br/>
                    Drag and Drop Designer<br/>
                    Public Relationship Manager<br/>
                    Coupon Manager<br/>
                    FBConexion Logo<br/>
                    Full access to ALL the widgets<br/>
                    1 Facebook Fan Page<br/>
                    unlimited tabs
                </div>
                <div class="fbimgplan"><img src="<?= $this->getURL("images/fpbg_plan2.png") ?>" /></div>
                <div class="fbbuttom fbbuy" id="buy2">FREE</div>
            </div>
            <div class="itemplans2">
                <div class="fppricebox" id="fpp3">
                    If you invite 50 friends to LIKE our FB page & subscribe to our newsletter.
                </div>
                <div class="fptitle">Premium Plan</div>
                <div class="fpcuerpo">
                    <span>50Mb</span><br/>
                    Drag and Drop Designer<br/>
                    Public Relationship Manager<br/>
                    Coupon Manager<br/>
                    FBConexion Logo<br/>
                    Full access to ALL the widgets<br/>
                    1 Facebook Fan Page<br/>
                    unlimited tabs
                </div>
                <div class="fbimgplan"><img src="<?= $this->getURL("images/fpbg_plan3.png") ?>" /></div>
                <div class="fbbuttom fbbuy" id="buy3">FREE</div>
                <div id="fbmostpopular">
                    <img src="<?= $this->getURL("images/fpbg_plan3-1.png") ?>" />
                </div>
            </div>
            <div class="itemplans1">
                <div class="fppricebox" id="fpp4" style="line-height: 20px;">
                    $99.99<br>
                    <span>One time<br/>
                        payment</span>
                </div>
                <div class="fptitle" style="font-size: 25px;">Professional Facebook<br/>
                    Fan Page Design</div>
                <div class="fpcuerpo">
                    We design and customize your Innovative<br/>
                    Facebook Fan Page for you<br/>
                    <br/>
                    Call us: <br/>
                    (773) 441 – 3116
                </div>
                <div class="fbimgplan"><img src="<?= $this->getURL("images/fpbg_plan4.png") ?>" /></div>
                <div class="fbbuttom fbcontact">Contact Us</div>
            </div>
        </div>
        <script type="text/javascript">
            logged=false;
            function comprobar(){
                $.ajax({
                    url:"<?= $this->getURL("checkSession/0") ?>",
                    async:false,
                    success:function(data){
                        if(data.indexOf("false")==-1){
                            logged=true;
                        }
                        else{
                            logged=false;
                            loguear();
                        }
                    }
                })
                return logged;
            }
            function loguear(){
                FB.login(function(response){
                    if (response.status === 'connected'){ 
                        $.ajax({
                            async:false,
                            url:"<?= $this->getURL("doSession") ?>",
                            success:function(data){
                                logged=true;
                            }
                        })
                    }else{
                        logged=false;
                    }
                });
            }
            $(".fbbuy").click(function(){
                if(comprobar()){
                    top.location.href="<?= $this->getURL(LANG . "plans") ?>";
                }
            })
            $(".fbcontact").click(function(){
                if(comprobar()){
                    top.location.href="<?= $this->getURL(LANG . "customizedfanpage/") ?>";
                }
            })
            aparecer=function(){
                $("#fbmostpopular").animate({opacity:0}, 1000, "linear", function(){
                    $("#fbmostpopular").animate({opacity:1}, 1000, "linear", function(){
                        setTimeout(aparecer, 3000);
                    })
                })
            }
            aparecer();
        </script>
    </body>
</html>
