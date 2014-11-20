<div id="lptxt9" style="line-height: 100%;">
    <?=__("lptxt9")?>
    <div style="font-size: 14px; font-family:CenturyGothicRegular,Arial,Helvetica,sans-serif;"><?=__("lptxt9-1")?></div>
    <div id="lptxt10" style="padding-left: 160px;"><?=__("lptxt10")?></div>
</div>
<div id="lpimg11">
    <a href="#" class="btnloginfb" id="lptxt12" style="display:none"><?=__("lptxt6")?><br/><span><?=__("lptxt11")?></span></a>
    <a href="<?=$this->getURL(LANG."")?>" id="lptxt13"><?=str_replace(array("{link1}","{link2}"),array('<span>',"</span>"),__("lptxt12"))?></a>
</div>
<div id="lptxt4"><?=__("lptxt4")?><a target="_blank" href="<?=$_SESSION["lang"]=="es"?"http://www.facebook.com/pages/FB-Conexion-Latinoamerica/285369954810369":"http://www.facebook.com/online.conexion"?>"><img src="<?=$this->getURL("images/free-facebook-fan-page-creator.png")?>" id="lpicofb"/></a></div>
<div id="lptxtblog">
    <a href="http://www.fbconexion.com/blog/"><?=__("lptxtblog")?></a>
</div>
<script type="text/javascript">
    $("#lptxt12").css({"display":"block","opacity":0}).animate({"top":75,"opacity":1}, 1000, "linear",function(){
        animar=function(){
            $("#lptxt12").animate({"opacity":0},2000, "linear", function(){
                $("#lptxt12").animate({"opacity":1}, 2000, "linear", function(){
                    setTimeout(animar,5000);
                });
            })
        }
        animar()
    });
</script>