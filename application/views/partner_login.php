<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>FBConexion | Partnerships</title>
        <link rel="stylesheet" type="text/css" href="<?= $this->getURL("css/partners.css") ?>" />
        <meta name="robots" content="noindex, nofollow"/>
    </head>
    <body>
        <div id="logincont">
            <div id="loginlogo">
                <img src="<?= $this->getURL("images/facebook-landing-pages-templates.png") ?>" alt="Facebook Landing Pages Templates"/>
            </div>
            <div id="logincuadro">
                <form id="frmlogin" method="post" action="">
                    <div class="logfila">
                        <label><?= __("txtuser") ?></label>
                        <input type="text" name="txt1" class="txtlogin" value="" />
                    </div>
                    <div class="logfila">
                        <label><?= __("txtpass") ?></label>
                        <input type="password" name="txt2" class="txtlogin" value="" />
                    </div>
                    <div class="logfila">
                        <input type="submit" id="submitlogin" value="<?= __("txtenter") ?>" />
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
