<div id="cuadrocustom">
    <div id="munecocustom">
        <img src="<?= $this->getURL("images/personaje_disenando.png") ?>"/>
    </div>
    <div id="formcustom">
        <form id="frmcustom" action="#" method="post">
            <div class="csfila">
                <label><?= __("txtnombre") ?></label>
                <input type="text" id="txt1" value="" class="csinput required"/>
            </div>
            <div class="csfila">
                <label><?= __("txtapellidos") ?></label>
                <input type="text" id="txt2" value="" class="csinput required"/>
            </div>
            <div class="csfila">
                <label><?= __("txtemail") ?></label>
                <input type="text" id="txt3" value="" class="csinput required email"/>
            </div>
            <div class="csfila">
                <label><?= __("txttel") ?></label>
                <input type="text" id="txt4" value="" class="csinput required"/>
            </div>
            <div class="csfila">
                <label><?= __("txtdescription") ?></label>
                <textarea id="txt5" class="csinput required"></textarea>
            </div>
            <div class="csfila">
                <input type="submit" id="cussubmit" value="<?= __("btnsend") ?>"/>
            </div>
        </form>
    </div>
</div>
<div style="display: none">
    <div id="alertcs"></div>
</div>
<script type="text/javascript">
    $("#frmcustom").formValidator({
        onValidated:function(msg){
            if(msg!=""){
                $("#alertcs").html(msg);
                $("#alertcs").dialog({
                    "title":"<?= __("titalert") ?>",
                    "modal":true,
                    "buttons":{
                        "OK":function(){
                            $("#alertcs").dialog("close");
                        }
                    }
                })
            }
            else{
                $.ajax({
                    url:"<?= $this->getURL("customizedfanpageorder") ?>",
                    data:"txt1="+escape($("#txt1").val())+"&"+"txt2="+escape($("#txt2").val())+"&"+"txt3="+escape($("#txt3").val())+"&"+"txt4="+escape($("#txt4").val())+"&"+"txt5="+escape($("#txt5").val()),
                    type:"POST",
                    success:function(data){
                        $("#alertcs").html("<?= __("txtcistomsent") ?>");
                        $("#alertcs").dialog({
                            "title":"<?= __("titalert") ?>",
                            "modal":true,
                            "buttons":{
                                "OK":function(){
                                    $("#alertcs").dialog("close");
                                    window.location.href="<?= $this->getURL("") ?>";
                                }
                            }
                        })
                    }
                })
                
            }
            return false;
        }
    })
</script>