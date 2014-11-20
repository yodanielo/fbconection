<div id="homcontainer">
    <div id="homeimg" style="background-image: url(<?= $this->getURL("images/banner-home-es.png") ?>);">
        <div onclick="return loguearse()" id="hometxt1">Loguéate con Facebook y Diseña tu página AHORA!</div>
        <div id="hometxt2">Diseña tu<br/>FB Fan Page <span style="color:#ff0000">GRATIS</span></div>
        <span id="hometxt3">&nbsp;<br/>Visítanos en <a href="http://www.facebook.com/pages/FB-Conexion-Latinoamerica/285369954810369" target="_blank"><img src="<?= $this->getURL("images/free-facebook-fan-page-creator.png") ?>" alt="Facebook"/></a>&nbsp;<a target="blank" href="http://www.twitter.com/FbConexionLA"><img src="<?=$this->getURL("images/1327961836_twitter.png")?>"/></a></span>
    </div>
    <div id="hometxt4">
        <p>
	Bienvenido a <strong>FB Conexion</strong>, la plataforma virtual que te ayudara a dise&ntilde;ar paginas de Fans en Facebook en poco tiempo.</p>
        
        <p> Para utilizar nuestra plataforma no tienes que tener conocimientos previos de dise&ntilde;o o programaci&oacute;n, todo lo que necesitas es entusiasmo y ganas para comenzar a sorprender a tus Fans con tus propios dise&ntilde;os creativos o utilizando cualquiera de las plantillas que te facilitamos para que las adaptes a tus necesidades.</p><p>Interact&uacute;a con tu audiencia, esc&uacute;chalos y conversa con ellos utilizando un Facebook Fan Page atractivo que invite a la comunicaci&oacute;n y la constante interacci&oacute;n.</p>
<p>
	Nuestro objetivo es ayudarte a incrementar tu presencia social con tus fans en Facebook brind&aacute;ndote una plataforma amigable y moderna que te permita hacer tus propios dise&ntilde;os en tu pagina de Fans en Facebook y que te ayude a aprovechar a integrarte con las diferentes redes sociales (Crea tu pagina de fans e int&eacute;grala con Cupones, Paypal, Youtube, Flickr, entre otros)</p>
<p>
	Atrae y genera Fans leales, posiciona tu marca! Disfruta de FB Conexi&oacute;n Gratis!</p>
<p>
	Gracias por visitarnos</p>

    </div>
    <div id="homevideocontainer" class="leanback-player-video">
        <img id="coveryth" src="<?= $this->getURL("images/pantallazoinicio-tutorial.png") ?>" width="380" height="253" alt="Welcome" />
    </div>
    <script type="text/javascript">
        $("#coveryth").click(function(){
            $(this).hide();
            $("#homevideocontainer").html('<object width="380" height="253"><param name="movie" value="http://www.youtube.com/v/pMXw1iLHAoI?version=3&hl=es_ES&autoplay=1"></param><param name="allowFullScreen" value="true"></param><param name="wmode" value="transparent"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/pMXw1iLHAoI?version=3&hl=es_ES&autoplay=1" type="application/x-shockwave-flash" width="380" height="253" allowscriptaccess="always" wmode="transparent" allowfullscreen="true"></embed></object>');
        })
        animar=function(){
            $("#hometxt1").animate({"opacity":0},2000, "linear", function(){
                $("#hometxt1").animate({"opacity":1}, 2000, "linear", function(){
                    setTimeout(animar,5000);
                });
            })
        }
        animar()
    </script>
</div>