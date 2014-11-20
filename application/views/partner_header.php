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
        <link rel="stylesheet" type="text/css" href="<?= $this->getURL("/css/partners.css") ?>" />
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
    </head>
    <body id="bodyintranet">
        <div id="fb-root"></div>
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
            };
    (function() {
        var e = document.createElement('script'); 
        e.async = true;
        e.src = document.location.protocol +
            '//connect.facebook.net/en_US/all.js';
        document.getElementById('fb-root').appendChild(e);
    }());
        </script>
        <div id="wrapper">
            <div id="header">
                <a href="<?= $this->getURL("") ?>" id="logoprincipal" title="FBConexion"><img src="<?= $this->getURL("images/facebook-landing-pages-templates.png") ?>" alt="Facebook Landing Pages Templates"/></a>
                <div id="datossession">
                    <span><?= __("txtwelcome") . " <strong>" . $_SESSION["partners"]["nombre"] . "</strong>" ?></span><br/>
                    <a href="<?= $this->getURL(LANG . "partners/change_password") ?>"><?= __("txtchangepass") ?></a><br/>
                    <a href="<?= $this->getURL(LANG . "partners?logout=1") ?>"><?= __("txtlogout") ?></a><br/>
                </div>
            </div>
            <div id="botonera">
                <a href="<?= $this->getURL(LANG . "partners/report1") ?>"><?= __("txtpartrep1") ?></a>
                <a href="<?= $this->getURL(LANG . "partners/report2") ?>"><?= __("txtpartrep3") ?></a>
                <?php
                if($_SESSION["partners"]["esjefe"])
                    echo '<a href="' . $this->getURL(LANG . "partners/transferTab") . '">' . __("txtpartrep2") . '</a>';
                ?>
            </div>