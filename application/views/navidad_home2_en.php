<div id="homcontainer">
    <div id="homeimg" style="background-image: url(<?= $this->getURL("images/banner-home-en.png") ?>);">
        <div onclick="return loguearse()" id="hometxt1" style="font-size:17px;">Connect with Facebook and Start Now to Make your Fan Page!</div>
        <div id="hometxt2">Test our platform FREE</div>
        <a id="hometxt3" href="http://www.facebook.com/online.conexion" target="_blank">Visit us in <img src="<?= $this->getURL("images/free-facebook-fan-page-creator.png") ?>" alt="Free Facebook Fan Page Creator"/></a>
    </div>
    <div id="hometxt4">
        <p>
	Welcome to <strong>FBConexion.com</strong>, we exist to help you interact and engage more efficiently with your fans on Facebook. We have created a friendly platform that will help you make a Facebook Fan Page in an easy and friendly manner.</p>
<p>
	We have great tools to enhance your relationship with your fans. With us you will be able not only to make creative Facebook fan pages but also to integrate great social media widgets like Paypal, Ebay, Skype, etc. on your Fan Page. Moreover, you will be capable to make Coupons and schedule your messages on Facebook which will allow you to share your brand and activities with users that you care about keeping up to speed with the activities of your business.</p>
<p>
	Engage your fans and raise you brand and product awareness while you build customer loyalty!</p>
<p>
	Most importantly have fun while doing it!</p>
    </div>
    <div id="homevideocontainer" class="leanback-player-video">
        <img id="coveryth" src="<?= $this->getURL("images/pantallazoinicio-tutorial.png") ?>" width="380" height="253" alt="Welcome" />
    </div>
    <script type="text/javascript">
        $("#coveryth").click(function(){
            $(this).hide();
            $("#homevideocontainer").html('<object width="380" height="253"><param name="movie" value="http://www.youtube.com/v/8HJtUzlsoJA?version=3&hl=es_ES&autoplay=1"></param><param name="allowFullScreen" value="true"></param><param name="wmode" value="transparent"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/8HJtUzlsoJA?version=3&hl=es_ES&autoplay=1" type="application/x-shockwave-flash" width="380" height="253" allowscriptaccess="always" wmode="transparent" allowfullscreen="true"></embed></object>');
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