<div id="lptxt1" style="font-size: 21px;">
    <?=__("lptxt1")?>
    <div style="font-size: 23px;"><?=__("lptxt1-1")?></div>
    <div id="lptxt2" style="font-size: 20px;"><?=__("lptxt2")?></div>
</div>
<div id="lpimg3">
    <span id="lptxt5"><?=$_SESSION["lang"]=="es"?"Tú":"You"?></span>
    <span id="lptxt6"><?=__("lptxt6")?></span>
    <a id="lptxt7" class="btnloginfb" href="#"><?=__("lptxt7")?></a>
    <span id="lptxt8"><?=str_replace(array("{link1}","{link2}"),array('<a href="'.$this->getURL(LANG."").'">',"</a>"),__("lptxt8"))?></span>
</div>
<div id="lptxt4"><?=__("lptxt4")?><a target="_blank" href="<?=$_SESSION["lang"]=="es"?"http://www.facebook.com/pages/FB-Conexion-Latinoamerica/285369954810369":"http://www.facebook.com/online.conexion"?>"><img src="<?=$this->getURL("images/free-facebook-fan-page-creator.png")?>" id="lpicofb"/></a></div>
<div id="lptxtblog">
    <a href="http://www.fbconexion.com/blog/"><?=__("lptxtblog")?></a>
</div>