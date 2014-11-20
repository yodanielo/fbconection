<?php
$esapp = $params["esapp"];
$plan = array("", "Free", "Profesional", "Premium");

function buscar_upgrade($upg, $page) {
    $cp = $_SESSION["fbconexion"]["idplan"];
    if (count($upg) > 0) {
        foreach ($upg as $u) {
            if ($u->id_pagina == $page)
                return "icospeed_$cp";
            elseif($_SESSION["fbconexion"]["INTROFB"])
                return "icospeed_4";
        }
        return "icospeed_1";
    }
    else {
        return "icospeed_1";
    }
}
?>
<div id="bodyintranet" style="position:relative;<?= ($esapp ? "width:640px;" : "background:url(../images/marca-de-agua-" . $_SESSION["lang"] . ".png) no-repeat") ?>">
    <div id="propagandatop">
                <?php if (LANG == "es/") {
                    ?>
                    <script type="text/javascript"><!--
                        google_ad_client = "ca-pub-6445767890570319";
                        /* S 120 90-1 fb editor */
                        google_ad_slot = "9612179099";
                        google_ad_width = 120;
                        google_ad_height = 90;
                        //-->
                    </script>
                    <script type="text/javascript"
                            src="http://pagead2.googlesyndication.com/pagead/show_ads.js ">
                    </script>
                    <?php
                } else {
                    ?>
                    <script type="text/javascript"><!--
                        google_ad_client = "ca-pub-6445767890570319";
                        /* 120 90 - 2 Fb editor */
                        google_ad_slot = "6268874469";
                        google_ad_width = 120;
                        google_ad_height = 90;
                        //-->
                    </script>
                    <script type="text/javascript"
                            src="http://pagead2.googlesyndication.com/pagead/show_ads.js ">
                    </script>
                    <?php } ?>
            </div>
    <div id="contselectedplan">
        <div id="selectplan">
            <div id="selectedplan"><?= $plan[$_SESSION["fbconexion"]["idplan"]] ?></div>
            <div id="optionsplan">
                <?php
                if (count($plan) > 0)
                    foreach ($plan as $key => $p) {
                        if ($key > $_SESSION["fbconexion"]["idplan"]) {
                            echo '<a href="' . $this->getURL(LANG . "upgrade/index/$key") . '">' . $p . '</a>';
                        }
                    }
                ?>
            </div>
        </div>
    </div>
    <div id="numfrepags">
        <?php
        if ($_SESSION["fbconexion"]["idplan"] != 1) {
            if (intval($params["freepremium"]) < 0)
                $params["freepremium"] = 0;
            switch ($params["freepremium"] * 1) {
                case 0:
                    echo __("therearenopages");
                    break;
                case 1:
                    echo __("thereisonepage");
                    break;
                default:
                    echo str_replace("{uno}", $params["freepremium"], __("thereareanypages"));
            }
        }
        ?>
        <input type="hidden" id="numpagshid" value="<?= $params["freepremium"] * 1 ?>"/>
    </div>
    <div id="contpages">
        <?php
        if (count($params["pags"]) > 0)
            foreach ($params["pags"] as $p) {
                ?>
                <div class="barranaranja" id="page<?= $p["page_id"] ?>">
                    <a target="_parent" title="Public Relationship Manager" class="icomensaje" href="<?= $this->getURL(LANG . "communicationManager/index/" . $p["page_id"]) ?>"></a>
                    <div title="<?= __("ttclicktoupgrade") ?>" class="<?= buscar_upgrade($params["upgraded"], $p["page_id"]) ?>"></div>
                    <label><?= $p["name"] ?></label>
                </div>
                <div class="barrazul">
                    <?php
                    if (count($params["tabs"]) > 0) {
                        foreach ($params["tabs"] as $t) {
                            if ($t->idpagina == $p["page_id"]) {
                                ?>
                                <div class="baitem" id="tab<?= $t->id ?>">
                                    <a target="_parent" class="baedit" href="<?php
                    if ($t->idapp != 10)
                        echo $this->getURL(LANG . "fbconexion/page/" . $t->id);
                    else
                        echo $this->getURL(LANG . "fbconexion/coupon/" . $t->id);
                                ?>" title="Edit"><img src="<?= $this->getURL("images/ico_editar.png") ?>" alt=""/></a>
                                    <a class="badel" href="#" id="badel_<?= $t->id ?>" title="Delete"><img src="<?= $this->getURL("images/ico_eliminar.png") ?>" alt=""/></a>
                                    <label><?= $t->nombreapp ?></label>
                                </div>
                                <?php
                            }
                        }
                    }
                    ?>
                    <div class="baitem banew">
                        <form class="frm_banew" id="frm_<?= $p["page_id"] ?>" action="#" method="post">
                            <select class="cboapps" style="margin-top:2px;">
                                <?php
                                foreach ($params["apps"] as $a) {
                                    if ($a->id == 10 || $a->id == 31)
                                        echo '<option title="' . $this->getURL("images/ico_star.png") . '" value="' . $a->id . '">' . $a->nombre . '</option>';
                                    else
                                        echo '<option value="' . $a->id . '">' . $a->nombre . '</option>';
                                }
                                ?>
                            </select>
                            <input title="<?= __("txtaddanewtab") ?>" type="image" src="<?= $this->getURL("images/ico_add.png") ?>" class="btn_banew" />
                        </form>
                    </div>
                </div>
                <?php
            }
        ?>
    </div>
    <a id="btnnewpage" target="<?= $esapp ? "_blank" : "_parent" ?>" href="http://www.facebook.com/pages/create.php"><?= __('titnewpage') ?></a>
</div>
<div id="alertbox"></div>
<script type="text/javascript">
    $( "#contpages" ).accordion({
        autoHeight: false,
        navigation: true,
        header:'.barranaranja',
        dearStyle:true
        //event: "mouseover"
    });
    $(".icomensaje").click(function(){
<?= ($esapp ? "top" : "window") ?>.location.href=$(this).attr("href");
        return false;
    })
    $(".icospeed_4,.icospeed_1,.icospeed_2,.icospeed_3,.icospeed_0").click(function(){
        pagina=$(this).parent().attr("id").split("page").join("");
        todo=this;
        nump=parseInt($("#numfrepags input").val());
        if(nump>0){
            $.getJSON("<?= $this->getURL(LANG . "upgrade/dopago/") ?>"+pagina, "", function(data){
                $('#alertbox').html(data.msg)
                $("#alertbox").dialog({
                    title:"<?= __("titalert") ?>",
                    modal:true,
                    buttons: {
                        "ok":function(){
                            $("#alertbox").dialog("close");
                        }
                    }
                });
                if(data.estado!=-1){
                    $(todo).removeClass().addClass("icospeed_"+data.estado);
                    nump--;
                    $("#numfrepags input").val(nump);
                    $("#numfrepags span").html(nump);
                }
                else{
                }
            });
        }
    });
    $(".frm_banew").each(function(){
        $(this).submit(function(){
            if($(this).find(".cboapps").val()!=""){
                idpag=$(this).attr("id").split("frm_").join("");
                $.ajax({
                    url:"<?= $this->getURL(LANG . "fbconexion/addTab/") ?>"+idpag,
                    data:"idapp="+parseInt($(this).find(".cboapps").val()),
                    type:"POST",
                    success:function(data){
                        if(data.indexOf("nada de tabs")>-1){
                            $("#alertbox").html("<?= __("txtyoucantcreate") ?>");
                            $("#alertbox").dialog({
                                "title":"<?= __("titalert") ?>",
                                modal:true,
                                buttons:{
                                    "ok":function(){
                                        $("#alertbox").dialog("close");
                                    }
                                }
                            })
                        }else{
                            <?php
                            //aqui devuelve el ID de la nueva pagina y la redirige al editor
                            ?>
                            <?= ($esapp ? "top" : "window") ?>.location.href=data;
                        }
                    }
                });
            }
            return false
        })
    })
    $(".badel").click(function(){
        r=$(this).attr("id").split("badel_").join("");
        todo=$(this).parent();
        $.ajax({
            url:"<?= $this->getURL(LANG . "fbconexion/deletePage/") ?>"+r,
            type:"POST",
            success:function(data){
                if(data.indexOf("ok")>-1){
                    $(todo).fadeOut(450, function(){
                        $(todo).remove();
                    })
                }
            }
        });
        return false;
    })
    $(document).ready(function(){
        $("select").msDropDown();
    })
    function aaa(){
        //document.title=Math.round(Math.random()*10000);
        fleXenv.updateScrollBars();
        setTimeout(aaa, 300);
    }
    setTimeout(aaa, 300);
</script>