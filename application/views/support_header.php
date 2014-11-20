<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo ($params["pagetitle"] ? $params["pagetitle"] . " | " : "") . $params["sitename"]; ?></title>
        <meta name="Description" content="<?php echo $params["sitedescription1"]; ?>" />
        <meta name="Keywords" content="<?php echo $params["keywords"]; ?>" />
        <meta name="author" content="<?php echo $params["author"]; ?>" />
        <meta name="owner" content="<?php echo $params["owner"]; ?>" />
        <?php
        if ($params["follow"])
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
        <!-- Start of Zopim Live Chat Script -->
        <script type="text/javascript">
            window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=
                    z.s=d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o
            ){z.set._.push(o)};$.setAttribute('charset','utf-8');$.async=!0;z.set.
                    _=[];$.src=('https:'==d.location.protocol?'https://ssl':'http://cdn')+
                    '.zopim.com/?P1xE465TeDVfR3YRiLSRwx0vXo7pdlj3';$.type='text/java'+s;z.
                    t=+new  Date;z._=[];e.parentNode.insertBefore($,e)})(document,'script')
        </script>
        <!-- End of Zopim Live Chat Script -->
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
    </head>
    <body style="background:none #fff">
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
            };
            (function() {
                var e = document.createElement('script'); 
                e.async = true;
                e.src = document.location.protocol +
                    '//connect.facebook.net/en_US/all.js';
                document.getElementById('fb-root').appendChild(e);
            }());
        </script>
        <div id="scroller1" class="flexcroll4">
            <div id="fb-root"></div>
            <div id="headersup">
                <div class="wrappersup">
                    <a id="logo1sup" href="<?= $this->getURL(LANG . "") ?>"><img src="<?= $this->getURL("images/facebook-landing-pages-templates.png") ?>" alt="Facebook Landing Pages Templates" style="height:60px; margin:10px 0px;"/></a>
                    <div id="logo2sup">
                        <div id="supflags">
                            <a id="btnperu" href="<?= $this->getURL("/es" . $_SERVER['ORIG_PATH_INFO']) ?>"><img src="<?= $this->getURL("images/flag_peru.png") ?>"/></a>
                            <a id="btnusa" href="<?= $this->getURL($_SERVER['ORIG_PATH_INFO']) ?>"><img src="<?= $this->getURL("images/usa_flag.png") ?>"/></a>
                        </div>
                        <a style="float:left; clear:both;" href="<?= $this->getURL(LANG . "support") ?>"><img src="<?= $this->getURL("images/logo2sup.png") ?>"/></a></div>
                    <div class="linkstopsup">
                        <a href="<?= $this->getURL(LANG . "") ?>"><?= __("tithome") ?></a>
                        <a href="<?= $this->getURL(LANG . "support/faqs") ?>">FAQs</a>
                        <a href="<?= $this->getURL(LANG . "support/examples") ?>"><?= __("titexamples") ?></a>
                        <a href="<?= $this->getURL(LANG . "support/tutorials") ?>"><?= __("tittutorials") ?></a>
                    </div>
                </div>
            </div>

