<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo ($params["pagetitle"] ? trim($params["pagetitle"]) . " | " : "") . 'FB Conexion'; ?></title>
        <meta name="Description" content="<?php echo ($params["sitedescription1"]); ?>" />
        <meta name="author" content="Daniel Pomalaza" />
        <meta name="owner" content="Online Conexion" />
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
        <script type="text/javascript">lang="<?= LANG ?>"</script>
        <script type="text/javascript" src="<?= $params["livesite"] ?>/js/jquery-1.4.4.min.js"></script>
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
        <div id="wrapper" style="margin-top:30px; width: 800px; padding-bottom:40px; min-height:0px!important;">
            <div id="lplogo">
                <a href="<?= $this->getURL(LANG . "") ?>"><img src="<?= $this->getURL("images/facebook-landing-pages-templates.png") ?>" alt="Facebook Landing Pages Templates"/></a>
            </div>