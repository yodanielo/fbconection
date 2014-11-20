<?php
$r = $params["registro"];
$marca = "frm" . rand(0, 400000) . mktime();
$f1 = explode("-", $r->startdate);
$f2 = explode("-", $r->enddate);
?>
<div class="couponitem" id="<?= $marca ?>">
    <form class="frmcouitem" action="#" method="post">
        <div class="cousubtitle">
            <div class="btn_delcou"></div>
            <span>
                <?php
                if ($r->title != "")
                    echo $r->title;
                else
                    echo "Coupon Title";
                ?>
            </span>
        </div>
        <div class="coucuadroform couitemblanco">
            <div class="cibrow">
                <label>Offer Image</label>
                <input id="<?= $marca . "-1" ?>" type="text" alt="Offer Image" class="cibinput cib1 pafmanager paurl" value="<?= $r->offerimage ?>" />
            </div>
            <div class="cibrow cibrow2">
                <label>Bar Code</label>
                <input id="<?= $marca . "-2" ?>" type="text" alt="Bar Code" class="cibinput cib2 pafmanager paurl"  value="<?= $r->barcode ?>"/>
            </div>
            <div class="cibrow">
                <label>Title</label>
                <input id="<?= $marca . "-3" ?>" type="text" alt="Title" class="cibinput cib3" value="<?= $r->title ?>" />
            </div>
            <div class="cibrow cibrow2">
                <label>Short description</label>
                <input id="<?= $marca . "-4" ?>" type="text" alt="Short description" class="cibinput cib4" value="<?= $r->shortdescription ?>" />
            </div>
            <div class="cibrow">
                <label>Full description</label>
                <div style="float:left"><textarea id="<?= $marca . "-5" ?>" alt="Full description" class="cibinput cib5 continy"><?= $r->fulldescription ?></textarea></div>
            </div>
            <div class="cibrow cibrow2">
                <label>Start date</label>
                <input id="<?= $marca . "-6" ?>" type="text" alt="Start date" class="cibinput cib6 pacalendar" value="<?= $f1[1] . "-" . $f1[2] . "-" . $f1[0] ?>" />
            </div>
            <div class="cibrow cibrow2">
                <label>End date</label>
                <input id="<?= $marca . "-7" ?>" type="text" alt="End Date" class="cibinput cib7 pacalendar" value="<?= $f2[1] . "-" . $f2[2] . "-" . $f2[0] ?>" />
            </div>
            <div class="cibrow cibrow2">
                <label>Coupons Available</label>
                <input id="<?= $marca . "-8" ?>" type="text" alt="Coupons" class="cibinput cib8" value="<?= $r->numcoupons ?>" />
            </div>
            <div class="cibrow">
                <label>Terms and Conditions</label>
                <div style="float:left"><textarea id="<?= $marca ?>-10" class="cibinput cib10 continy"><?= $r->termsandconditionsarea ?></textarea></div>
            </div>
            <div class="cibrow cibrow2">
                <label>Terms and Conditions</label>
                <input id="<?= $marca . "-9" ?>" type="text" alt="Terms and Conditions" class="cibinput cib9 pafmanager paurl" value="<?= $r->termsandconditions ?>" />
            </div>
            <div class="cibrow cibrow2">
                <label>Offer only available for fans</label>
                <select id="<?= $marca . "-11" ?>" class="cibinput cib11">
                    <option value="0" <?= ($r->premium == 0 ? "selected" : "") ?>>No</option>
                    <option value="1" <?= ($r->premium == 1 ? "selected" : "") ?>>Yes</option>
                </select>
            </div>
            <div class="cibrow cibrow2">
                <input type="submit" class="cibinput cibsubmit" value="Save" />
            </div>
        </div>
        <input type="hidden" class="cibinput couponitem couponid" value="<?= $r->id ?>" />
    </form>
</div>
<script type="text/javascript">
    iniciartiny<?= $marca ?>=function(){
        tinyMCE.init({
            // General options
            mode : "exact",
            elements:"<?= $marca ?>-5,<?= $marca ?>-10",
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
        $("#<?= $marca ?>").couponValidator();
    }
    setTimeout(iniciartiny<?=$marca?>, 1000);

</script>