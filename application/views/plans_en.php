<div id="contplans">
    <div class="planitem" id="plan1">
        <h2>Personal</h2>
        <div class="plansize">1Mb</div>
        <div class="planchars">
            Drag and Drop Designer<br/>
            Public Relationship Manager<br/>
            Coupon Manager<br/>
            <span style="text-decoration: underline;">FBConexion Logo</span><br/>
            Full access to ALL the widgets<br/>
            1 Facebook Fan Page<br/>
            <span style="text-decoration: underline;">1 tab</span>
        </div>
        <div class="planpresfree">Free</div>
    </div>
    <div class="planitem" id="plan2">
        <a class="planbtnupgrade" id="buy2" href="#">Free</a>
        <h2>Professional</h2>
        <div class="plansize">25Mb</div>
        <div class="planchars">
            Drag and Drop Designer<br/>
            Public Relationship Manager<br/>
            Coupon Manager<br/>
            <span style="text-decoration: underline;">FBConexion Logo</span><br/>
            Full access to ALL the widgets<br/>
            1 Facebook Fan Page<br/>
            <span style="text-decoration: underline;">unlimited tabs</span>
        </div>
        <div class="planprebig"></div>
        <div class="planpresmall" style="font-size: 14px; margin-top: -10px;"> If you invite 30 friends to LIKE our FB page & subscribe to our newsletter.</div>
    </div>
    <div class="planitem" id="plan3">
        <a class="planbtnupgrade" id="buy3" href="#">Free</a>
        <h2>Premium</h2>
        <div class="plansize">50Mb</div>
        <div class="planchars">
            Drag and Drop Designer<br/>
            Public Relationship Manager<br/>
            Coupon Manager<br/>
            <span style="text-decoration: underline;">No FBConexion Logo</span><br/>
            Full Access to ALL the widgets<br/>
            3 Facebook Fan Page<br/>
            <span style="text-decoration: underline;">unlimited tabs</span>
        </div>
        <div class="planprebig"></div>
        <div class="planpresmall" style="font-size: 14px; margin-top: -10px;"> If you invite 50 friends to LIKE our FB page & subscribe to our newsletter.</div>
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
    $(document).ready(function(){
        if($("#msgpromo a").length==1){
            h=$("#msgpromo a").attr("href");
            $("#buy2,#buy3").attr("href", h);
            $("#buy2,#buy3").attr("target", "_blank");
        }
        else{
            $("#buy2,#buy3").click(function(){
                $("#msgpromo").click();
            })
        }
    });

<?php
if (!$_SESSION["fbconexion"]) {
    ?>
            $("#buy4").click(function(){
                $("#boxplanalert").html("You need to be logged to buy.");
                $("#boxplanalert").dialog({
                    modal:true,
                    title:"Alert",
                    buttons: { "Ok": function() { $(this).dialog("close"); }}
                });
            })
    <?php
} else {
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