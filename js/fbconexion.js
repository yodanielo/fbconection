user_id=0;
paginas=new Array();
//funcione spara edicion de paso 1
function grid_estado_simple(txt,id){
    $.ajax({
        url:"http://www.fbconexion.com/pubpage/"+parseInt(id),
        type:"POST",
        success:function(data){
            $("#boxalert #boxtexto").html("Tu página fue publicada con éxito.");
            $("#linkalert").click();
        }
    });
}

function grid_editar(txt,id){
    $(".idobj").val(id);
    $(".accion").val("set_editar");
    $("#gridintranet1").attr("action","http://www.fbconexion.com/fbconexion/paso2");
    $("#gridintranet1").submit();
}

function grid_eliminar(txt,id){
    $(".idobj").val(id);
    $(".accion").val("eliminar_simple");
    $("#gridintranet1").attr("action","http://www.fbconexion.com/fbconexion");
    $("#gridintranet1").submit();
}
//funciones del paso 2
