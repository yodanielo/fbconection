<div id="fumensaje" style="clear:both;">
    <h1><?=__("titsad")?></h1>
    <p><?=__("txtunsuscribe")?></p>
</div>
<div id="fulogomuneco" style="float:left;">
    <img src="<?=$this->getURL("images/personaje_triste.png")?>"/>
</div>
<script type="text/javascript">
    function redirec(){
        //FB.logout(function(response){});
        window.location.href="<?=$this->getURL("")?>";
    }
    setTimeout(redirec, 7000);
</script>