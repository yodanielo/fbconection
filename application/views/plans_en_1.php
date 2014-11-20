<div id="contplans">
    <div class="planitem" id="plan1">
        <h2>Personal</h2>
        <div class="plansize">1Mb</div>
        <div class="planchars">
            Drag and Drop Designer<br/>
            Public Relationship Manager<br/>
            Coupon Manager<br/>
            FBConexion Logo<br/>
            Full access to ALL the widgets<br/>
            1 Facebook Fan Page<br/>
            1 tab
        </div>
        <div class="planpresfree">Free</div>
    </div>
    <div class="planitem" id="plan2">
        <div class="planbtnupgrade" id="buy2">Buy Now</div>
        <h2>Professional</h2>
        <div class="plansize">25Mb</div>
        <div class="planchars">
            Drag and Drop Designer<br/>
            Public Relationship Manager<br/>
            Coupon Manager<br/>
            FBConexion Logo<br/>
            Full access to ALL the widgets<br/>
            1 Facebook Fan Page<br/>
            unlimited tabs
        </div>
        <div class="planprebig"><span>$</span>99.99<span>/yr</span></div>
        <div class="planpresmall"><span>$</span>9.99<span>/mo</span></div>
    </div>
    <div class="planitem" id="plan3">
        <div class="planbtnupgrade" id="buy3">Buy Now</div>
        <h2>Premium</h2>
        <div class="plansize">50Mb</div>
        <div class="planchars">
            Drag and Drop Designer<br/>
            Public Relationship Manager<br/>
            Coupon Manager<br/>
            No FBConexion Logo<br/>
            Full Access to ALL the widgets<br/>
            3 Facebook Fan Page<br/>
            unlimited tabs
        </div>
        <div class="planprebig"><span>$</span>299.99<span>/yr</span></div>
        <div class="planpresmall"><span>$</span>29.99<span>/mo</span></div>
    </div>
    <div class="planitem" id="plan4">
        <div class="planbtnupgrade" id="buy4">Contact Us</div>
        <h2>Professional Design</h2>
        <div class="planchars">
            &nbsp;<br/>We design and customize your Innovative<br/>
            Facebook Fan Page for you<br/>
            &nbsp;<br/>
            Call us: <br/>
            (773) 441 – 3116<br/>
        </div>
        <div class="planprebig"><span>$</span>99.99</div>
        <div class="planpresmall">One time Payment</div>
    </div>
</div>
<div id="boxplanalert">

</div>
<script type="text/javascript">
<?php
if (!$_SESSION["fbconexion"]) {
    ?>
            $(".planbtnupgrade").click(function(){
                $("#boxplanalert").html("You need to be logged to buy.");
                $("#boxplanalert").dialog({
                    modal:true,
                    title:"Alert",
                    buttons: { "Ok": function() { $(this).dialog("close"); }}
                });
            })
    <?php
} else {
    ?>
            $(".planbtnupgrade").click(function(){
                window.location.href="<?= $this->getURL("upgrade/index/") ?>"+$(this).attr("id").split("buy").join("");
            })
    <?php
    if ($_SESSION["fbconexion"]["idplan"] <= 1) {
        ?>
                    $("#buy4").click(function(){
                        $("#boxplanalert").html("You need to upgrade your plan to buy it.");
                        $("#boxplanalert").dialog({
                            modal:true,
                            title:"Alert",
                            buttons: { "Ok": function() { $(this).dialog("close"); }}
                        });
                    })
        <?php
    } else {
        ?>
                    $("#buy4").click(function(){
                        window.location.href="<?= $this->getURL("customizedfanpage/") ?>";
                    })   
        <?php
    }
}
?>
</script>