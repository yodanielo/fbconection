<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>a</title>
        <link type="text/css" rel="stylesheet" href="<?= $this->getURL("application/views/customized/fbconexion/nav.css") ?>" />
        <link rel="stylesheet" type="text/css" href="http://www.fbconexion.com/css/jquery-ui-1.8.12.custom.css" />
        <script type="text/javascript" src="http://www.fbconexion.com/onlineco/js/jquery-1.4.4.min.js"></script>
        <script type="text/javascript" src="http://www.fbconexion.com/js/jquery-ui-1.8.9.custom.min.js"></script>
        <!-- Start of Zopim Live Chat Script -->
        <script type="text/javascript">
            window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=
                    z.s=d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o
            ){z.set._.push(o)};$.setAttribute('charset','utf-8');$.async=!0;z.set.
                    _=[];$.src=('https:'==d.location.protocol?'https://ssl':'http://cdn')+
                    '.zopim.com/?P1xE465TeDVfR3YRiLSRwx0vXo7pdlj3';$.type='text/java'+s;z.
                    t=+new  Date;z._=[];e.parentNode.insertBefore($,e)})(document,'script');
        </script>
        <!-- End of Zopim Live Chat Script -->
    </head>
    <body>
        <div id="fb-root"></div>
        <script type="text/javascript">
            window.fbAsyncInit = function() {
                FB.init({
                    appId: '<?= $params["fbcred"]["id"] ?>',
                    status: true, 
                    cookie: true,
                    xfbml: true,
                    channelUrl  : 'http://www.fbconexion.com/channel.html',
                    oauth : true
                });
                function updateButton(response) {
                    $("#btnfacebook").click(function(){
                        //if (response.status == 'connected')
                        FB.logout(function(response){});
                        FB.login(function(response) {
                            if (response.status === 'connected') {
                                $.ajax({
                                    url:"<?= $this->getURL("/doSession") ?>",
                                    success:function(data){
                                        if(data.indexOf("ok")>-1){
                                            top.location.href="<?= $this->getURL($_SESSION["lang"] . "/fbconexion") ?>";
                                        }
                                    }
                                })
                            }
                        },{
                            "scope":"manage_pages,user_likes,offline_access,publish_stream,email"
                        });
                        return false;
                    })
                }

                // run it once with the current status and also whenever the status changes
                FB.getLoginStatus(updateButton);
                
                function autores(){
                    FB.Canvas.setAutoResize();
                    setTimeout(autores, 450);
                }
                autores();
            };
            (function() {
                var e = document.createElement('script'); 
                e.async = true;
                e.src = document.location.protocol +
                    '//connect.facebook.net/en_US/all.js';
                document.getElementById('fb-root').appendChild(e);
            }());
            //------------------------------------------------------------------
            contactodesign=function(){
                $("#bd2cont").dialog({
                    title:"Servicios de Diseño de Pagina de Fans",
                    modal:true,
                    width:280,
                    buttons:{
                        "OK":function(){
                            cumple=true;
                            $("#bd2cont .required").each(function(){
                                if($(this).val()==""){
                                    $(this).stop().effect("highlight", {}, 3000);
                                    cumple=false;
                                }
                            })
                            if(cumple){
                                $.ajax({
                                    url:"<?= $this->getURL(LANG . "fbconexion/boxdiseno/") ?>",
                                    type:"POST",
                                    data:"txt1="+encodeURIComponent($(".bd2_1").val())+"&txt2="+encodeURIComponent($(".bd2_2").val())+"&txt3="+encodeURIComponent($(".bd2_3").val())+"&txt4="+encodeURIComponent($(".bd2_4").val())+"&txt5="+encodeURIComponent($(".bd2_5").val())+"&txt6="+encodeURIComponent($(".bd2_6").val()),
                                    success:function(data){
                                        $("#dialogo .boxdiseno").remove();
                                        $("#bd2cont").dialog("close");
                                        $(".bd2input").val("");
                                    }
                                })
                            }
                        },
                        "Cancelar":function(){
                            $(this).dialog("close");
                        }
                    }
                })
            }
        </script>
        <div style="display: none">
            <div id="bd2cont">
                <div class="boxdiseno2">
                    <label class="bd2label"><?= __("txtnombrecompleto") ?></label>
                    <input type="text" class="bd2input bd2_1 required" value=""/>
                    <label class="bd2label"><?= __("txtemail") ?></label>
                    <input type="text" class="bd2input bd2_3 required" value=""/>
                    <label class="bd2label"><?= __("txtfanpageurl") ?></label>
                    <input type="text" class="bd2input bd2_2" value=""/>
                    <label class="bd2label"><?= __("Country") ?></label>
                    <input type="text" class="bd2input bd2_4 required" value=""/>
                    <label class="bd2label"><?= __("txttel") ?></label>
                    <input type="text" class="bd2input bd2_5" value=""/>
                    <label class="bd2label"><?= __("txtcomment") ?></label>
                    <textarea class="bd2input bd2_6"></textarea>
                </div>
            </div>
        </div>
        <div style="display:none">
            <audio id="controlesaudio" src="" loop="true" controls="controls" preload="auto" autobuffer></audio>
        </div>
        
        <div id="wrapper">
            <div id="header" style="text-align: center;position:relative;">
                <div style="position: absolute;right: 17px;top: 10px;">
                    <a style="padding: 5px;" target="_parent" href="http://www.facebook.com/Fan.Page.Latino?sk=app_192946747453023"><img src="http://www.fbconexion.com/images/flag_peru.png"></a>
                    <a style="padding: 5px;" target="_parent" href="http://www.facebook.com/online.conexion?sk=app_304023296293417"><img src="http://www.fbconexion.com/images/usa_flag.png"></a>
                </div>
                <div id="barrashare">
                    <div class="addthis_toolbox addthis_default_style ">
                        <a class="addthis_button_facebook"></a>
                        <a class="addthis_button_twitter"></a>
                        <a class="addthis_button_linkedin"></a>
                        <a class="addthis_button_google_plusone" g:plusone:annotation="none" g:plusone:size="small"></a>
                    </div>
                    <script type="text/javascript">
                        var addthis_share = {
                            title:"<?= $params["sitename"] ?>",
                            url:"<?= $this->getURL("") ?>"
                        };
                        var addthis_config = {
                            "data_track_clickback":true,
                            "ui_language" :"es"
                        };
                    </script>
                    <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4ee3898d34d8c215"></script>
                </div>
                <img style="width: 100px; float:none; margin-top:11px;" src="<?= $this->getURL("images/facebook-landing-pages-templates.png") ?>" alt="Facebook Landing Pages Templates" id="logo"/>
            </div>
            <div class="fbcuadroazul" id="cuadro1">
                <div style="margin-bottom: 10px;">
                    Somos la <strong style="font-size: 24px;">herramienta ideal</strong> para transformar simples conversaciones en verdaderas <strong style="font-size: 16px;">experiencias sociales</strong>. 
                </div>
                <div onclick="return contactodesign()" style="background:url(http://www.fbconexion.com/images/bannerdesignfanpage_es.jpg) bottom no-repeat" id="linkdesign"></div>
                <div id="pruebagratis">
                    Diseña tu<br/>FB Fan Page GRATIS
                </div>
                <div>
                    Nuestra plataforma es ideal para <strong style="font-size: 16px;">optimizar</strong> la <strong style="font-size: 16px;">experiencia</strong> social de sus visitantes de Facebook.
                </div>
            </div>
            <div id="btnfacebook">
                Comienza a personalizar tu Página en Facebook
            </div>
            <div class="titleseccion">
                <div class="contestrellas">
                    <div class="scrollstrella" style="width:<?= $params["promedio_final"] * 20 ?>px;"></div>
                </div>
                Chequea lo que los usuarios opinen sobre nosotros
            </div>
            <div class="fbcuadroazul" id="cuadro2">
                <div class="filaestrella">
                    <div class="contestrellas">
                        <div class="scrollstrella" style="width:<?= $params["teq"]->preg1 * 20 ?>px;"></div>
                    </div>
                    <?= __("teq1") ?>
                </div>
                <div class="filaestrella">
                    <div class="contestrellas">
                        <div class="scrollstrella" style="width:<?= $params["teq"]->preg2 * 20 ?>px;"></div>
                    </div>
                    <?= __("teq2") ?>
                </div>
                <div class="filaestrella">
                    <div class="contestrellas">
                        <div class="scrollstrella" style="width:<?= $params["teq"]->preg3 * 20 ?>px;"></div>
                    </div>
                    <?= __("teq3") ?>
                </div>
                <div class="filaestrella">
                    <div class="contestrellas">
                        <div class="scrollstrella" style="width:<?= $params["teq"]->preg4 * 20 ?>px;"></div>
                    </div>
                    <?= __("teq4") ?>
                </div>
                <div class="filaestrella">
                    <div class="contestrellas">
                        <div class="scrollstrella" style="width:<?= $params["teq"]->preg5 * 20 ?>px;"></div>
                    </div>
                    <?= __("teq5") ?>
                </div>
                <div style="text-align: center;"><a href="#" style="color:#fff; font-size: 13px; line-height: 25px;">ver comentarios</a></div>
            </div>
            <div class="fbcuadroazul" id="btnvermasenc">
                Ver
            </div>
            <div class="titleseccion">
                Visita nuestro Blog
            </div>
            <a href="http://www.fbconexion.com/blog/es/" target="_PARENT" id="btnblog"><img src="<?= $this->getURL("images/fpgotoblog_es.png") ?>" id=""/></a>
            <img src="<?= $this->getURL("images/fppersonaje_fanpage.png") ?>" id="fabricio" />
            <div class="fbcuadroazul" id="cuadro3" style="margin-bottom: 120px;">
                <div id="txtencuentra">
                    Encuentra páginas hechas en FBConexion
                </div>
                <div id="cuadrobuscar">
                    <form id="frmpagina" action="#" method="post">
                        <label>Categorías</label>
                        <select id="txtcat">
                            <option value="0">--Todas las categorías--</option>
                            <?php
                            if (count($params["cats"]) > 0) {
                                foreach ($params["cats"] as $cat) {
                                    echo '<option value="' . $cat . '">' . $cat . '</option>' . "\n";
                                }
                            }
                            ?>
                        </select>
                        <input type="submit" value="Ir" />
                    </form>
                </div>
                <div class="listadopaginas">
                    <div id="contpaginas">
                        <?php
                        echo $params["paginas"];
                        ?>
                    </div>
                    <div style="display: block; text-align: center;">
                        <a href="2" style="color:#fff;" id="linkvermaspag">Ver más</a>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                $("#frmpagina").submit(function(){
                    $("#contpaginas").empty();
                    $("#linkvermaspag").show();
                    $("#linkvermaspag").attr("href",1);
                    $("#linkvermaspag").click();
                    return false;
                })
                $("#linkvermaspag").click(function(){
                    $.ajax({
                        url:"<?= $this->getURL("customized/fbconexion/2") ?>",
                        data:"cat="+encodeURIComponent($("#txtcat").val())+"&pag="+$(this).attr("href"),
                        type:"POST",
                        async:false,
                        success:function(data){
                            r=$("#linkvermaspag").attr("href")*1+1;
                            $("#linkvermaspag").attr("href",r);
                            $("#contpaginas").append(data);
                            FB.XFBML.parse($("#contpaginas")[0])
                        }
                    })
                    return false;
                })
                
                $("#btnvermasenc").click(function(){
                    if($(this).html().indexOf("Ver")>-1){
                        $("#cuadro2").slideDown(450, function(){});
                        $(this).html("Ocultar");
                    }else{
                        $("#cuadro2").slideUp(450, function(){});
                        $(this).html("Ver");
                    }
                })
                animar=function(){
                    $("#btnfacebook").animate({"opacity":0}, 2000, "linear", function(){
                        $("#btnfacebook").animate({"opacity":1}, 2000, "linear", function(){
                            setTimeout(animar,5000);
                        });
                    })
                }
                animar()
            </script>
        </div>
    </body>
</html>
