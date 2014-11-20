<?php
$c = $params["tab"];
$res = $params["coupons"];
?>
<a target="_blank" href="" id="urlface"></a>
<div style="float:left; clear:both; width:850px;">
    <div id="coucol1">
        <div id="coutitle"><?= __("titcoupongenerator") ?></div>
        <div id="contcupones">
            <?php
            if (count($res) > 0)
                foreach ($res as $r) {
                    $par = array("registro" => $r);
                    $this->loadView("couponForm_" . $_SESSION["lang"] . ".php", $par);
                }
            ?>
        </div>
        <div class="cousubtitle"><div id="btnaddcoupon"></div><?= __("btnaddcoupon") ?></div>
        <div class="coubotoneranext">
            <a id="btnsubmit" href="#"><?= __("btnpublish") ?></a>
            <a id="btnback" href="<?= $this->getURL("/" . LANG . "fbconexion/coupon/" . $c->id) ?>"><?= __("btnback") ?></a>
        </div>
    </div>
    <div id="coucol2">
        <img src="<?= $this->getURL("images/preview-coupon2.png") ?>" alt="" />
    </div>
</div>    
<div style="display:none">
    <div id="coudialogo">
    </div>
</div>
<script type="text/javascript">
    idtab="<?= $c->id ?>";
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
    $("#btnaddcoupon").click(function(){
        $.ajax({
            url:"<?= $this->getURL(LANG . "coupon/add") ?>",
            success:function(data){
                $("#contcupones").prepend(data);
            }
        });
    });
    $("#urlface").click(function(){
    
    });
    $("#btnsubmit").click(function(){
        $.ajax({
            url:"<?= $this->getURL(LANG . "coupon/publish/" . $c->id) ?>",
            success:function(data){
                $("#coudialogo").html('<div style="text-align:center;">&nbsp;<br/><br/><?= __("txtclicking") ?></div>'.split("{here}").join(data));
                $("#coudialogo").dialog({
                    "title":"<?= __("titalert") ?>",
                    "modal":true,
                    buttons: { }
                });
            }
        });
    });
</script>