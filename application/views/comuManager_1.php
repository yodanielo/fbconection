<?php
$usuarios = $params["usuarios"];
?>
<!--$params["rpta"]-->
<div id="cmbarra">
    <?= $params["page"][0]["name"] ?>
</div>
<div id="cmcontent">
    <form id="frmcomu" action="#" method="post">
        <div id="scheduleform">
            <div id="divcalendar"></div>
            <input type="text" id="calfecha" name="calfecha" readonly="readonly" />
            <select name="calhour" id="calhour">
                <?php
                for ($i = 1; $i <= 12; $i++) {
                    echo '<option value="' . $i . '">' . $i . '</option>';
                }
                ?>
            </select>
            <select name="calminute" id="calminute">
                <?php
                for ($i = 0; $i <= 59; $i++) {
                    echo '<option value="' . $i . '">' . $i . '</option>';
                }
                ?>
            </select>
            <select name="calampm" id="calampm">
                <option value="AM">AM</option>
                <option value="PM">PM</option>
            </select>
            <input type="button" id="btndoschedule" name="btndoschedule" value="<?= __("btndone") ?>" />
            <input type="button" id="btnunschedule" name="btnunschedule" value="<?= __("btncancel") ?>" />
        </div>
        <div id="viewdateform">
            <div class="vdfila">
                <label><?= __("txtfrom") ?></label>
                <input type="text" id="vdfecha1" />
            </div>
            <div class="vdfila">
                <label><?= __("txtto") ?></label>
                <input type="text" id="vdfecha2" />
                <input type="button" id="btnsearchdate" value="" />
            </div>
        </div>
        <div id="scheduledlbl"></div>
        <textarea id="txtdesc" name="txtdesc"></textarea>
        <div id="contbotones">
            <input type="submit" value="<?= __("btnsendmessage") ?>" />
            <input type="button" id="btnschedule" value="<?= __("btnschedule") ?>" />
            <input type="button" id="btnviewdate" value="<?= __("btnviewdate") ?>" />
        </div>
        <div id="contattach1">
            <input type="text" id="txtattach" name="txtattach" class="paurl" />
            <input type="button" id="btnattach" name="btnattach" value="<?= __("btnattach") ?>" />
            <input type="button" id="btnremattach" name="btnremattach" value="X" />
        </div>
        <div id="contattach2">
            <div id="thumbattach">
            </div>
            <input type="text" id="txttitleattach" name="txttitleattach"  />
            <textarea id="txtdescattach" name="txtdescattach"></textarea>
            <input type="hidden" id="attachbg" name="attachbg" value=""/>
            <input type="hidden" id="txtenviado" name="txtenviado" value="1"/>
            <input type="hidden" id="txtpid" name="txtpid" value=""/>
            <input type="hidden" id="txtscheduled" name="txtscheduled" value=""/>
        </div>
    </form>
    <?php
        if($params["hayrango"])
            echo '<div id="msgrango">'.$params["hayrango"].'</div>';
    ?>
    <div id="cmpostcontent">
        <?php
        if (count($params["posts"]) > 0) {
            $cad1 = '';
            $cad2 = '';
            foreach ($params["posts"] as $p) {
                $cad = '
                <div class="postitem' . ($p->enviado != 1 ? ' postenviado' : '') . '" id="post' . $p->id . '">
                    <a class="postuser" target="_blank" href="' . $usuarios["f" . $p->user_id]["profile_url"] . '"><img src="' . $usuarios["f" . $p->user_id]["pic_square"] . '"/></a>
                    <div class="posttext">
                        <div class="postusername"><a target="_blank" href="' . $usuarios["f" . $p->user_id]["profile_url"] . '">' . $usuarios["f" . $p->user_id]["name"] . '</a></div>
                        <div>' . $p->mensaje . '</div>
                        <div class="postlinks"><span class="postdate">'.$p->fecha2 . '</span></div>
                    </div>
                </div>
                ';
                /* if ($p->enviado == 1)
                  $cad1 = $cad;
                  else */
                $cad2 = $cad;
                echo $cad1 . $cad2;
            }
        } else {
            ?>
            <div class="nohay">
                <?= __("txtnoitemstoshow") ?>
            </div>
            <?php
        }
        ?>
    </div>
</div>
<script type="text/javascript">
    attachbg="";
    estadoattach=0;
    $("#btndoschedule").click(function(){
        $("#txtenviado").val("0");
    });
    $("#btnschedule").click(function(){
        $("#scheduleform").slideToggle(450,function(){});
    });
    $("#btnviewdate").click(function(){
        $("#viewdateform").slideToggle(450, function(){});
    })
    $("#btnsearchdate").click(function(){
        f1=$("#vdfecha1").datepicker("getDate");
        f2=$("#vdfecha2").datepicker("getDate");
        if(f1.getTime()<=f2.getTime())
            window.location.href="<?=$this->getURL("communicationManager/index/".$params["page"][0]["page_id"]."/")?>"+f1.getFullYear()+"/"+(f1.getMonth()+1)+"/"+f1.getDate()+"/"+f2.getFullYear()+"/"+(f2.getMonth()+1)+"/"+f2.getDate();
        else
            alert("<?=__("msginvalidrango")?>");
    })
    $("#vdfecha1").datepicker();
    $("#vdfecha2").datepicker();
    //lo que se presiona para cancelar la agenda
    $("#btnunschedule").click(function(){
        $("#scheduledlbl").slideUp(450, function(){});
        $("#txtenviado").val("1");
        $("#btnschedule").click();
    })
    //lo que se presiona para agendar, no para enviar, solo para agendar
    $("#btndoschedule").click(function(){
        $("#scheduledlbl").html("<?= __("txtscheduledon") ?>"+$("#calfecha").val()+" <?= __("txtat") ?> "+$("#calhour").val()+":"+$("#calminute").val()+" "+$("#calampm").val());
        $("#scheduledlbl").slideDown(450, function(){});
        a=$("#calfecha").val().split("-");
        ff=new Date();
        ff=$("#divcalendar").datepicker("getDate");
        hh=$("#calhour").val()*1;
        if($("#calampm").val()=="PM")
            hh+=12;
       
        //mm-dd-yy
        $("#txtenviado").val("0");
        var datum=new Date(Date.UTC(ff.getFullYear(), (ff.getMonth()), ff.getDate(), hh, $("#calminute").val()));
        total=ff.getTime()/1000.0+(hh*60*60)+($("#calminute").val()*60);
        //lo saco de ajaxx 
        $("#txtscheduled").val(total);
        $("#btnschedule").click();
    });
    $("#divcalendar").datepicker({
        "altField": "#calfecha",
        "altFormat": "mm-dd-yy",
        "minDate":"0D"
    });
    $("#btnattach").click(function(){
        urlin=$("#txtattach").val();
        if(urlin.split(" ").join("")!=""){
            $("#btnremattach").click();
            $("#btnattach").val("<?= __("txtloading") ?>");
            $.ajax({
                url:"<?= $this->getURL(LANG . "communicationManager/getImages") ?>",
                data:"url="+urlin,
                type:"POST",
                dataType:"json",
                success:function(data){
                    attachbg=data[0];
                    $("#attachbg").val(attachbg);
                    $("#thumbattach img").remove();
                    if(attachbg)
                        $("#thumbattach").append('<img src="'+attachbg+'" alt="" style="float:left;width:100%; height:auto;"/>')
                    $("#btnattach").val("<?= __("btnattach") ?>");
                    $("#contattach2").slideDown(450, function(){});
                }
            });
        }
    })
    $("#btnremattach").click(function(){
        attachbg="";
        $("#attachbg").val(attachbg);
        $("#txttitleattach").empty();
        $("#txtdescattach").empty();
        $("#contattach2").slideUp(450, function(){});
    });
    $(".postenviado").each(function(){
        cad='<div class="menuenviado"><span class="envedit"><?= __("btnedit") ?></span> / <span class="envsend"><?= __("btnsend") ?></span> / <span class="envcancel"><?= __("btncancel") ?></span></div>';
        posteo=this;
        peid=$(posteo).attr("id").split("post").join("");
        $(posteo).find(".postusername").prepend(cad);
        $(posteo).find(".envcancel").click(function(){
            esto=$(this).parent().parent().parent().parent();
            peid=esto.attr("id").split("post").join("");
            miurl="<?= $this->getURL(LANG . "communicationManager/cancelWall/") ?>"+peid+"/<?= $params["page"][0]["page_id"] ?>";
            //alert(miurl);
            $.ajax({
                url:miurl,
                success:function(data){
                    esto.fadeOut(450, function(){});
                }
            })
        });
        $(posteo).find(".envsend").click(function(){
            $.ajax({
                url:"<?= $this->getURL(LANG . "communicationManager/publishWall/") ?>"+peid+"/<?= $params["page"][0]["page_id"] ?>",
                success:function(data){
                    $(posteo).removeClass("postenviado");
                }
            })
        })
        $(posteo).find(".envedit").click(function(){
            $.getJSON("<?= $this->getURL(LANG . "communicationManager/getPost/") ?>"+peid+"/<?= $params["page"][0]["page_id"] ?>", "", function(data){
                $("#scheduledlbl").slideUp(450, function(){});
                $("#txtdesc").val(data.txtdesc);
                $("#txtpid").val(peid);
                if(data.txtattach){
                    $("#txtattach").val(data.txtattach);
                    $("#txttitleattach").val(data.txttitleattach);
                    $("#txtdescattach").val(data.txtdescattach);
                    $("#attachbg").val(data.attachbg);
                }
                else{
                    $("#txtattach").val("");
                    $("#txttitleattach").val("");
                    $("#txtdescattach").val("");
                    $("#attachbg").val("");
                }
                $("#txtenviado").val("0");
                //siempre va ser agendado
                $("#divcalendar").datepicker( "setDate" , data.fecha2);
                $("#calhour").val(data.hora*1);
                $("#calminute").val(data.minu*1);
                $("#calampm").val(data.ampm);
                $("#btndoschedule").click();
            })
        });
    })
    $("#frmcomu").submit(function(){
        listo=true;
        if($("#txtdesc").val()==""){
            $("#txtdesc").effect("highlight",{},1000,function(){});
            listo=false;
        }
        else
            if($("#attachbg").val()!=""){
                if($("#txttitleattach").val()==""){
                    $("#txttitleattach").effect("highlight",{},1000,function(){});
                    listo=false;
                }
            if($("#txtdescattach").val()==""){
                $("#txtdescattach").effect("highlight",{},1000,function(){});
                listo=false;
            }
        }
        if(!listo)
            return false;
    });
    paurlfun=function(){
        if($(".paurl").val().indexOf("http://")>-1 || $(".paurl").val().indexOf("https://")>-1)
            $(".paurl").val($(".paurl").val().split("http://").join("").split("https://").join(""));
        setTimeout(paurlfun, 100);
    }
    $(".paurl").css({
        width:625
    })
    paurlfun();
</script>