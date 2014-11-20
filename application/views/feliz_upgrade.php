<div id="fumensaje" style="clear:both;">
    <h1><?=__("titcongratulations")?></h1>
    <p><?=__("txtactivacion")?></p>
</div>
<div id="fulogomuneco" style="float:left;">
    <img src="<?=$this->getURL("images/personaje-celebracion.png")?>"/>
</div>
<script type="text/javascript">
    function redirec(){
        //FB.logout(function(response){});
        window.location.href="<?=$this->getURL("/?logout=1")?>";
    }
    setTimeout(redirec, 7000);
</script>