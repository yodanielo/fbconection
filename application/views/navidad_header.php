<?php
$esapp = $params["esapp"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo ($params["pagetitle"] ? trim($params["pagetitle"]) . " | " : "") . $params["sitename"]; ?></title>
        <meta name="Description" content="<?php echo trim($params["sitedescription1"]); ?>" />
        <meta name="author" content="<?php echo $params["author"]; ?>" />
        <meta name="owner" content="<?php echo $params["owner"]; ?>" />
        <META name="y_key" content="516512e33c4ecea4" />
        <meta name="msvalidate.01" content="E89F7A6C3EA91EA2F8E9CC809342B7AE" />

        <link rel="alternate" type="application/rss+xml" title="FB Conexion Blog &raquo; Feed" href="http://www.fbconexion.com/blog/<?= LANG ?>feed/" />
        <?php
        if ($params["follow"] && !$params["otroindex"])
            echo '<meta name="robots" content="index, follow" />';
        else
            echo '<meta name="robots" content="noindex, nofollow"/>';
        ?>
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
        <link rel="stylesheet" type="text/css" href="<?= $this->getURL("/css/nav.css") ?>" />
        <!--[if IE ]>
        <link rel="stylesheet" type="text/css" href="<?= $this->getURL("/css/ie.css") ?>" />
        <![endif]-->
        <!--[if lte IE 7]>
        <link rel="stylesheet" type="text/css" href="<?= $this->getURL("/css/ie7.css") ?>" />
        <![endif]-->
        <script type="text/javascript">lang="<?= LANG ?>"</script>
        <?php
        if (count($params["scripts"]) > 0) {
            foreach ($params["scripts"] as $key => $sc) {
                if (substr($sc, 0, 7) == "http://" || substr($sc, 0, 8) == "https://")
                    echo '<script type="text/javascript" src="' . $sc . '"></script>' . "\n";
                else
                    echo '<script type="text/javascript" src="' . $this->getURL('/js/' . $sc) . '"></script>' . "\n";
            }
        }
        if($params["hayzopim"]){
        ?>
        <!-- Start of Zopim Live Chat Script -->
        <script type="text/javascript">
            window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=
                    z.s=d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o
            ){z.set._.push(o)};$.setAttribute('charset','utf-8');$.async=!0;z.set.
                    _=[];$.src=('https:'==d.location.protocol?'https://ssl':'http://cdn')+
                    '.zopim.com/?P1xE465TeDVfR3YRiLSRwx0vXo7pdlj3';$.type='text/java'+s;z.
                    t=+new  Date;z._=[];e.parentNode.insertBefore($,e)})(document,'script');
        </script>
        <!-- End of Zopim Live Chat Script -->
        <?php
        }
        ?>
        <script type="text/javascript" src="<?= $params["livesite"] ?>/js/generales.js"></script>
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
        <script type="text/javascript">
            /*if($.browser.msie && parseInt($.browser.version)<9)
                window.location.href="<?= $this->getURL(LANG . "incompatible") ?>";*/
        </script>
    </head>
    <body>
        <div id="fb-root"></div>
        <div id="linkdesign" style="display:block; background:url(<?= $this->getURL("images/bannerdesign_" . $_SESSION["lang"] . ".jpg") ?>) no-repeat;">

        </div>
        <div id="espacioshare">
            <div class="addthis_toolbox addthis_default_style addthis_32x32_style">
                <a class="addthis_button_facebook"></a>
                <a class="addthis_button_twitter"></a>
                <a class="addthis_button_linkedin"></a>
            </div>
            <script type="text/javascript">
                var addthis_share = {
                    title:"<?=$params["sitename"]?>",
                    url:"<?=$this->getURL("")?>"
                };
                var addthis_config = {
                    "data_track_clickback":true,
                    ui_language :"<?=$_SESSION["lang"]?>"
                };
            </script>
            <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4ee3898d34d8c215"></script>
        </div>
        <div style="display: none">
            <div id="bd2cont">
                <div class="boxdiseno2">
                    <label class="bd2label"><?= __("txtnombrecompleto") ?></label>
                    <input type="text" class="bd2input bd2_1 required" value=""/>
                    <label class="bd2label"><?= __("txtemail") ?></label>
                    <input type="text" class="bd2input bd2_3 required" value=""/>
                    <label class="bd2label"><?= __("txtfanpageurl") ?></label>
                    <input type="text" class="bd2input bd2_2" value=""/>
                    <label class="bd2label"><?= __("Country") ?></label>
                    <input type="text" class="bd2input bd2_4 required" value=""/>
                    <label class="bd2label"><?= __("txttel") ?></label>
                    <input type="text" class="bd2input bd2_5" value=""/>
                    <label class="bd2label"><?= __("txtcomment") ?></label>
                    <textarea class="bd2input bd2_6"></textarea>
                </div>
            </div>
        </div>
        <div id="wrapper" style="margin-top:55px; <?= ($esapp ? "width:670px;" : "") ?>">
            <div id="header" style="<?= ($esapp ? "width:360px;" : "") ?>">
                <div id="txtmerry"><?= __("Merry Christmas") ?></div>
                <a id="logo" href="<?= $this->getURL("") ?>">
                    <img src="<?= $this->getURL("/images/navidad.png") ?>" id="iconavidad">
                        <?php
                        if (!$params["logofile"])
                            echo '<img src="' . $this->getURL("images/facebook-landing-pages-templates.png") . '" alt="Facebook Landing Pages Templates"/>';
                        else
                            echo '<img src="' . $this->getURL("images/" . $params["logofile"]) . '" alt="' . $params["logoalt"] . '"/>';
                        ?>
                </a>
                <div id="menuprincipal">
                    <a<?= $esapp ? ' target="_parent"' : '' ?> href="<?= $this->getURL(LANG . "") ?>"><?= __("tithome") ?></a>
                    <a<?= $esapp ? ' target="_parent"' : '' ?> href="<?= $this->getURL(LANG . "plans") ?>"><?= __("titplans") ?></a>
                    <a<?= $esapp ? ' target="_parent"' : '' ?> href="<?= $this->getURL(LANG . "support/examples") ?>"><?= __("titexamples") ?></a>
                    <?php
                    $c = $this->destripar();
                    echo '<a' . ($esapp ? ' target="_parent"' : '') . ' href="' . $this->getURL("blog/" . LANG) . '">Blog</a>';
                    if (!$_SESSION["fbconexion"]) {
                        //echo '<a id="btnloginfb" href="#">' . __("titlogin") . '</a>';
                    } else {
                        //if ($c[2] != "coupon") {
                            echo '<a' . ($esapp ? ' target="_parent"' : '') . ' href="' . $this->getURL(LANG . "fbconexion") . '">' . __("titmypages") . '</a>';
                        //}
                    }
                    ?>
                </div>
            </div>
            <?php
            $cfg = $this->loadConfig("fb");
            if ($_SESSION["fbconexion"]) {
                ?>
                <div id="loggeduser">
                    <img src="<?= $_SESSION["fbconexion"]["photo"] ?>"/>
                    <a id="fbusername" target="_blank" href="<?= $_SESSION["fbconexion"]["link"] ?>"><?= $_SESSION["fbconexion"]["name"] ?></a><br/>
                    <?php
                    if (!$esapp)
                        echo '<a id="fblogout" href="' . $this->getURL(LANG . "?logout=1") . '">Logout</a>';
                    ?>
                </div>
                <?php
            } else {
                ?>
                <div id="loggeduser">
                    <a id="btnloginfb" href="#"><span><?= __("btnlogin") ?></span></a><br/>
                </div>
                <?php
            }
            ?>
            <script type="text/javascript">
                window.fbAsyncInit = function() {
                    FB.init({
                        appId: '<?= $cfg["id"] ?>',
                        status: true, 
                        cookie: true,
                        xfbml: true,
                        //channelUrl  : 'http://www.fbconexion.com/channel.html',
                        oauth : true
                    });
                    function updateButton(response) {
                        loguearse=function(){
                            //if (response.status == 'connected')
                            //FB.logout(function(response){});
                            FB.login(function(response) {
                                if (response.status == 'connected') {
                                    $.ajax({
                                        url:"<?= $this->getURL("doSession") ?>",
                                        success:function(data){
                                            if(data.indexOf("ok")>-1){
                                                window.location.href="<?= $this->getURL(LANG . "fbconexion") ?>";
                                            }
                                        }
                                    })
                                }
                            },{
                                "scope":"manage_pages,user_likes,offline_access,publish_stream,email"
                            });
                            return false;
                        }
                        $("#btnloginfb").click(loguearse);
   
                    }

                    // run it once with the current status and also whenever the status changes
                    FB.getLoginStatus(updateButton);
                    //FB.Event.subscribe('auth.statusChange', updateButton);
                };
                (function() {
                    var e = document.createElement('script'); 
                    e.async = true;
                    e.src = document.location.protocol +
                        '//connect.facebook.net/en_US/all.js';
                    document.getElementById('fb-root').appendChild(e);
                }());
<?php /* para el dialogo para pedir diseño */ ?>
    contactodesign=function(){
        $("#bd2cont").dialog({
            title:"<?= __("titdisenodefanpage") ?>",
            modal:true,
            width:280,
            buttons:{
                "OK":function(){
                    cumple=true;
                    $("#bd2cont .required").each(function(){
                        if($(this).val()==""){
                            $(this).stop().effect("highlight", {}, 3000);
                            cumple=false;
                        }
                    })
                    if(cumple){
                        $.ajax({
                            url:"<?= $this->getURL(LANG . "fbconexion/boxdiseno/" . $params["idobj"]) ?>",
                            type:"POST",
                            data:"txt1="+encodeURIComponent($(".bd2_1").val())+"&txt2="+encodeURIComponent($(".bd2_2").val())+"&txt3="+encodeURIComponent($(".bd2_3").val())+"&txt4="+encodeURIComponent($(".bd2_4").val())+"&txt5="+encodeURIComponent($(".bd2_5").val())+"&txt6="+encodeURIComponent($(".bd2_6").val()),
                            success:function(data){
                                $("#dialogo .boxdiseno").remove();
                                $("#bd2cont").dialog("close");
                                $(".bd2input").val("");
                            }
                        })
                    }
                },
                "<?= __("btncancel") ?>":function(){
                    $(this).dialog("close");
                }
            }
        })
    }
    $("#linkdesign").click(function(){
        contactodesign();
    })
            </script>