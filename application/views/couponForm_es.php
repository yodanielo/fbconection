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
                if ($r->Títiulo != "")
                    echo $r->Títiulo;
                else
                    echo "Título del cupón";
                ?>
            </span>
        </div>
        <div class="coucuadroform couitemblanco">
            <div class="cibrow">
                <label>Imágen de la Oferta</label>
                <input id="<?= $marca . "-1" ?>" type="text" alt="Imágen de la Oferta" class="cibinput cib1 pafmanager paurl" value="<?= $r->offerimage ?>" />
            </div>
            <div class="cibrow cibrow2">
                <label>Código de Barras</label>
                <input id="<?= $marca . "-2" ?>" type="text" alt="Código de Barras" class="cibinput cib2 pafmanager paurl"  value="<?= $r->barcode ?>"/>
            </div>
            <div class="cibrow">
                <label>Títiulo</label>
                <input id="<?= $marca . "-3" ?>" type="text" alt="Títiulo" class="cibinput cib3" value="<?= $r->Títiulo ?>" />
            </div>
            <div class="cibrow cibrow2">
                <label>Resumen</label>
                <input id="<?= $marca . "-4" ?>" type="text" alt="Resumen" class="cibinput cib4" value="<?= $r->shortdescription ?>" />
            </div>
            <div class="cibrow">
                <label>Descripción Completa</label>
                <div style="float:left"><textarea id="<?= $marca . "-5" ?>" alt="Descripción Completa" class="cibinput cib5 continy"><?= $r->fulldescription ?></textarea></div>
            </div>
            <div class="cibrow cibrow2">
                <label>Fecha de Inicio</label>
                <input id="<?= $marca . "-6" ?>" type="text" alt="Fecha de Inicio" class="cibinput cib6 pacalendar" value="<?= $f1[1] . "-" . $f1[2] . "-" . $f1[0] ?>" />
            </div>
            <div class="cibrow cibrow2">
                <label>Fecha de Fin</label>
                <input id="<?= $marca . "-7" ?>" type="text" alt="Fecha de Fin" class="cibinput cib7 pacalendar" value="<?= $f2[1] . "-" . $f2[2] . "-" . $f2[0] ?>" />
            </div>
            <div class="cibrow cibrow2">
                <label>Cupones disponibles</label>
                <input id="<?= $marca . "-8" ?>" type="text" alt="Cupones" class="cibinput cib8" value="<?= $r->numcoupons ?>" />
            </div>
            <div class="cibrow">
                <label>Términos y Condiciones</label>
                <div style="float:left"><textarea id="<?= $marca ?>-10" class="cibinput cib10 continy"><?= $r->termsandconditionsarea ?></textarea></div>
            </div>
            <div class="cibrow cibrow2">
                <label>Términos y Condiciones</label>
                <input id="<?= $marca . "-9" ?>" type="text" alt="Términos y Condiciones" class="cibinput cib9 pafmanager paurl" value="<?= $r->termsandconditions ?>" />
            </div>
            <div class="cibrow cibrow2">
                <label>Oferta solo disponible para fans</label>
                <select id="<?= $marca . "-11" ?>" class="cibinput cib11">
                    <option value="0" <?= ($r->premium == 0 ? "selected" : "") ?>>No</option>
                    <option value="1" <?= ($r->premium == 1 ? "selected" : "") ?>>Yes</option>
                </select>
            </div>
            <div class="cibrow cibrow2">
                <input type="submit" class="cibinput cibsubmit" value="Guardar" />
            </div>
        </div>
        <input type="hidden" class="cibinput couponitem couponid" value="<?= $r->id ?>" />
    </form>
</div>
<script type="text/javascript">
    $("#<?= $marca ?>").couponValidator();
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
        setTimeout(iniciartiny<?=$marca?>, 1000);
    }
</script>