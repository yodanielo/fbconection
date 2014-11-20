<?php
$esapp = $params["esapp"];
?>
<?php
$mt=$this->destripar();
if (LANG == "es/") {
    if ($mt[1] == "fbconexion" && $mt[2] == "page") {
        ?>
        <div id="propagandabottom2">
            <script type="text/javascript"><!--
                google_ad_client = "ca-pub-6445767890570319";
                /* S 468 60 top */
                google_ad_slot = "8841983176";
                google_ad_width = 468;
                google_ad_height = 60;
                //-->
            </script>
            <script type="text/javascript"
                    src="http://pagead2.googlesyndication.com/pagead/show_ads.js ">
            </script>
        </div>
        <?php
    } else {
        ?>
        <div id="propagandabottom">

            <script type="text/javascript"><!--
                google_ad_client = "ca-pub-6445767890570319";
                /* S 728 90 bottom */
                google_ad_slot = "3612778143";
                google_ad_width = 728;
                google_ad_height = 90;
                //-->
            </script>
            <script type="text/javascript"
                    src="http://pagead2.googlesyndication.com/pagead/show_ads.js ">
            </script>
        </div>
        <?php
    }
} else {
    if ($mt[1] == "fbconexion" && $mt[2] == "page") {
        ?>
        <div id="propagandabottom2">
            <script type="text/javascript"><!--
                google_ad_client = "ca-pub-6445767890570319";
                /* 468 60 top */
                google_ad_slot = "9193001480";
                google_ad_width = 468;
                google_ad_height = 60;
                //-->
            </script>
            <script type="text/javascript"
                    src="http://pagead2.googlesyndication.com/pagead/show_ads.js ">
            </script>
        </div>
        <?php
    } else {
        ?>
        <div id="propagandabottom">

            <script type="text/javascript"><!--
                google_ad_client = "ca-pub-6445767890570319";
                /* 728 90 bottom */
                google_ad_slot = "2683177528";
                google_ad_width = 728;
                google_ad_height = 90;
                //-->
            </script>
            <script type="text/javascript"
                    src="http://pagead2.googlesyndication.com/pagead/show_ads.js ">
            </script>
        </div>
        <?php
    }
}
?>
</div>
<div id="footer" class="<?= $_SESSION["lang"] ?>" style="<?= $esapp ? "width:690px;" : "" ?>">
    <a<?= ($esapp ? ' target="_parent"' : '') ?> href="<?= $this->getURL(LANG . "about_us") ?>"><?= __("titabout") ?></a>
    <a<?= ($esapp ? ' target="_parent"' : '') ?> href="<?= $this->getURL(LANG . "plans") ?>"><?= __("titplans") ?></a>
    <a<?= ($esapp ? ' target="_parent"' : '') ?> href="<?= $this->getURL(LANG . "support/examples") ?>"><?= __("titexamples") ?></a>
    <?php if ($esapp) { ?>
        <a target="_parent" id="logofooter" href="<?= $this->getURL(LANG . "") ?>"><img src="<?= $this->getURL("images/facebook-landing-pages-templates.png") ?>" alt="Facebook Landing Pages Templates" style="width:95px;"/></a>
    <?php } ?>
    <a<?= ($esapp ? ' target="_parent"' : '') ?> href="<?= $this->getURL(LANG . "support") ?>"><?= __("titsupport") ?></a>
    <a<?= ($esapp ? ' target="_parent"' : '') ?> href="http://www.fbconexion.com/blog/<?= LANG ?>">Blog</a>
    <?php if (!$esapp) { ?>
        <a id="logofooter" href="<?= $this->getURL(LANG . "") ?>"><img src="<?= $this->getURL("images/facebook-landing-pages-templates.png") ?>" alt="Facebook Landing Pages Templates" style="width:95px;"/></a>
        <a href="<?= $this->getURL(LANG . "terms_of_service") ?>">ToS</a>
        <a href="<?= $this->getURL(LANG . "privacy_policy") ?>"><?= __("titprivacypolicy") ?></a>
        <a href="<?= $this->getURL(LANG . "partnerships") ?>"><?= __("titpartnerships") ?></a>
        <a href="<?= $this->getURL(LANG . "webmap") ?>"><?= __("titwebmap") ?></a>
    <?php } ?>
    <a<?= ($esapp ? ' target="_parent"' : '') ?> href="<?= $this->getURL(LANG . __("linkcontactus")) ?>"><?= __("titcontactus") ?></a>
</div>
<div id="footer2" style="<?= $esapp ? "width:690px;" : "" ?>text-align:center;">
    ©2011 FB Conexion – <a href="<?= $this->getURL(LANG . "") ?>">Facebook Landing Pages Templates</a>&nbsp;|(Facilitating Being in Conexion) Developed by Online Conexion.<br/>
    FB Conexion or Online Conexion are not affiliated with Facebook.
    <?php
    if (LANG != "es/") {
        echo "<br/><strong>FB Conexion</strong><br/>1584 Oak Ave. Apt. 2, Evanston, IL | Phone: (773) 441-3116";
    }
    ?>
</div> 
<div id="topwrapper" style="<?= $esapp ? "width:795px;" : "" ?>;">
    <div id="msgpromo">
        <?= $this->params["msgpromo"] ?>
    </div>
    <div style="display:none;">
        <div id="boxpromo">
            <?= $this->params["msgpromo"] ?>
            <div id="formpromo">
                <form method="#" action="#" id="frmpromo">
                    <label><?= __("txtnombre") ?>:</label>
                    <input type="text" id="txtpromonombre" style="margin-bottom: 5px;" />
                    <label><?= __("txtemail") ?>:</label>
                    <input type="text" id="txtpromoemail" />
                </form>
                <script type="text/javascript">
                    $("#frmpromo").submit(function(){
                        m=$("#txtpromoemail").val();
                        n=$("#txtpromoenombre").val();
                        r=true;
                        if(m.split("@").length!=2)
                            r=false;
                        else
                            if(m.split("@")[1].indexOf(".")==-1)
                                r=false;
                        if(n=="")
                            r=false;
                        if(r==true){
                            $.ajax({
                                url:"http://www.fbconexion.com/blog/<?= LANG ?>",
                                type:"post",
                                data:"na=s&nr=widget&ne="+encodeURIComponent(m)+"&nn="+encodeURIComponent(n)
                            })
                            $.ajax({
                                url:"<?= $this->getURL("fbconexion/setmail") ?>",
                                type:"post",
                                data:"mail="+encodeURIComponent(m)
                            })
                            $("#txtpromoemail").val("");
                            $("#txtpromoenombre").val("");
                            $("#boxpromo").dialog("close");
                        }else{
                            alert("algo falló");
                        }
                        return false;
                    });
                </script>
            </div>
        </div>
    </div>
    <div id="flagswrapper">
        <a id="btnperu" rel="nofollow" href="<?= $this->getURL("/es" . $_SERVER['ORIG_PATH_INFO']) ?>"><?php
            switch ($params["otroindex"]) {
                case "mexico":
                    echo '<img style="width:24px;" src="' . $this->getURL("images/flag_mexico.png") . '"/>';
                    break;
                default:
                    echo '<img src="' . $this->getURL("images/flag_peru.png") . '"/>';
            }
            ?></a>
        <a id="btnusa" rel="nofollow" href="<?= $this->getURL($_SERVER['ORIG_PATH_INFO']) ?>"><img src="<?= $this->getURL("images/usa_flag.png") ?>"/></a>
        <span>|</span>
        <a target="_blank" href="https://www.facebook.com/pages/FB-Conexion/205351732836413"><img src="<?= $this->getURL("images/facebook_flag.png") ?>"/></a>
    </div>
    <div style="float: left; white-space: nowrap; margin-top:10px;">
        <div class="addthis_toolbox addthis_default_style ">
            <a class="addthis_button_google_plusone" g:plusone:annotation="none" g:plusone:size="medium"></a>
            <a class="addthis_button_facebook_like" fb:like:layout="button_count" fb:like:width="100"></a>
        </div>
        <script type="text/javascript">
            var addthis_share = {
                title:"<?= $params["sitename"] ?>",
                url:"<?= $this->getURL("") ?>",
                "ui_language" :"<?= $_SESSION["lang"] ?>"
            };
            var addthis_config = {
                "data_track_clickback":true,
                "ui_language" :"<?= $_SESSION["lang"] ?>"
            };
        </script>
        <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4ee3898d34d8c215"></script>
    </div>
</div>
<script type="text/javascript">
    togglepromo=function(){
        $("#msgpromo").click(function(){
<?php
if ($params["fans"] == 0)
    echo 'window.location.href="' . $this->getURL(LANG . "plans") . '";';
else {
    ?>
                    if($(this).html().indexOf("newsletter")>=0){
                        $("#boxpromo").dialog({
                            "modal":true,
                            "title":"FB Conexion",
                            "width":400,
                            "buttons":{
                                "ok":function(){
                                    $("#frmpromo").submit();
                                },
                                "cancel":function(){
                                    $("#txtpromoemail").html("");
                                    $("#boxpromo").dialog("close");
                                }
                            }
                        })
                    }
    <?php
}
?>
        })
    }
    $(document).ready(function(){
        $(document).resize(function(){
            fleXenv.updateScrollBars();
        });
        togglepromo()
    })
</script>
</body>
</html>