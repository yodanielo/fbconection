<?php
$res = $params["cupones"];
if (count($res) > 0) {
    foreach ($res as $r) {
        ?>
        <div class="couponitem<?=($r->premium==1?" neddpremium":"")?>">
            <form action="" method="post">
                <div class="couimage">
                    <?php if($r->offerimage){ ?>
                    <img src="<?= "http://" . strip_tags($r->offerimage) ?>" alt="<?= strip_tags($r->title) ?>" />
                    <?php } ?>
                </div>
                <div class="citexto">
                    <h2><?= $params["liked"].strip_tags($r->title) ?></h2>
                    <p><?= strip_tags($r->shortdescription) ?></p>
                    <input type="hidden" class="idof" value="<?= $r->id ?>" />
                </div>
                <input type="submit" class="coubtnsubmit" value="View details" />
            </form>
        </div>
        <?php
    }
    ?>
    <script type="text/javascript">
        $(".couponitem form").submit(function(){
            $.ajax({
                url:"<?= $this->getURL("tabs/pagcoupon2/") ?>"+$(this).find(".idof").val(),
                success:function(data){
                    $("#coucontentcoupons").html(data);
                }
            });
            return false;
        });
    </script>
    <?php
}
?>