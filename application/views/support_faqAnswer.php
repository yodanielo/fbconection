<?php
$lib=$this->loadLib("textlibs");
$faq = $params["faq"];
$des = $params["answer"];
$usuarios = $params["usuarios"];
$lib = $this->loadLib("textlibs");
?>
<div class="wrappersup" style="min-height:542px;">
    <div id="faqcol1">
        <a class="btnbackfaq" href="javascript:history.back();">&lt; <?= __("txtback") ?></a>
        <div class="itempregunta" style="margin-top:20px;">
            <a class="faqavatar" target="_blank" href="<?= ($faq->destacada == 1 ? $this->getURL("") : $usuarios["x" . $faq->idusuario]["profile_url"]) ?>">
                <img src="<?= ($faq->destacada == 1 ? "https://graph.facebook.com/1418715186/picture" : $usuarios["x" . $faq->idusuario]["pic_square"]) ?>"/>
            </a>
            <div class="picopregunta"></div>
            <div class="faqsetpregunta">
                <div class="faqcuadropregunta">
                    <div><?= $faq->pregunta ?></div>  
                    <div class="faqcuadrodescripcion"><?= $faq->descripcion ?><div class="faqfechapreg">
                                        <?=$lib->fechainexacta($r->fecha)?>
                                    </div></div>
                </div>
            </div>
        </div>
        <div id="cuerporpt">
            <?php
            if (count($des) > 0) {
                foreach ($des as $r) {
                    ?>
                    <div class="itemrespuesta">
                        <?php
                                if($params["esadmin"]){
                                    echo '<div class="faqdel" alt="'.$r->id.'">x</div>';
                                }
                                ?>
                        <a class="faqavatar" target="_blank" href="<?= ($faq->destacada == 1 ? $this->getURL("") : $usuarios["x" . $r->idusuario]["profile_url"]) ?>">
                            <img src="<?= ($faq->destacada == 1 ? $this->getURL("images/img_avatar-faq.png") : ($_SESSION["fbconexion"]?$usuarios["x" . $r->idusuario]["pic_square"]:$this->getURL("images/img_avatar-faq.png"))) ?>"/>
                        </a>
                        <div class="picorespuesta"></div>
                        <div class="faqsetrespuesta">
                            <?php
                            if ($r->idusuario == $_SESSION["fbconexion"]["uid"] && $faq->escerrado != "1" && $faq->destacada != "1")
                                echo '<div class="btndelete" id="rpt' . $r->id . '">x</div>';
                            ?>
                            <div class="faqcuadropregunta"><?= $lib->toLinks(urldecode($r->respuesta)) ?><div class="faqfechapreg">
                                        <?=$lib->fechainexacta($r->fecha)?>
                                    </div></div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <?php if ($faq->escerrado == 0) { ?>
            <div class="itemrespuesta">
                <form action="" method="post" id="frmsetrespuesta">
                    <a class="faqavatar" target="_blank" href="<?= $_SESSION["fbconexion"]["link"] ?>">
                        <img src="<?= ($_SESSION["fbconexion"]["photo"] ? $_SESSION["fbconexion"]["photo"] : $this->getURL("images/img_avatar-faq.png")) ?>"/>
                    </a>
                    <div class="picorespuesta"></div>
                    <div class="faqsetrespuesta">
                        <textarea id="faqsetrespuesta" name="faqsetrespuesta" class="faqcuadrorespuesta"></textarea>
                    </div>
                </form>
            </div>
        <?php } ?>
    </div>
    <div id="faqcol2"><?= $this->loadView("support_sidebar.php") ?></div>
</div>
<script type="text/javascript">
    <?php
            if($params["esadmin"]){
                ?>
                    $(".faqdel").click(function(){
                        esto=this;
                        $.ajax({
                            url:"<?=$this->getURL(LANG."support/faqs/")?>",
                            type:"POST",
                            data:"accion=delfaq2&id="+$(this).attr("alt"),
                            success:function(data){
                                $(esto).parent().fadeOut(450, function(){});
                            }
                        })
                    })
                <?php
            }
            ?>
<?php if ($faq->escerrado == 0) { ?>
        logged=<?= $_SESSION["fbconexion"] ? 'true' : 'false' ?>;
        btndelete_click=function(){
            $.ajax({
                url:"<?= $this->getURL(LANG . "support/delAnswer/") ?>"+$(this).attr("id").split("rpt").join(""),
                success:function(data){
                    $('<div id="faqbox">'+data+'</div>').dialog({
                        title:"<?= __("titalert") ?>",
                        modal:true,
                        buttons: { }
                    });
                }
            });
            $(this).parent().parent().fadeOut(450, function(){});
        }
        $(".btndelete").click(btndelete_click);
        hacerresp=function(){
            if(logged){
                $.ajax({
                    url:"<?= $this->getURL(LANG . "support/setAnswer/$faq->id") ?>",
                    type:"POST",
                    data:"contenido="+encodeURIComponent($("#faqsetrespuesta").val()),
                    success:function(data){
                        $("#cuerporpt").append(data);
                        $('#faqsetrespuesta').html("");
                        $('#faqsetrespuesta').empty();
                        $('#faqsetrespuesta').val("");
                        $(".btndelete:last").click(btndelete_click);
                    }
                })
            }
        }
        $("#frmsetrespuesta").submit(function(){
            if($("#faqsetrespuesta").val()==""){
                $( "#faqsetrespuesta" ).effect( "highlight", {}, 500, function(){});
            }
            else{
                if(logged==false){
                    $.ajax({
                        url:"<?= $this->getURL("checkSession/0") ?>",
                        success:function(data){
                            if(data.indexOf("false")==-1){
                                logged=true;
                                hacerresp();
                            }else{
                                logged=false;
                                FB.login(function(response){
                                    if (response.status === 'connected'){ 
                                        $.ajax({
                                            url:"<?= $this->getURL("doSession") ?>",
                                            success:function(data){
                                                logged=true;
                                                hacerresp();
                                            }
                                        })
                                    }
                                },{
                            "scope":"manage_pages,user_likes,offline_access,publish_stream,email"
                        });
                            }
                        }
                    })
                    return false;
                }
            }
            return false;

        })
        $('#faqsetrespuesta').keydown(function (e) {
            if (e.keyCode == 13) {
                if(e.ctrlKey){
                    $(this).val($(this).val()+"\n");
                }else{
                    $("#frmsetrespuesta").submit();
                    return false;
                }
            }
        });
        $("#faqsetrespuesta").autogrow();
<?php } ?>
    
</script>