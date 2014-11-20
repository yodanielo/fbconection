$(document).ready(function(){
    $("#linkalert").fancybox({
        padding:0,
        overlayOpacity:0.8,
        overlayColor:'#000',
        onClosed:function(){
            $("#boxalert #boxtexto").html("");
        }
    });
});
function engine_form(fname){
    $("#"+fname).formValidator({
        onValidated:function(msg){
            if(msg){
                $("#boxalert #boxtexto").html(msg);
                $("#linkalert").click();
            }
            else{
                
        }
        }
    });
}
function grid_eliminar(formulario,id){
    $("#"+formulario+" .idobj").val(id);
    $("#"+formulario+" .accion").val("eliminar_simple");
    $("#"+formulario).submit();
}
function grid_editar(formulario,id){
    $("#"+formulario+" .idobj").val(id);
    $("#"+formulario+" .accion").val("set_editar");
    $("#"+formulario).submit();
}
function grid_estado_simple(formulario,id){
    $("#"+formulario+" .idobj").val(id);
    $("#"+formulario+" .accion").val("estado_simple");
    $("#"+formulario).submit();
}
function selectgroup(com,grid){
    $(grid).find(".bDiv div tbody tr").click()/*.each(function(){
        if($(this).hasClass("trSelected"))
            $(this).removeClass("trSelected");
        else
            $(this).addClass("trSelected");
    });*/
}
function estadogroup(com,grid){
    xrpt=new Array();
    $(grid).find(".bDiv div tbody tr").each(function(){
        xrpt.push($(this).attr("id").split("row").join(""));
    });
    if(xrpt.length>0){
        $(grid).parent().find(".idobj").val(xrpt.join(","));
        $(grid).parent().find(".accion").val("estado_varios");
        $(grid).parent().parent().submit();
    }
}
function deletegroup(com,grid){
    xrpt=new Array();
    $(grid).find(".bDiv div tbody tr").each(function(){
        xrpt.push($(this).attr("id").split("row").join(""));
    });
    if(xrpt.length>0){
        $(grid).parent().find(".idobj").val(xrpt.join(","));
        $(grid).parent().find(".accion").val("eliminar_varios");
        $(grid).parent().parent().submit();
    }
}