<div id="cuadrocontact">
    <div id="ctcol1">
        <strong>FB Conexion</strong><br/>
        1584 Oak Ave. Suite 2<br/>
        Evanston, IL 60201<br/>
        USA<br/>
        Teléfono (773) 441 3116<br/>
        Email: <a href="mailto:info@fbconexion.com">info@fbconexion.com</a><br/>
        Horario:<br/>
        Lunes – Viernes de 9:00am a 5:00pm Tiempo Central Estandar
        <a target="_blank" title="FB Conexion en Google Maps" id="ctmap" href="http://maps.google.com/maps?q=fb+conexion&hl=es&sll=42.04691,-87.685822&sspn=0.006175,0.009645&vpsrc=0&hq=fb+conexion&t=m&z=17">
            <img src="http://maps.google.com/maps/api/staticmap?center=42.04675,-87.68690&zoom=15&size=200x200&sensor=false&markers=42.04675,-87.68690&visible=Fb%20Conexion" alt="FB Conexion on Google Maps" />
        </a>
        <a id="linkscontact" href="<?=$this->getURL(LANG."linksDirectory")?>"><?=__("Links Directory")?></a>
    </div>
    <div id="ctcol2">
        <form id="frmcontact" action="" method="post">
            <div class="ctrow" id="cttitle">
                Contacto
            </div>
            <?php if($_POST["txt1"]){ ?>
            <div class="ctrow">
                <span>Mensaje enviado</span>
            </div>
            <?php } ?>
            <div class="ctrow">
                <span>Si tienes preguntas o comentarios respecto a nuestra plataforma por favor completa el siguiente formulario
                    
                </span>
            </div>
            <div class="ctrow">
                <label>Tema</label>
                <select class="ctinput" type="text" name="txt1" id="txt1">
                    <option value="Sales">Ventas</option>
                    <option value="Support">Soporte</option>
                    <option value="Report error">Reportes de Errores</option>
                    <option value="Other">Otros</option>
                </select>
            </div>
            <div class="ctrow">
                <label>Asunto</label>
                <input class="ctinput" type="text" name="txt2" id="txt2" />
            </div>
            <div class="ctrow">
                <label>Nombre</label>
                <input class="ctinput" type="text" name="txt3" id="txt3" />
            </div>
            <div class="ctrow">
                <label>E-mail</label>
                <input class="ctinput" type="text" name="txt4" id="txt4" />
            </div>
            <div class="ctrow">
                <label>Mensaje</label>
                <textarea class="ctinput ctarea" type="text" name="txt5" id="txt5"></textarea>
            </div>
            <div class="ctrow">
                <input type="submit" value="Enviar" id="ctsubmit" />
            </div>
        </form>
    </div>
</div>
<div style="display:none">
    <div id="alertbox"></div>
</div>
<script type="text/javascript">
    $("#frmcontact").formValidator({
        onValidated:function(msg){
            if(msg){
                $("#alertbox").html(msg);
                $("#alertbox").dialog({
                    "title":"Alert",
                    "modal":true,
                    buttons: { }
                })
            }
        }
    });
</script>