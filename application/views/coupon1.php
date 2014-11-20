<?php
$r = $params["data"];
if (trim($r->topbarcolor) == "" || !$r->topbarcolor)
    $r->{topbarcolor} = "";
if (trim($r->couponscolor) == "" || !$r->couponscolor)
    $r->{couponscolor} = "";
if (trim($r->buttoncolor) == "" || !$r->buttoncolor)
    $r->{buttoncolor} = "";
?>
<div style="float:left; clear:both; width:850px;">
    <div id="coucol1" class="<?= (LANG == "en/" ? "" : "acomspan") ?>">
        <form name="frmcoupaso1" id="frmcoupaso1" action="" method="post" >
            <div id="coutitle"><?= __("titcoupongenerator") ?></div>
            <div class="cousubtitle"><?= __("titpageinfo") ?></div>
            <div class="coucuadroform">
                <div class="coufila">
                    <label><?= __("lblpagetitle") ?></label>
                    <input type="text" name="cou1" id="cou1" class="required" value="<?= urldecode($r->pagetitle) ?>"/>
                </div>
                <div class="coufila">
                    <label><?= __("lblpagedesc") ?></label>
                    <div style="float:left">
                        <textarea name="cou2" id="cou2"><?= urldecode($r->pagedesc) ?></textarea>
                    </div>
                </div>
            </div>
            <div class="coubotoneranext">
                <input type="submit" id="btnsubmit" value="<?= __("btnnext") ?>" />
                <a href="#" id="btncustomize"><?= __("titcolorcustom") ?></a>
            </div>
            <div class="coucuadroform" style="margin-top: 10px;">
                <div class="coufila coufila1">
                    <label><?= __("lbltopbarcolor") ?></label>
                    <input type="text" class="pasetcolor" id="cou3_1" name="cou3_1" class="required pacolor" value="<?= urldecode($r->topbarcolor) ?>" />
                </div>
                <div class="coufila coufila2">
                    <label><?= __("lblfont") ?></label>
                    <input type="text" class="pasetcolor" id="cou3_4" name="cou3_4" class="required pacolor" value="<?= urldecode($r->topbarfont) ?>" />
                </div>
                <div class="coufila coufila1">
                    <label><?= __("lblcouponscolor") ?></label>
                    <input type="text" class="pasetcolor" id="cou3_2" name="cou3_2" class="required pacolor" value="<?= urldecode($r->couponscolor) ?>" />
                </div>
                <div class="coufila coufila2">
                    <label><?= __("lblfont") ?></label>
                    <input type="text" class="pasetcolor" id="cou3_5" name="cou3_5" class="required pacolor" value="<?= urldecode($r->couponsfont) ?>" />
                </div>
                <div class="coufila coufila1">
                    <label><?= __("lblbuttoncolor") ?></label>
                    <input type="text" class="pasetcolor" id="cou3_3" name="cou3_3" class="required pacolor" value="<?= urldecode($r->buttoncolor) ?>" />
                </div>
                <div class="coufila coufila2">
                    <label><?= __("lblfont") ?></label>
                    <input type="text" class="pasetcolor" id="cou3_6" name="cou3_6" class="required pacolor" value="<?= urldecode($r->buttonfont) ?>" />
                </div>
            </div>
        </form>
    </div>
    <div id="coucol2">
        <img src="<?= $this->getURL("images/preview-coupon1.png") ?>" alt="" />
    </div>
</div>
<div id="coudialogo">
</div>
<script type="text/javascript">
    $("#frmcoupaso1").formValidator({
        onValidated:function(data){
            if(data!=""){
                $("#coudialogo").html(data);
                $("#coudialogo").dialog({
                    title:"<?= __("titalert") ?>",
                    modal:true,
                    buttons: { }
                })
            }
        }
    });
    $.getScript("http://www.tinymce.com/js/tinymce/jscripts/tiny_mce/tiny_mce.js", function(){
        tinyMCE.init({
            // General options
            mode : "textareas",
            theme : "advanced",
            //plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,imagemanager,filemanager",
            theme_advanced_toolbar_location : "top",
            theme_advanced_toolbar_align : "left",
            theme_advanced_buttons1:"bold,italic,underline,|,justifyleft,justifycenter,justifyright,justifyfull",
            theme_advanced_buttons2:"",
            theme_advanced_buttons3:"",
            force_br_newlines : true,
            force_p_newlines : false,
            forced_root_block : '' // Needed for 3.x
        });
    })
    $("#btncustomize").click(function(){
        $(".coucuadroform:last").slideToggle(450, function(){});
    });
    $('.pasetcolor').ColorPicker({
        onSubmit: function(hsb, hex, rgb, el) {
            $(el).val("#"+hex);
            $(el).ColorPickerHide();
        },
        onBeforeShow: function () {
            $(this).ColorPickerSetColor(this.value);
        }
    })
    
</script>