<?php

class Cfbwidgets extends application {

    function _marca($w) {
        return $w . "_" . mktime() . rand(0, 4000000000);
    }

    function _escribir($ed, $prod, $marca, $estructura=array()) {
        $db = $this->dbInstance();
        $db->insert("#_widgeted", array(
            "contenido_ed" => $ed,
            "contenido_prod" => $prod,
            "marca" => $marca,
            "estructura" => urlencode(json_encode($estructura))
        ));
    }

    /**
     * html
     * 150 x 150
     */
    function w1() {
        $marca = $this->_marca("w1");
        $dato = "";
        $prod = $dato;
        $estructura = array(
            "edb_w1" => $dato,
        );
        $this->_escribir($dato, $prod, $marca, $estructura);
        ?>
        <div class="wm_editor wm1" id="<?= $marca ?>">
            <div class="wmcover"></div><div class="wm_edco">

            </div>
        </div>
        <?php
    }

    /**
     * flash
     */
    function w2() {
        $marca = $this->_marca("w2");
        $dato = '<img class="paresizar" src="' . $this->getURL("images/bg_flash0.jpg") . '" alt="Flash"  />';
        $prod = '';
        $estructura = array(
            "width" => "150",
            "height" => "150"
        );
        $this->_escribir($dato, $prod, $marca, $estructura);
        ?>
        <div class="wm_editor wm2" id="<?= $marca ?>">
            <div class="wmcover"></div><div class="wm_edco">
                <?php echo $dato; ?>
            </div>
        </div>
        <?php
    }

    /**
     * comentarios
     * 520 x 220
     */
    function w3() {
        $marca = $this->_marca("w3");
        $dato = '<div style="text-align:center"><img class="paresizar" src="' . $this->getURL("images/bg_comentario.jpg") . '" alt="Flash"  /></div>';
        $estructura = array(
            "edb_w1" => "",
            "edb_w2" => "3",
            "edb_w3" => "light",
            "edb_w4" => "false",
            "width" => "520",
            "height" => "81"
        );
        $prod = '<fb:comments href="http://www.google.com" num_posts="8" width="520" colorscheme ="light">';
        $prod.='<script>$("#' . $marca . '").height("auto");</script>';
        $this->_escribir($dato, $prod, $marca, $estructura);
        ?>
        <div class="wm_editor wm3" id="<?= $marca ?>" style="left:0px; top:0px; width:520px; height:81px;">
            <div class="wmcover"></div><div class="wm_edco">
                <?php echo $dato; ?>
            </div>
        </div>
        <?php
    }

    /**
     * video
     * 520 x 400
     */
    function w4() {
        $marca = $this->_marca("w4");
        $dato = '<img class="paresizar" src="' . $this->getURL("images/bg_video0.jpg") . '" alt="Video" style=" width:520px; height:400px;" />';
        $prod = '';
        $estructura = array(
            "width" => "520",
            "height" => "400"
        );
        $this->_escribir($dato, $prod, $marca, $estructura);
        ?>
        <div class="wm_editor wm4" id="<?= $marca ?>" style="left:0px; top:0px; width:520px; height:400px;">
            <div class="wmcover"></div><div class="wm_edco">
                <?php echo $dato; ?>
            </div>
        </div>
        <?php
    }

    /**
     * rss
     * 250 x 417
     */
    function w5() {
        $marca = $this->_marca("w5");
        $dato = '<img class="paresizar" src="' . $this->getURL("images/bg_rss.jpg") . '" alt="Video" />';
        $prod = 'RSS widget is not configured yet';
        $estructura = array(
            "width" => "230",
            "height" => "230",
            "edb_w1" => "",
            "edb_w2" => "yes",
            "edb_w3" => "brief",
            "edb_w4" => "5",
            "edb_w5" => "#fff",
        );
        $this->_escribir($dato, $prod, $marca, $estructura);
        ?>
        <div class="wm_editor wm5" id="<?= $marca ?>" style="left:0px; top:0px; width:230px; height:230px;">
            <div class="wmcover"></div><div class="wm_edco">
                <?php echo $dato; ?>
            </div>
        </div>
        <?php
    }

    /**
     * youtube
     * 520 x 354
     */
    function w7() {
        $marca = $this->_marca("w7");
        $dato = '<img class="paresizar" src="' . $this->getURL("images/bg_youtube0.jpg") . '" alt="Video" style="width:520px; height:354px;" />';
        $prod = '';
        $estructura = array(
            "width" => 520,
            "height" => 354
        );
        $this->_escribir($dato, $prod, $marca, $estructura);
        ?>
        <div class="wm_editor wm7" id="<?= $marca ?>" style="left:0px; top:0px; width:520px; height:354px;">
            <div class="wmcover"></div><div class="wm_edco">
                <?php echo $dato; ?>
            </div>
        </div>
        <?php
    }

    /**
     * musica mixpod
     * 345 x 311
     */
    function w8() {
        $marca = $this->_marca("w8");
        $dato = '<img class="paresizar" src="' . $this->getURL("images/bg_mixpod.jpg") . '" alt="Video" style="width:347px; height:311px;" />';
        $prod = '';
        $estructura = array(
            "width" => 347,
            "height" => 311
        );
        $this->_escribir($dato, $prod, $marca, $estructura);
        ?>
        <div class="wm_editor wm8" id="<?= $marca ?>" style="left:0px; top:0px; width:347px; height:311px;">
            <div class="wmcover"></div><div class="wm_edco">
        <?php echo $dato; ?>
            </div>
        </div>
        <?php
    }

    /**
     * share addthis
     * 520 x 354
     */
    function w9() {
        $marca = $this->_marca("w9");
        $dato = '<div style="float:left; width:242px; height:32px; background:url(' . $this->getURL("images/ico_share.jpg") . ') 0px -17px;"></div>';
        $prod = $dato;
        $estructura = array(
            "width" => 242,
            "height" => 32,
            "edb_w2" => "big",
        );
        $this->_escribir($dato, $prod, $marca, $estructura);
        ?>
        <div class="wm_editor wm9" id="<?= $marca ?>" style="left:0px; top:0px; width:242px; height:32px;">
            <div class="wmcover"></div><div class="wm_edco">
        <?php echo $dato; ?>
            </div>
        </div>
        <?php
    }

    /**
     * listado de youtube
     * 520 x 354
     */
    function w10() {
        $marca = $this->_marca("w10");
        $dato = '<img class="paresizar" src="' . $this->getURL("images/bg_youtubelist.jpg") . '"/>';
        $prod = $dato;
        $marca2="x".mktime().rand(1,999999);
        $estructura = array(
            "width" => 520,
            "height" => 520
        );
        $this->_escribir($dato, $prod, $marca, $estructura);
        ?>
        <div class="wm_editor wm10" id="<?= $marca ?>" style="left:0px; top:0px; width:520px; height:520px;">
            <div class="wmcover"></div><div class="wm_edco">
        <?php echo $dato; ?>
                <script type="text/javascript">
                    <?=$marca2?>fun=function(){
                        $("#<?=$id?>").height("auto");
                        setTimeout(<?=$marca2?>fun,200);
                    }
                    <?=$marca2?>fun();
                </script>
            </div>
        </div>
        <?php
    }

//imagen
    function w12() {
        $marca = $this->_marca("w12");
        $dato = '<img class="paresizar" src="' . $this->getURL("images/bg_image.jpg") . '" alt="Video"  />';
        $prod = '<img class="paresizar" src="' . $this->getURL("images/bg_image.jpg") . '" alt="Video"  />';
        $struc = array(
            "width" => 150,
            "height" => 150,
            "edb_w1" => $this->getURL("images/bg_image.jpg")
        );
        $this->_escribir($dato, $prod, $marca, $struc);
        ?>
        <div class="wm_editor wm12" id="<?= $marca ?>">
            <div class="wmcover"></div><div class="wm_edco">
        <?php echo $dato; ?>
            </div>
        </div>
        <?php
    }

    /**
     * twitter
     * 250 x 417
     */
    function w13() {
        $marca = $this->_marca("w13");
        $dato = '<img class="paresizar" src="' . $this->getURL("images/bg_twitter.jpg") . '" alt="Video"  />';
        $prod = 'Twitter is not longer available...';
        $struc = array(
            "width" => 250,
            "height" => 417
        );
        $this->_escribir($dato, $prod, $marca, $struc);
        ?>
        <div class="wm_editor wm13" id="<?= $marca ?>" style="top: 0px; left:0px; width:250px; height:417px;">
            <div class="wmcover"></div><div class="wm_edco">
        <?php echo $dato; ?>
            </div>
        </div>
        <?php
    }

    /**
     * ustream
     */
    function w14() {
        $marca = $this->_marca("w14");
        $dato = '<img class="paresizar" src="' . $this->getURL("images/bg_ustream0.jpg") . '" alt="Video"  />';
        $prod = 'Ustream is not longer available...';
        $struc = array(
            "width" => 520,
            "height" => 417
        );
        $this->_escribir($dato, $prod, $marca, $struc);
        ?>
        <div class="wm_editor wm14" id="<?= $marca ?>" style="left:0px; top:0px; width:520px; height:417px;">
            <div class="wmcover"></div><div class="wm_edco">
        <?php echo $dato; ?>
            </div>
        </div>
        <?php
    }

    /**
     * me gusta
     * 340 x 32
     */
    function w15() {
        $marca = $this->_marca("w15");
        $dato = '<img class="paresizar" src="' . $this->getURL("images/bg_like.png") . '" alt="Video"  />';
        $prod = $dato;
        $struc = array(
            "width" => 115,
            "height" => 34,
            "edb_w3"=>"button_count",
        );
        $this->_escribir($dato, $prod, $marca, $struc);
        ?>
        <div class="wm_editor wm15" id="<?= $marca ?>" style="left:0px; top:0px; width:115px; height:34px;">
            <div class="wmcover"></div><div class="wm_edco">
        <?php echo $dato; ?>
            </div>
        </div>
        <?php
    }

//texto
    function w17() {
        $marca = $this->_marca("w17");
        $dato = 'Insert text';
        $prod = 'Insert text';
        $estructura = array(
            "edb_w1" => $dato,
        );
        $this->_escribir($dato, $prod, $marca, $estructura);
        ?>
        <div class="wm_editor wm17" id="<?= $marca ?>">
            <div class="wmcover"></div><div class="wm_edco">
                <div class="paresizar" style="position:absolute; width:150px;height:150px;"></div>
        <?= $dato ?>
            </div>        
        </div>
        <?php
    }

    //live stream chat
    function w18() {
        $marca = $this->_marca("w18");
        $dato = '<img class="paresizar" src="' . $this->getURL("images/bg_chat_facebook.png") . '" style="width:300px; height:400px;"/>';
        $prod = '<fb:live-stream event_app_id="212144002139857" width="400" height="300" xid="" via_url="http://www.fbconexion.com" always_post_to_friends="false"></fb:live-stream>';
        $estructura = array(
            "edb_w1" => $dato,
            "width" => 300,
            "height" => 400,
            "edb_w1" => $this->getURL(""),
            "edb_w2" => "false",
                //"edb_w2"=>"false"
        );
        $this->_escribir($dato, $prod, $marca, $estructura);
        ?>
        <div class="wm_editor wm18" id="<?= $marca ?>" style="left:0px; top:0px; width:300px; height:400px;">
            <div class="wmcover"></div><div class="wm_edco">
        <?= $dato ?>
            </div>        
        </div>
        <?php
    }

    //follow us
    function w19() {
        $marca = $this->_marca("w19");
        $dato = '<div class="paresizar" style="float:left;background:url(' . $this->getURL("images/bg_followus.png") . ') no-repeat left top; width:300px; height:400px;"></div>';
        $prod = $dato;
        $estructura = array(
            "edb_w1" => "",
            "width" => 300,
            "height" => 400
                //"edb_w2"=>"false"
        );
        $this->_escribir($dato, $prod, $marca, $estructura);
        ?>
        <div class="wm_editor wm19" id="<?= $marca ?>" style="left:0px; top:0px; width:300px; height:400px;">
            <div class="wmcover"></div><div class="wm_edco">
        <?= $dato ?>
            </div>        
        </div>
        <?php
    }

    //galeria fb
    function w21() {
        $marca = $this->_marca("w21");
        $dato = '<img class="paresizar" src="' . $this->getURL("images/gallery_1-" . $_SESSION["lang"] . ".jpg") . '"/>';
        $prod = $dato;
        $estructura = array(
            "width" => 520,
            "height" => 380,
            "edb_w1" => 0,
            "edb_conteo" => 0
        );
        $this->_escribir($dato, $prod, $marca, $estructura);
        ?>
        <div class="wm_editor wm21" id="<?= $marca ?>" style="left:0px; top:0px; width:520px; height:380px;">
            <div class="wmcover"></div><div class="wm_edco">
        <?= $dato ?>
            </div>        
        </div>
        <?php
    }

    //google maps
    function w22() {
        $marca = $this->_marca("w22");
        $dato = '<img class="paresizar" src="' . $this->getURL("images/bg_map.jpg") . '" alt="Video"  />';
        $prod = '<img class="paresizar" src="' . $this->getURL("images/bg_map.jpg") . '" alt="Video"  />';
        $struc = array(
            "width" => 520,
            "height" => 250,
            "edb_w5" => 14
        );
        $this->_escribir($dato, $prod, $marca, $struc);
        ?>
        <div class="wm_editor wm22" id="<?= $marca ?>" style="left:0px; top:0px; width:520px; height:250px;">
            <div class="wmcover"></div><div class="wm_edco">
        <?php echo $dato; ?>
            </div>
        </div>
        <?php
    }

    //paypal donativo
    function w23() {
        $marca = $this->_marca("w23");
        $dato = '<img class="paresizar" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" alt="Video"  />';
        $prod = '<img class="paresizar" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" alt="Video"  />';
        $struc = array(
            "width" => 92,
            "height" => 26,
            "edb_w2" => 0
        );
        $this->_escribir($dato, $prod, $marca, $struc);
        ?>
        <div class="wm_editor wm23" id="<?= $marca ?>" style="left:0px; top:0px; width:92px; height:26px;">
            <div class="wmcover"></div><div class="wm_edco">
        <?php echo $dato; ?>
            </div>
        </div>
        <?php
    }

    //galeria flikr
    function w24() {
        $marca = $this->_marca("w24");
        $dato = '<img class="paresizar" src="' . $this->getURL("images/bg_galeria0.jpg") . '"/>';
        $prod = $dato;
        $estructura = array(
            "width" => 520,
            "height" => 520,
            "edb_w1" => "0",
            "edb_conteo" => "0"
        );
        $this->_escribir($dato, $prod, $marca, $estructura);
        ?>
        <div class="wm_editor wm24" id="<?= $marca ?>" style="left:0px; top:0px; width:520px; height:520px;">
            <div class="wmcover"></div><div class="wm_edco">
        <?= $dato ?>
            </div>        
        </div>
        <?php
    }

    //galeria picasa
    function w25() {
        $marca = $this->_marca("w25");
        $dato = '<img class="paresizar" src="' . $this->getURL("images/bg_galeria0.jpg") . '"/>';
        $prod = $dato;
        $estructura = array(
            "width" => 520,
            "height" => 520,
            "edb_w1" => 0,
            "edb_conteo" => 0
        );
        $this->_escribir($dato, $prod, $marca, $estructura);
        ?>
        <div class="wm_editor wm25" id="<?= $marca ?>" style="left:0px; top:0px; width:520px; height:520px;">
            <div class="wmcover"></div><div class="wm_edco">
        <?= $dato ?>
            </div>        
        </div>
        <?php
    }

    //facebook video
    function w26() {
        $marca = $this->_marca("w26");
        $dato = '<img class="paresizar" src="' . $this->getURL("images/bg_video_facebook.jpg") . '" alt="Video"  />';
        $prod = '<img class="paresizar" src="' . $this->getURL("images/bg_video_facebook.jpg") . '" alt="Video"  />';
        $struc = array(
            "width" => 520,
            "height" => 243
        );
        $this->_escribir($dato, $prod, $marca, $struc);
        ?>
        <div class="wm_editor wm26" id="<?= $marca ?>" style="left:0px; top:0px; width:520px; height:243px;">
            <div class="wmcover"></div><div class="wm_edco">
        <?php echo $dato; ?>
            </div>
        </div>
        <?php
    }

    /**
     * iframe
     */
    function w27() {
        $marca = $this->_marca("w27");
        $dato = '<img class="paresizar" src="' . $this->getURL("images/bg_iframe.jpg") . '" alt="Video"  />';
        $prod = '<img class="paresizar" src="' . $this->getURL("images/bg_iframe.jpg") . '" alt="Video"  />';
        $struc = array(
            "width" => 520,
            "height" => 250
        );
        $this->_escribir($dato, $prod, $marca, $struc);
        ?>
        <div class="wm_editor wm27" id="<?= $marca ?>" style="left:0px; top:0px; width:520px; height:250px;">
            <div class="wmcover"></div><div class="wm_edco">
        <?php echo $dato; ?>
            </div>
        </div>
        <?php
    }

    /**
     * shapes
     */
    function w29() {
        $marca = $this->_marca("w29");
        $dato = '
            <canvas class="paresizar shapedraw" style="position:relative; width:150px; height:150px;"></canvas>
            <div class="shapetext paresizar" style="position:absolute; width:150px; height:150px;"></div>
            <script type="text/javascript">
                $("#' . $marca . ' .shapedraw").shape(0,"#00000");
            </script>
            '; //PENDIENT cuando se jala u nuevo widget de shapes, los tabs de los widgets dejan de funcionar
        $struc = array(
            "width" => 150,
            "height" => 150,
            "edb_w1" => 0,
            "edb_w2" => "#000000", //line color
            "texto" => "", //texto
        );
        $this->_escribir($dato, $dato, $marca, $struc);
        ?>
        <div class="wm_editor wm29" id="<?= $marca ?>" style="left:0px; top:0px; width:150px; height:150px;">
            <div class="wmcover"></div><div class="wm_edco">
        <?php echo $dato; ?>

            </div>
        </div>
        <?php
    }

    /**
     * contact form
     */
    function w30() {
        $marca = $this->_marca("w30");
        $dato = '<img src="' . $this->getURL("images/bg_contact.jpg") . '" class="paresizar"/>';
        $struc = array(
            "width" => 250,
            "height" => 375,
            "edb_w1" => "info@fbconexion.com",
            "edb_w2" => "info@fbconexion.com",
            "edb_w3" => '',
            "edb_w4" => 1,
            "edb_w5" => 1,
            "edb_w6" => 0,
            "edb_w7" => 0,
            "edb_w8" => 0,
            "edb_w9" => 1,
            "edb_w10" => "#fff",
        );
        $this->_escribir($dato, $dato, $marca, $struc);
        ?>
        <div class="wm_editor wm30" id="<?= $marca ?>" style="left:0px; top:0px; width:250px; height:375px;">
            <div class="wmcover"></div><div class="wm_edco">
        <?php echo $dato; ?>
            </div>
        </div>
        <?php
    }

    /**
     * skype
     */
    function w32() {
        $marca = $this->_marca("w32");
        $dato = '<div class="paresizar"><img class="paresizar" src="'.$this->getURL("images/call_green_white_124x52.png").'" style="width:124px; height:52px;"/></div>';
        $struc = array(
            "width" => 124,
            "height" => 52,
            "edb_w1" => "onlineconexion",
            "edb_w2" => 0,
            "edb_w3" => "call",
            "edb_w4" => "",
        );
        $this->_escribir($dato, $dato, $marca, $struc);
        ?>
        <div class="wm_editor wm32" id="<?= $marca ?>" style="left:0px; top:0px; width:124px; height:52px;">
            <div class="wmcover"></div><div class="wm_edco">
        <?php echo $dato; ?>
            </div>
        </div>
        <?php
    }

    /**
     * yelp
     */
    function w33() {
        $marca = $this->_marca("w33");
        $dato = '<img src="' . $this->getURL("images/bg_yelp.png") . '" class="paresizar"/>';
        $struc = array(
            "width" => 520,
            "height" => 458,
            "edb_w1" => "",
        );
        $this->_escribir($dato, $dato, $marca, $struc);
        ?>
        <div class="wm_editor wm33" id="<?= $marca ?>" style="left:0px; top:0px; width:520px; height:520px;">
            <div class="wmcover"></div><div class="wm_edco">
        <?php echo $dato; ?>
            </div>
        </div>
        <?php
    }

    /**
     * scribd
     */
    function w34() {
        $marca = $this->_marca("w34");
        $dato = '<img src="' . $this->getURL("images/bg_scribd.jpg") . '" class="paresizar"/>';
        $struc = array(
            "width" => 520,
            "height" => 520,
        );
        $this->_escribir($dato, $dato, $marca, $struc);
        ?>
        <div class="wm_editor wm34" id="<?= $marca ?>" style="left:0px; top:0px; width:520px; height:520px;">
            <div class="wmcover"></div><div class="wm_edco">
        <?php echo $dato; ?>
            </div>
        </div>
        <?php
    }

    /**
     * lastfm
     */
    function w35() {
        $marca = $this->_marca("w35");
        $dato = '<img src="' . $this->getURL("images/bg_lastfm.jpg") . '" class="paresizar"/>';
        $struc = array(
            "width" => 400,
            "height" => 150,
        );
        $this->_escribir($dato, $dato, $marca, $struc);
        ?>
        <div class="wm_editor wm35" id="<?= $marca ?>" style="left:0px; top:0px; width:400px; height:150px;">
            <div class="wmcover"></div><div class="wm_edco">
        <?php echo $dato; ?>
            </div>
        </div>
        <?php
    }

    /**
     * digg
     */
    function w36() {
        $marca = $this->_marca("w36");
        $dato = '<img src="' . $this->getURL("images/bg_digg.jpg") . '" class="paresizar"/>';
        $struc = array(
            "width" => 520,
            "height" => 520,
        );
        $this->_escribir($dato, $dato, $marca, $struc);
        ?>
        <div class="wm_editor wm36" id="<?= $marca ?>" style="left:0px; top:0px; width:520px; height:520px;">
            <div class="wmcover"></div><div class="wm_edco">
        <?php echo $dato; ?>
            </div>
        </div>
        <?php
    }

    /**
     * dailymotion
     */
    function w37() {
        $marca = $this->_marca("w37");
        $dato = '<img src="' . $this->getURL("images/bg_dailymotion.jpg") . '" class="paresizar"/>';
        $struc = array(
            "width" => 520,
            "height" => 270,
            "edb_w2" => "0",
            "edb_w3" => "#FF0000",
            "edb_w4" => "#493D27",
            "edb_w5" => "#FFFFF0",
        );
        $this->_escribir($dato, $dato, $marca, $struc);
        ?>
        <div class="wm_editor wm37" id="<?= $marca ?>" style="left:0px; top:0px; width:520px; height:270px;">
            <div class="wmcover"></div><div class="wm_edco">
        <?php echo $dato; ?>
            </div>
        </div>
        <?php
    }

    /**
     * meetup
     */
    function w38() {
        $marca = $this->_marca("w38");
        $marca2 = "x" . mktime() . rand(0, 99999);
        $dato = '<img src="' . $this->getURL("images/bg_meetup.jpg") . '"/>
            <script type="text/javascript">
                ' . $marca2 . 'fun=function(){
                    $("#' . $marca . '").width("auto");
                    $("#' . $marca . '").height("auto");
                    setTimeout(' . $marca2 . 'fun,200);
                }
                ' . $marca2 . 'fun();
            </script>';
        $struc = array(
            "width" => 520,
            "height" => 334,
        );
        $this->_escribir($dato, $dato, $marca, $struc);
        ?>
        <div class="wm_editor wm38" id="<?= $marca ?>" style="left:0px; top:0px; width:520px; height:334px;">
            <div class="wmcover"></div><div class="wm_edco">
        <?php echo $dato; ?>
            </div>
        </div>
        <?php
    }

    /**
     * zillow
     */
    function w39() {
        $marca = $this->_marca("w39");
        $dato = '<img src="' . $this->getURL("images/bg_zillow.jpg") . '" class="paresizar"/>';
        $struc = array(
            "width" => 180,
            "height" => 360,
            "edb_w2" => 0
        );
        $this->_escribir($dato, $dato, $marca, $struc);
        ?>
        <div class="wm_editor wm39" id="<?= $marca ?>" style="left:0px; top:0px; width:180px; height:360px;">
            <div class="wmcover"></div><div class="wm_edco">
        <?php echo $dato; ?>
            </div>
        </div>
        <?php
    }

    /**
     * countdown
     */
    function w40() {
        $marca = $this->_marca("w40");
        $marca2 = "x" . mktime() . rand(0, 99999);
        $dato = '<div id="' . $marca2 . '" style="padding:5px; background:#000; color:#fff; overflow:hidden; line-height:100%; float:left; width:100%; text-align:center;">0 days 00:00:00</div>
        <script type="text/javascript">
            ' . $marca2 . 'cambio=function(){
                a=$("#' . $marca . '").height();
                $("#' . $marca2 . '").css({
                    "font-size":(a-10>60?60:a-10),
                    "font-family":"Verdana",
                    "font-weight":"bold"
                });
                $("#' . $marca . '").height("auto");
                setTimeout(' . $marca2 . 'cambio,450);
            }
            ' . $marca2 . 'cambio();            
        </script>';
        $struc = array(
            "width" => 520,
            "height" => 40,
            "edb_w2" => "#000",
            "edb_w3" => "#fff",
        );
        $this->_escribir($dato, $dato, $marca, $struc);
        ?>
        <div class="wm_editor wm40" id="<?= $marca ?>" style="left:0px; top:0px; width:520px; height:40px;">
            <div class="wmcover"></div><div class="wm_edco">
        <?php echo $dato; ?>
            </div>
        </div>
        <?php
    }

    /**
     * ebay
     */
    function w41() {
        $marca = $this->_marca("w41");
        $marca2 = "x" . mktime() . rand(0, 99999);
        $dato = '<img src="' . $this->getURL("images/bg_ebay.jpg") . '" class="paresizar" />';
        $struc = array(
            "width" => 355,
            "height" => 355,
            "edb_w2" => "#000",
            "edb_w3" => "#fff",
        );
        $this->_escribir($dato, $dato, $marca, $struc);
        ?>
        <div class="wm_editor wm40" id="<?= $marca ?>" style="left:0px; top:0px; width:355px; height:355px;">
            <div class="wmcover"></div><div class="wm_edco">
        <?php echo $dato; ?>
            </div>
        </div>
        <?php
    }

    /**
     * slideshare
     */
    function w42() {
        $marca = $this->_marca("w42");
        $marca2 = "x" . mktime() . rand(0, 99999);
        $dato = '<img src="' . $this->getURL("images/bg_slideshare.jpg") . '" class="paresizar" />';
        $struc = array(
            "width" => 425,
            "height" => 355,
        );
        $this->_escribir($dato, $dato, $marca, $struc);
        ?>
        <div class="wm_editor wm42" id="<?= $marca ?>" style="left:0px; top:0px; width:425px; height:355px;">
            <div class="wmcover"></div><div class="wm_edco">
        <?php echo $dato; ?>
            </div>
        </div>
        <?php
    }

    /**
     * linkedin apply
     */
    function w43() {
        $marca = $this->_marca("w43");
        $marca2 = "x" . mktime() . rand(0, 99999);
        $dato = '<img src="' . $this->getURL("images/bg_linkedinapply.jpg") . '" />
            <script type="text/javascript">
                ' . $marca2 . 'fun=function(){
                    $("#' . $marca . '").width("auto");
                    $("#' . $marca . '").height("auto");
                    setTimeout(' . $marca2 . 'fun,200);
                }
                ' . $marca2 . 'fun();
            </script>';
        $struc = array(
            "width" => 186,
            "height" => 33,
            "edb_w1" => "http://www.linkedin.com/company/",
            "edb_w2" => "",
            "edb_w3" => "",
            "edb_w4" => "",
            "edb_w5" => "",
            "edb_w6" => "#ffffff",
        );
        $this->_escribir($dato, $dato, $marca, $struc);
        ?>
        <div class="wm_editor wm43" id="<?= $marca ?>" style="left:0px; top:0px; width:186px; height:33px;">
            <div class="wmcover"></div><div class="wm_edco">
        <?php echo $dato; ?>
            </div>
        </div>
        <?php
    }

    /**
     * linkedin user profile
     */
    function w44() {
        $marca = $this->_marca("w44");
        $marca2 = "x" . mktime() . rand(0, 99999);
        $dato = '<img src="' . $this->getURL("images/bg_linkedinuserprofile.jpg") . '" />
            <script type="text/javascript">
                ' . $marca2 . 'fun=function(){
                    $("#' . $marca . '").width("auto");
                    $("#' . $marca . '").height("auto");
                    setTimeout(' . $marca2 . 'fun,200);
                }
                ' . $marca2 . 'fun();
            </script>';
        $struc = array(
            "width" => 356,
            "height" => 210,
            "edb_w1" => "http://www.linkedin.com/in/",
        );
        $this->_escribir($dato, $dato, $marca, $struc);
        ?>
        <div class="wm_editor wm44" id="<?= $marca ?>" style="left:0px; top:0px; width:356px; height:210px;">
            <div class="wmcover"></div><div class="wm_edco">
        <?php echo $dato; ?>
            </div>
        </div>
        <?php
    }

    /**
     * linkedin company profile
     */
    function w45() {
        $marca = $this->_marca("w45");
        $marca2 = "x" . mktime() . rand(0, 99999);
        $dato = '<img src="' . $this->getURL("images/bg_linkedincompanyprofile.jpg") . '"/>
            <script type="text/javascript">
                ' . $marca2 . 'fun=function(){
                    $("#' . $marca . '").width("auto");
                    $("#' . $marca . '").height("auto");
                    setTimeout(' . $marca2 . 'fun,200);
                }
                ' . $marca2 . 'fun();
            </script>';
        $struc = array(
            "width" => 425,
            "height" => 355,
            "edb_w1" => "http://www.linkedin.com/company/",
        );
        $this->_escribir($dato, $dato, $marca, $struc);
        ?>
        <div class="wm_editor wm45" id="<?= $marca ?>" style="left:0px; top:0px; width:425px; height:355px;">
            <div class="wmcover"></div><div class="wm_edco">
        <?php echo $dato; ?>
            </div>
        </div>
        <?php
    }

    /**
     * product
     */
    function w46() {
        $marca = $this->_marca("w46");
        $marca2 = "x" . mktime() . rand(0, 99999);
        $dato = '<img class="paresizar" src="' . $this->getURL("images/bg_product.jpg") . '" width="190" height="275"/>
            <script type="text/javascript">
                ' . $marca2 . 'fun=function(){
                    $("#' . $marca . '").height("auto");
                    setTimeout(' . $marca2 . 'fun,200);
                }
                ' . $marca2 . 'fun();
            </script>';
        $struc = array(
            "width" => 190,
            "height" => 275,
            "edb_w1" => "",
        );
        $this->_escribir($dato, $dato, $marca, $struc);
        ?>
        <div class="wm_editor wm46" id="<?= $marca ?>" style="left:0px; top:0px; width:190px; height:275px;">
            <div class="wmcover"></div><div class="wm_edco">
        <?php echo $dato; ?>
            </div>
        </div>
        <?php
    }

    /**
     * Mail Chimp
     */
    function w47(){
        $marca = $this->_marca("w47");
        $marca2 = "x" . mktime() . rand(0, 99999);
        $dato = '<img src="'.$this->getURL("images/bg_mailchimp.jpg").'" class="paresizar"/>';
        $struc = array(
            "width" => 200,
            "height" => 171,
            "edb_w1" => "",
        );
        $this->_escribir($dato, $dato, $marca, $struc);
        ?>
        <div class="wm_editor wm47" id="<?= $marca ?>" style="left:0px; top:0px; width:200px; height:171px;">
            <div class="wmcover"></div><div class="wm_edco">
        <?php echo $dato; ?>
            </div>
        </div>
        <?php
    }

    /**
     * Grupon, solo para USA
     */
    function w48(){
        $marca = $this->_marca("w48");
        $marca2 = "x" . mktime() . rand(0, 99999);
        $dato = '<img src="http://groupon-latam.s3.amazonaws.com/groupon-web.png" class="paresizar"/>';
        $struc = array(
            "width" => 520,
            "height" => 221,
            "edb_w1" => "",
        );
        $this->_escribir($dato, $dato, $marca, $struc);
        ?>
        <div class="wm_editor wm48" id="<?= $marca ?>" style="left:0px; top:0px; width:520px; height:221px;">
            <div class="wmcover"></div><div class="wm_edco">
        <?php echo $dato; ?>
            </div>
        </div>
        <?php
    }
    
    /**
     * contest concurso competition
     */
    function w49(){
        $marca = $this->_marca("w49");
        $marca2 = "x" . mktime() . rand(0, 99999);
        $dato = '<img src="'.$this->getURL("images/bg_contest.jpg").'" class="paresizar"/>';
        $struc = array(
            "edb_w1" => "",
            "edb_w2" => "Image",
            "edb_w3" => "1",
            "width" => 520,
            "height" => 520,
            "edb_w1" => "",
        );
        $this->_escribir($dato, $dato, $marca, $struc);
        ?>
        <div class="wm_editor wm49" id="<?= $marca ?>" style="left:0px; top:0px; width:520px; height:520px;">
            <div class="wmcover"></div><div class="wm_edco">
        <?php echo $dato; ?>
            </div>
        </div>
        <?php
    }
}
?>
