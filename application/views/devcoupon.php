<?php
$r = $params["tab"];
$settings = json_decode($r->set1);
$mast=0;
if ($params["espremium"] ==0)
    $mast=28;
if ($params["admin"] == 1)
    $mast=28;
?>
<style type="text/css">
    .couponitem{
        background-color:<?= urldecode($settings->couponscolor) ?>!important;
    }
    .coubtnsubmit{
        background-color: <?= urldecode($settings->buttoncolor) ?>!important;
        color:<?=urldecode($settings->buttonfont)?>!important;
    }
    #coutitlepage *{
        color:<?=urldecode($settings->topbarfont)?>!important;
    }
    .citexto *{
        color:<?=urldecode($settings->couponsfont)?>!important;
    }
</style>
<div id="coutitlepage" style="background: <?= urldecode($settings->topbarcolor) ?>; margin-top:<?=$mast?>px;">
    <div id="cptitle"><?= urldecode($settings->pagetitle) ?></div>
    <div id="cpdesc"><?= urldecode($settings->pagedesc) ?></div>

</div>
<div id="coucontentcoupons">
    <?php
    $this->loadController("tabs")->pagcoupon1($params["tab"]->id);
    ?>
</div>
<div id="coufooterpage" style="height:15px;background: <?= urldecode($settings->topbarcolor) ?>">
    
</div>
<?php
if ($params["liked"] != 1) {
    ?>
    <script type="text/javascript">
        function hacerpremium(){
            if($(".neddpremium .coverpremium").length==0)
                $(".neddpremium").prepend('<div class="coverpremium"><span>You should be a fan to access this offer.</span></div>');
            $(".coverpremium").each(function(){
                $(this).height($(this).parent().height()+20);
            });
            $(".neddpremium .coubtnsubmit").remove();
            setTimeout(hacerpremium, 100);
        }
        hacerpremium();
    </script>
    <?php
}
?>