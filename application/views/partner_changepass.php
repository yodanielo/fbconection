<div class="cuadroform" id="cuadro_changepass">
    <form id="frmchange" action="#" method="post">
        <div class="changefila">
            <label><?= __("Enter your current password") ?></label>
            <input type="text" class="required" id="txt1" />
        </div>
        <div class="changefila">
            <label><?= __("Enter your new password") ?></label>
            <input type="password" class="required" id="txt2" />
        </div>
        <div class="changefila">
            <label><?= __("Retype your new password") ?></label>
            <input type="password" class="required" id="txt3" />
        </div>
        <div class="changefila">
            <input type="submit" value="<?= __("btnsend") ?>" />
        </div>
    </form>
</div>
<div style="display:none">
    <div id="dialogo"></div>
</div>
<script type="text/javascript">
    doAlert=function(msg){
        $("#dialogo").html(msg);
        $("#dialogo").dialog({
            title:"<?= __("titalert") ?>",
            modal:true,
            buttons:{
                "OK":function(){
                    $("#dialogo").dialog("close");
                }
            }
        });
    }
    $("#frmchange").submit(function(){
        checked=true;
        $(".required").each(function(){
            if($(this).val()==""){
                checked=false;
            }
        })
        if(checked==false){
            doAlert("<?= __("Every field is mandatory") ?>");
        }else{
            if($("#txt2").val()!=$("#txt3").val()){
                checked=false;
                doAlert("<?= __("Passwords don't match") ?>");
            }
            else{
                $.ajax({
                    url:"<?= $this->getURL(LANG . "partners/change_password") ?>",
                    data:"txt1="+$("#txt1").val()+"&txt2="+$("#txt2").val(),
                    type:"POST",
                    success:function(data){
                        doAlert(data);
                        $(".required").val("");
                    }
                })
            }
        }
        return false;
    })
</script>