<?php
$r = $params["usuario"];
$idp = $params["selectedplan"];
$boton = '';
$texto = '';
$inumber="p" . $_POST["pbi11"] . "d" . $_POST["pbi12"];
switch ($inumber) {
    case "p2d0"://professional-mensual
        $boton = '<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="M36K46C9HTNRE">
<input type="submit" class="pbfinish" value="Next" name="submit">
<img alt="" border="0" src="https://www.paypalobjects.com/es_XC/i/scr/pixel.gif" width="1" height="1">
</form>
';
        $texto = "Professional Plan by Month";
        $precio = "9.99";
        //$precio = "1";
        $periodo="M";
        break;
    case "p2d1"://professional-anual -> TENGO QUE MODIFICARLO
        $boton = '
            <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="P48WASXMGLKU8">
<input type="submit" class="pbfinish" value="Next" name="submit">
<img alt="" border="0" src="https://www.paypalobjects.com/es_XC/i/scr/pixel.gif" width="1" height="1">
</form>
';
        $texto = "Professional Plan by Year";
        $precio = '99.99';
        $periodo="Y";
        break;
    case "p3d0"://premium-mensual
        $boton = '
            <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="WBX34PFBB6PFU">
<input type="submit" class="pbfinish" value="Next" name="submit">
<img alt="" border="0" src="https://www.paypalobjects.com/es_XC/i/scr/pixel.gif" width="1" height="1">
</form>
';
        $precio = '29.99';
        $texto = "Premium Plan by Month";
        $periodo="M";
        break;
    case "p3d1"://premium-anual
        $boton = '
            <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="7ZSYRSSXTPN6C">
<input type="submit" class="pbfinish" value="Next" name="submit">
<img alt="" border="0" src="https://www.paypalobjects.com/es_XC/i/scr/pixel.gif" width="1" height="1">
</form>
';
        $precio = '299.99';
        $texto = "Premium Plan by Year";
        $periodo="Y";
        break;
    default :
        echo "There was an error while payment was in progress.";
}
$inumber="u".$_SESSION["fbconexion"]["uid"].$inumber;
if($params["dcto"] && intval($params["dcto"])>0){
    $inumber .='m'.$params["dcto"];
    $precio *= (1-$params["dcto"]/100);
    $texto .= " with ".$params["dcto"]." less";
}

?>
<div id="paycol1">

</div>
<div id="paycol2">
    <div id="barrapago">Payment gateway</div>
    <div id="contpago1">
        <div class="paytitle">Confirm Payment</div>
        <div id="payboxpdata">
            <div class="pbrow">
                <label>First Mame</label>
                <div class="pbdato"><?= $_POST["pbi1"] ?></div>
            </div>
            <div class="pbrow pbcol2">
                <label>Country</label>
                <div class="pbdato"><?= $_POST["pbi17"] ?></div>
            </div>
            <div class="pbrow">
                <label>Last Name</label>
                <div class="pbdato"><?= $_POST["pbi3"] ?></div>
            </div>
            <div class="pbrow pbcol2">
                <label>State/Region</label>
                <div class="pbdato"><?= $_POST["pbi9"] ?></div>
            </div>
            <div class="pbrow">
                <label>Company</label>
                <div class="pbdato"><?= $_POST["pbi5"] ?></div>
            </div>
            <div class="pbrow pbcol2">
                <label>City</label>
                <div class="pbdato"><?= $_POST["pbi2"] ?></div>
            </div>
            <div class="pbrow">
                <label>Phone</label>
                <div class="pbdato"><?= $_POST["pbi8"] ?></div>
            </div>
            <div class="pbrow pbcol2">
                <label>Address</label>
                <div class="pbdato"><?= $_POST["pbi4"] ?></div>
            </div>
            <div class="pbrow">
                <label>E-mail</label>
                <div class="pbdato"><?= $_POST["pbi10"] ?></div>
            </div>
            <div class="pbrow pbcol2">
                <label>Zip Code</label>
                <div class="pbdato"><?= $_POST["pbi6"] ?></div>
            </div>
        </div>
        <div class="paytitle">Payment Resume</div>
        <div id="payboxpdata">
            <div class="pbrow">
                <label>Product:</label>
                <div class="pbdato"><?= $texto ?></div>
            </div>
            <div class="pbrow pbcol2">
                <label>Sub-Total:</label>
                <div class="pbdato"><?= $precio ?></div>
            </div>
            <div class="pbrow">
                <label>&nbsp;</label>
            </div>
            <div class="pbrow pbcol2 pbtotal">
                <label>Total:</label>
                <div class="pbdato"><?= $precio ?></div>
            </div>
            <div class="pbrow">
                <label>&nbsp;</label>
            </div>
            <div class="pbrow pbcol2 pbtotal">
                <label>&nbsp;</label>
                <div class="pbdato">

                    <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                        <input type="hidden" name="cmd" value="_xclick-subscriptions">
                        <input type="hidden" name="business" value="7TSVJ2E4C79ML">
                        <input type="hidden" name="lc" value="US">
                        <input type="hidden" name="item_name" value="<?=$texto?>">
                        <input type="hidden" name="item_number" value="<?=$inumber?>">
                        <input type="hidden" name="no_note" value="1">
                        <input type="hidden" name="no_shipping" value="2">
                        <input type="hidden" name="src" value="1">
                        <input type="hidden" name="a3" value="<?=$precio?>">
                        <input type="hidden" name="p3" value="1">
                        <input type="hidden" name="t3" value="<?=$periodo?>">
                        <input type="hidden" name="currency_code" value="USD">
                        <input type="hidden" name="usr_manage" value="1">
                        <input type="hidden" name="return" value="<?=$this->getURL(LANG."?logout=1")?>">
                        <input type="hidden" name="notify_url" value="http://www.fbconexion.com/upgrade/processIPN/;">
                        <input type="hidden" name="bn" value="PP-SubscriptionsBF:btn_subscribeCC_LG.gif:NonHosted">
                        <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                        <img alt="" border="0" src="https://www.paypalobjects.com/es_XC/i/scr/pixel.gif" width="1" height="1">
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
