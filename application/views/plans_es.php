<div id="contplans">
    <div class="planitem" id="plan1">
        <h2>Personal</h2>
        <div class="plansize">1Mb</div>
        <div class="planchars">
            Tecnología arrastrar y colocar<br/>
            Adm. Relac. Públicas<br/>
            Generador de cupones<br/>
            <span style="text-decoration: underline;">Logo de FBConexion</span><br/>
            Acceso a todos los Widgets<br/>
            1 Página de Fans de Facebook<br/>
            <span style="text-decoration: underline;">1 Pestaña</span>
        </div>
        <div class="planpresfree">Free</div>
    </div>
    <div class="planitem" id="plan2">
        <a class="planbtnupgrade" id="buy2">GRATIS</a>
        <h2>Professional</h2>
        <div class="plansize">25Mb</div>
        <div class="planchars">
            Tecnología arrastrar y colocar<br/>
            Adm. Relac. Públicas<br/>
            Generador de cupones<br/>
            <span style="text-decoration: underline;">Logo de FBConexion</span><br/>
            Acceso a todos los widgets<br/>
            1 Página de Fans de Facebook<br/>
            <span style="text-decoration: underline;">Pestañas ilimitadas</span>
        </div>
        <div class="planprebig"></div>
        <div class="planpresmall" style="font-size: 13px; margin-top: -12px;">Si invitas a 30 personas a ser fans de Fb Conexion y te suscribes a nuestro blog</div>
    </div>
    <div class="planitem" id="plan3">
        <a class="planbtnupgrade" id="buy3">GRATIS</a>
        <h2>Premium</h2>
        <div class="plansize">50Mb</div>
        <div class="planchars">
            Tecnología arrastrar y colocar<br/>
            Adm. Relac. Públicas<br/>
            Generador de cupones<br/>
            <span style="text-decoration: underline;">Sin Logo de FBConexion</span><br/>
            Acceso a todos los widgets<br/>
            3 Páginas de Fans de Facebook<br/>
            <span style="text-decoration: underline;">Pestañas ilimitadas</span>
        </div>
        <div class="planprebig"></div>
        <div class="planpresmall" style="font-size: 13px; margin-top: -12px;">Si invitas a 50 personas a ser fans de Fb Conexion y te suscribes a nuestro blog</div>
    </div>
    <div class="planitem" id="plan4">
        <div class="planbtnupgrade" id="buy4">Contáctanos</div>
        <h2>Diseño  Personalizado</h2>
        <div class="planchars">
            &nbsp;<br/>¿No tienes tiempo?,<br/>
            ¿Quieres evitarte complicaciones?<br/>
            Bríndanos la idea y nosotros diseñamos tu Facebook Fan Page por ti<br/>
            Llamanos al (773) 441 - 3116<br/>
        </div>
        <div class="planprebig"><span>$</span>99.99</div>
        <div class="planpresmall">Único Pago</div>
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
                $("#boxplanalert").html("Necesitas iniciar sesión para comprar.");
                $("#boxplanalert").dialog({
                    modal:true,
                    title:"Alerta",
                    buttons: { "Ok": function() { $(this).dialog("close"); }}
                });
            })
    <?php
} else {
    if ($_SESSION["fbconexion"]["idplan"] <= 1) {
        ?>
                    $("#buy4").click(function(){
                        $("#boxplanalert").html("Necesitas actualizar tu plan antes de comprar.");
                        $("#boxplanalert").dialog({
                            modal:true,
                            title:"Alerta",
                            buttons: { "Ok": function() { $(this).dialog("close"); }}
                        });
                    })
        <?php
    } else {
        ?>
                    $("#buy4").click(function(){
                        window.location.href="<?= $this->getURL("es/customizedfanpage/") ?>";
                    })   
        <?php
    }
}
?>
</script>