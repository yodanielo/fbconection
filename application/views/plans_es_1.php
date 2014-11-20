<div id="contplans">
    <div class="planitem" id="plan1">
        <h2>Personal</h2>
        <div class="plansize">1Mb</div>
        <div class="planchars">
            Tecnología arrastrar y colocar<br/>
            Adm. Relac. Públicas<br/>
            Generador de cupones<br/>
            Logo de FBConexion<br/>
            Acceso a todos los Widgets<br/>
            1 Página de Fans de Facebook<br/>
            1 Pestaña
        </div>
        <div class="planpresfree">Free</div>
    </div>
    <div class="planitem" id="plan2">
        <div class="planbtnupgrade" id="buy2">Comprar ahora</div>
        <h2>Professional</h2>
        <div class="plansize">25Mb</div>
        <div class="planchars">
            Tecnología arrastrar y colocar<br/>
            Adm. Relac. Públicas<br/>
            Generador de cupones<br/>
            Logo de FBConexion<br/>
            Acceso a todos los widgets<br/>
            1 Página de Fans de Facebook<br/>
            Pestañas ilimitadas
        </div>
        <div class="planprebig"><span>$</span>99.99<span>/año</span></div>
        <div class="planpresmall"><span>$</span>9.99<span>/mes</span></div>
    </div>
    <div class="planitem" id="plan3">
        <div class="planbtnupgrade" id="buy3">Comprar ahora</div>
        <h2>Premium</h2>
        <div class="plansize">50Mb</div>
        <div class="planchars">
            Tecnología arrastrar y colocar<br/>
            Adm. Relac. Públicas<br/>
            Generador de cupones<br/>
            Sin Logo de FBConexion<br/>
            Acceso a todos los widgets<br/>
            3 Páginas de Fans de Facebook<br/>
            Pestañas ilimitadas
        </div>
        <div class="planprebig"><span>$</span>299.99<span>/año</span></div>
        <div class="planpresmall"><span>$</span>29.99<span>/mes</span></div>
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
<?php
if (!$_SESSION["fbconexion"]) {
    ?>
            $(".planbtnupgrade").click(function(){
                $("#boxplanalert").html("Necesitas iniciar sesión para comprar.");
                $("#boxplanalert").dialog({
                    modal:true,
                    title:"Alerta",
                    buttons: { "Ok": function() { $(this).dialog("close"); }}
                });
            })
    <?php
} else {
    ?>
            $("#buy2,#buy3").click(function(){
                window.location.href="<?= $this->getURL("es/upgrade/index/") ?>"+$(this).attr("id").split("buy").join("");
            })
    <?php
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