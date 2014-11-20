<h1 class="titulo">Regístrate</h1>
<div id="formualrioizq">
    <?=$params["registro"]->descripcion_es?>
</div>
<div id="formualrioder">
    <form name="frmregistro" id="frmregistro" action="" method="">
        <div class="col2row">
            <label for="txt1">Nombre de usuario<span>*</span></label>
            <input alt="Nombre de usuario" type="text" name="txt1" id="txt1" class="required" />
        </div>
        <div class="col2row">
            <label for="txt2">Contraseña<span>*</span></label>
            <input alt="Contraseña" type="password" name="txt2" id="txt2" class="required" />
        </div>
        <div class="col2row">
            <label for="txt3">Repita contraseña<span>*</span></label>
            <input alt="Repita contraseña" type="password" name="txt3" id="txt3" class="required" />
        </div>
        <div class="col2row">
            <label for="txt4">Nombres <span>*</span></label>
            <input alt="Nombres" type="text" name="txt4" id="txt4" class="required" />
        </div>
        <div class="col2row">
            <label for="txt5">Apellidos <span>*</span></label>
            <input alt="Apellidos" type="text" name="txt5" id="txt5" class="required" />
        </div>
        <div class="col2row">
            <label for="txt6">Empresa <span>*</span></label>
            <input alt="Empresa" type="text" name="txt6" id="txt6" class="required" />
        </div>
        <div class="col2row">
            <label for="captchatxt">Código de Seguridad <span>*</span></label>
            <input alt="Código de Seguridad" type="text" name="captchatxt" id="captchatxt" class="required" />
            <img id="captchaimg" src="<?=$this->getURL("captcha/image/registro")?>" alt="Código de Seguridad" />
        </div>
        <div class="col2row col2submit">
            <input type="submit" id="btnsubmit" class="submitreg" value="Enviar"/>
            <input type="button" class="submitreg" value="Borrar"/>
            <label>* Campos Obligatorios</label>
        </div>
    </form>
</div>
<script type="text/javascript">
    $("#frmregistro").formValidator({
        captchatxt_validate:function(ctl){
            xv=$(ctl).val();
            rpt=true;
            $.ajax({
                url:'<?=$this->getURL("captcha/check/registro")?>',
                data:'value='+xv,
                type:'POST',
                async:false,
                success:function(data){
                    if(parseInt(data)==0){
                        rpt=false;
                    }
                }
            });
            if(!rpt){
                return 'El código de seguridad no es correcto.<br/>';
            }
        },
        txt1_validate:function(ctl){
            xv=$(ctl).val();
            rpt=true;
            $.ajax({
                url:'<?=$this->getURL("usuarios/exist_user")?>',
                data:'value='+xv,
                type:'POST',
                async:false,
                success:function(data){
                    if(parseInt(data)==1){
                        rpt=false;
                    }
                }
            });
            if(!rpt){
                return 'El nombre de usuario ya existe.<br/>';
            }
        },
        txt2_validate:function(ctl){
            if($("#txt2").val()!=$("#txt3").val()){
                return 'las contraseñas no coinciden.<br/>';
            }
        },
        onValidated:function(msg){
            if(msg!=""){
                $("#boxtexto").html(msg);
                $("#linkalert").click();
            }else{
                cad=new Array();
                for(i=1;i<=6;i++){
                    cad.push('txt'+i+'='+escape($("#txt"+i).val()));
                }
                $.ajax({
                    url:'<?=$this->getURL("usuarios/set_register")?>',
                    type:'POST',
                    data:cad.join("&"),
                    success:function(data){
                        if(parseInt(data)==1){
                            $("#boxtexto").html("Se ha registrado satisfactoriamente.");
                            $("#linkalert").click();
                            $("[name|=txt]").empty();
                            $("#captchatxt").attr("src","");
                            $("#captchatxt").attr("src",'<?=$this->getURL("captcha/check/registro")?>');
                        }else{
                            $("#boxtexto").html(data);
                            $("#linkalert").click();
                        }
                    }
                });
            }
            return false;
        }
    });
</script>