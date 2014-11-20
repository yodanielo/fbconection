<?php
$r = $this->params["coupon"];
?>
<div id="coupontop">
    <a href="#" id="coubacklist"><img src="<?= $this->getURL("images/ico_atras.png") ?>"/></a>
    <a href="#" id="printthis"><img src="<?= $this->getURL("images/ico_print.png") ?>"/></a>
</div>
<div id="coucuadrocupon">
    <div id="coutitledet"><?= $r->title ?></div>
    <div id="couimagedet">
        <img src="<?= "http://" . $r->offerimage ?>"/>
    </div>
    <div id="coutextodet">
        <div id="cousdescdet"><?= strip_tags($r->shortdescription) ?></div>
        <div id="coufdescdet"><?= $r->fulldescription ?></div>
        <div id="couexpiresdet">This coupon expires: <?= $r->fechatext ?></div>
    </div>
    <?php
    if ($r->barcode != "") {
        ?>
        <div id="couponbarcode">
            <img src="http://<?= $r->barcode ?>"/>
        </div>
        <?php
    }
    ?>
</div>
<?php if (trim($r->termsandconditions)!="") {
    echo '<div id="coutermsdet1"><a target="_blank" href="http://'.$r->termsandconditions.'">Terms and Conditions</a></div>';
} else {
    echo '<div id="coutermsdet2"><strong>Terms and Conditions</strong><p>'.nl2br($r->termsandconditionsarea).'</p></div>';
}
?>
<script type="text/javascript">
    $("#coubacklist").click(function(){
        $.ajax({
            url:"<?= $this->getURL("tabs/pagcoupon1/" . $r->idtab) ?>",
            success:function(data){
                $("#coucontentcoupons").html(data);
            }
        });
    });
    $("#printthis").click(function(){
        $("#coutitlepage, #coupontop, #coutermsdet").hide();
        window.print();
        $("#coutitlepage, #coupontop, #coutermsdet").show();
    })
    $.ajax({
        url:"/tabs/printcoupon/<?=$r->id?>",
        success:function(data){
            
        }
    })
</script>