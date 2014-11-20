<?php
$esapp = $params["esapp"];
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
<div style="display:none">
    <audio id="controlesaudio" src="" loop="true" controls="controls" preload="auto" autobuffer></audio>
</div>
<script type="text/javascript">
    isplayed=false;
    baseaudio="http://www.fbconexion.com/audios/christmans-<?= $_SESSION["lang"] ?>.";
    obj2=document.getElementById("controlesaudio");
    if($.browser.mozilla)
        $(obj2).attr("src", baseaudio+"ogg");
    else{
        if($.browser.webkit)
            $(obj2).attr("src", baseaudio+"mp3");
        else{
            if($.browser.opera)
                $(obj2).attr("src", baseaudio+"ogg");
            else{
                if($.browser.msie)
                    $(obj2).attr("src", baseaudio+"mp3");
            }
        }
    }
    inicioaudio="<?= $_SESSION["audio"] ?>";
    toggleplay=function(){
        if(obj2.canPlayType){
            if(isplayed==false){
                $("#icovolume").addClass("icoplayed");
                $.ajax({
                    url:"<?= $this->getURL("toggleAudio/1") ?>"
                })
                obj2.play();
            }
            else{
                $.ajax({
                    url:"<?= $this->getURL("toggleAudio/0") ?>"
                })
                $("#icovolume").removeClass("icoplayed");
                obj2.pause();
            }
            isplayed=!isplayed;
        }
    }
    if(inicioaudio!="0")
        isplayed=false;
    else
        isplayed=true;
</script>
<div id="topwrapper" style="<?= $esapp ? "width:795px;" : "" ?>;">
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
                "ui_language" :"<?=$_SESSION["lang"]?>"
            };
            var addthis_config = {
                "data_track_clickback":true,
                "ui_language" :"<?=$_SESSION["lang"]?>"
            };
        </script>
        <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4ee3898d34d8c215"></script>
    </div>
    <div id="icovolume" class="icoplayed" onclick="return toggleplay(this)"></div>
</div>
<script type="text/javascript">
    togglemerry=function(){
        $("#txtmerry").animate({opacity:0}, 1000, "linear", function(){
            $("#txtmerry").animate({opacity:1}, 1000, "linear", function(){
                setTimeout(togglemerry, 3000);
            });
        });
    }
    $(document).ready(function(){
        $(document).resize(function(){
            fleXenv.updateScrollBars();
        });
        toggleplay();
        setTimeout(togglemerry, 3000);
    })
</script>
</body>
</html>