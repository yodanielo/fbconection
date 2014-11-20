<?php
$lib=$this->loadLib("textlibs");
$nodes = $params["nodes"];
$des = $params["des"];
$usuarios = $params["usuarios"];
?>
<div class="wrappersup" style="min-height:542px;">
    <div id="faqtabs">
        <div class="faqlbltab"><?= __("titfeaturedquestions") ?></div>
        <div class="faqlbltab"><?= __("titquestions") ?></div>
        <div class="faqlbltab"><?= __("titask") ?></div>
    </div>
    <div id="faqdettabs">
        <!--featured questions-->
        <div class="faqdettab">
            <?php
            if (count($des) > 0) {
                foreach ($des as $nd) {
                    ?>
                    <div class="itempregunta">
                        <?php
                                if($params["esadmin"]){
                                    echo '<div class="faqdel" alt="'.$nd->id.'">x</div>';
                                }
                                ?>
                        <a class="faqavatar" target="_blank" href="<?= $usuarios["x" . $nd->idusuario]["profile_url"] ?>">
                            <img src="https://graph.facebook.com/1418715186/picture"/>
                        </a>
                        <div class="picopregunta"></div>
                        <div class="faqsetpregunta">
                            <div class="faqcuadropregunta"><?= $nd->pregunta ?></div>
                            <div class="faqgoanswers">
                                <span><?=$lib->fechainexacta($nd->fecha)?></span>
                                <a href="<?= $this->getURL(LANG . "support/faqs/" . $nd->id ) ?>"><?= __("txtviewanswers") ?></a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <!--questions-->
        <div class="faqdettab">
            <?php
            if (count($nodes) > 0) {
                foreach ($nodes as $nd) {
                    ?>
                    <div class="itempregunta">
                        <?php
                                if($params["esadmin"]){
                                    echo '<div class="faqdel" alt="'.$nd->id.'">x</div>';
                                }
                                ?>
                        <a class="faqavatar" target="_blank" href="<?= $usuarios["x" . $nd->idusuario]["profile_url"] ?>">
                            <img src="<?= $usuarios["x" . $nd->idusuario]["pic_square"] ?>"/>
                        </a>
                        <div class="picopregunta"></div>
                        <div class="faqsetpregunta">
                            <div class="faqcuadropregunta"><?= $nd->pregunta ?></div>
                            <div class="faqgoanswers">
                                <span><?=$lib->fechainexacta($nd->fecha)?></span>
                                <a href="<?= $this->getURL(LANG . "support/faqs/" . $nd->id ) ?>"><?= __("txtviewanswers") ?></a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <!--ask-->
        <div class="faqdettab">
            <form action="" method="post" id="frmfaqpregunta">
                <a class="faqavatar" target="_blank" href="<?= $_SESSION["fbconexion"]["link"] ?>">
                    <img src="<?= ($_SESSION["fbconexion"]["photo"] ? $_SESSION["fbconexion"]["photo"] : $this->getURL("images/img_avatar-faq.png")) ?>"/>
                </a>
                <div class="picopregunta"></div>
                <div class="faqsetpregunta">
                    <label><?= __("txtyourquestions") ?></label>
                    <input type="text" id="faqsettitle" name="faqsettitle" />
                    <label><?= __("txtdescription") ?></label>
                    <textarea id="faqsetdescripcion" name="faqsetdescripcion"></textarea>
                </div>
                <input type="submit" id="faqsetsubmit" value="<?= __("btnpublish") ?>" />
            </form>
        </div>
    </div>
    <div id="faqcol2"><?= $this->loadView("support_sidebar.php") ?></div>
</div>
<script type="text/javascript">
    $(".faqlbltab").Dtabs(".faqdettab");
    logged=<?=$_SESSION["fbconexion"]?'true':'false'?>;
    <?php
            if($params["esadmin"]){
                ?>
                    $(".faqdel").click(function(){
                        esto=this;
                        $.ajax({
                            url:"<?=$this->getURL(LANG."support/faqs/")?>",
                            type:"POST",
                            data:"accion=delfaq1&id="+$(this).attr("alt"),
                            success:function(data){
                                $(esto).parent().fadeOut(450, function(){});
                            }
                        })
                    })
                <?php
            }
            ?>
    $("#frmfaqpregunta").submit(function(){
        if($("#faqsettitle").val()==""){
            $( "#faqsettitle" ).effect( "highlight", {}, 500, function(){});
            return false;
        }else{
            if(logged==false){
                $.ajax({
                    url:"<?= $this->getURL("checkSession/0") ?>",
                    success:function(data){
                        if(data.indexOf("false")==-1){
                            logged=true;
                            $("#frmfaqpregunta").submit();
                        }else{
                            logged=false;
                            FB.login(function(response){
                                if (response.status === 'connected'){ 
                                    $.ajax({
                                        url:"<?= $this->getURL("doSession") ?>",
                                        success:function(data){
                                            logged=true;
                                            $("#frmfaqpregunta").submit();
                                        }
                                    })
                                }
                            });
                        }
                    }
                },{
                            "scope":"manage_pages,user_likes,offline_access,publish_stream,email"
                        })
                return false;
            }
        }
    })
</script>