<div class="cuadroform" id="cuadrott">
    <form id="frmtransfer" action="#" method="post">
        <div class="changefila">
            <label><?= __("Enter the tab number") ?></label>
            <input type="text" class="required" id="txt1" />
        </div>
        <div class="changefila">
            <label><?= __("Enter the new username") ?></label>
            <input type="text" class="required" id="txt2" />
            <div class="isthis"></div>
        </div>
        <div class="changefila">
            <label><?= __("Enter the destination page") ?></label>
            <input type="text" class="required" id="txt3" />
            <div class="isthis"></div>
        </div>
        <div class="changefila">
            <label><?= __("Enter the Tab name") ?></label>
            <select class="required" id="txt4">
                <?php
                foreach ($params["tabs"] as $tab) {
                    echo '<option value="' . $tab->id . '">' . $tab->nombre . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="changefila">
            <input type="submit" value="<?= __("btnsend") ?>" />
        </div>
    </form>
</div>
<div id="dialogo"></div>
<script type="text/javascript">
    $("#txt2,#txt3").keypress(function(){
        $(this).parent().find(".isthis").empty();
        $(this).removeClass("checked");
        $(this).parent().find(".valorreal").empty();
    })
    $("#txt1").blur(function(){
        if($(this).val()!="")
            $(this).addClass("checked");
        else
            $(this).removeClass("checked");
    });
    $("#txt2,#txt3").blur(function(){
        todo=$(this);
        url=$(this).val().split("?")[0].split("/");
        url=url[url.length-1];
        FB.api('/'+url, function(data) {
            if(data.error){
                todo.parent().find(".isthis").html('<span class="nocheckederror"><?= __("I could not verify the information") ?></span>')
                todo.removeClass("checked");
                todo.val("");
            }
            else{
                cad='<div class="msgcheck"><a target="_blank" href="http://www.facebook.com/'+data.id+'"><img src="http://graph.facebook.com/'+data.id+'/picture" style="float:left; margin-right:10px;" />'+data.name+'</a></div>';
                todo.parent().find(".isthis").html(cad);
                todo.addClass("checked");
                todo.val(data.id);
            }
        });
    })
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
    $("#frmtransfer").submit(function(){
        if($(".checked").length==3){
            $.ajax({
                url:"<?=$this->getURL(LANG."partners/transferTab")?>",
                type:"POST",
                data:"txt1="+encodeURIComponent($("#txt1").val())+"&txt2="+encodeURIComponent($("#txt2").val())+"&txt3="+encodeURIComponent($("#txt3").val())+"&txt4="+encodeURIComponent($("#txt4").val())+"",
                success:function(data){
                    doAlert(data);
                }
            })
        }else{
            doAlert("<?=__("Every field is mandatory")?>");
        }
        return false;
    })
</script>