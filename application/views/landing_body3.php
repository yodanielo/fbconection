<div id="lptxt14" style="font-size: 18px;">
    <?=__("lptxt13")?>
    <div style="font-size:21px;"><?=__("lptxt13-1")?></div>
    <div id="lptxt15" style="font-size: 31px;"><?=__("lptxt13-2")?></div>
</div>
<div id="lpimg16">
    <div id="lptxt18"><?=__("lptxt14")?></div>
    <a href="#" class="btnloginfb" id="lptxt17"><?=__("lptxt6")?><br/><span><?=__("lptxt11")?></span></a>
    <div id="lptxt19"><?=str_replace(array("{link1}","{link2}"),array('<a style="color:#E7A227;" href="'.$this->getURL(LANG."").'">',"</a>"),__("lptxt15"))?></div>
</div>
<div id="lptxt4"><?=__("lptxt4")?><a target="_blank" href="<?=$_SESSION["lang"]=="es"?"http://www.facebook.com/pages/FB-Conexion-Latinoamerica/285369954810369":"http://www.facebook.com/online.conexion"?>"><img src="<?=$this->getURL("images/free-facebook-fan-page-creator.png")?>" id="lpicofb"/></a></div>
<div id="lptxtblog">
    <a href="http://www.fbconexion.com/blog/"><?=__("lptxtblog")?></a>
</div>
<script type="text/javascript">
    $("#lptxt17").css({"display":"block","opacity":0,"top":237}).animate({"top":267,"opacity":1}, 1000, "linear",function(){});
</script>