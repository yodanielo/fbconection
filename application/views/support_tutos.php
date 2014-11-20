<div class="wrappersup">
    <div id="exbuscador">
        <form method="get" action="#" id="frmexsearch">
            <label><?= __("txtsearch") ?></label>
            <input type="text" id="txtquery"/>
            <input type="submit" id="subquery" value="" />
            <div id="btnborrarquery"></div>
            <div id="exlistbusqueda"></div>
        </form>
    </div>
    <div id="exgalerias">
        <a href="#" id="exgizq"></a>
        <div id="exvisorgal" class="exvisorvid">
            <?php
            if (count($params["samples"]) > 0) {
                $cad = "";
                $auxcad = "";
                foreach ($params["samples"] as $key => $r) {
                    $idy = preg_replace("/(http\:\/\/www.youtube.com\/watch\?v\=)(.[^&]+)(.*)?/", "$2", $r->video);
                    $auxcad.='<a id="xv' . $r->id . '" href="#xv' . $r->id . '" alt="' . $idy . '"><span>' . $r->nombre . '</span><img src="http://i4.ytimg.com/vi/' . $idy . '/hqdefault.jpg" style="width:143px" /></a>';
                    if (($key + 1) % 5 == 0 || $key + 1 == count($params["samples"])) {
                        $cad.='<div>' . $auxcad . '</div>';
                        $auxcad = "";
                    }
                }
                echo $cad;
            }
            else
                echo $cad;
            ?>
        </div>
        <a href="#" id="exgder"></a>
    </div>
    <div id="exgrandes">

    </div>
</div>
<script type="text/javascript">
    $("#exvisorgal").cycle({
        prev:"#exgizq",
        next:"#exgder",
        fx:"scrollVert",
        speed:  'slow', 
        timeout: 0
    });
    $("#exvisorgal a").click(function(){
        $("#exvisorgal a.active").removeClass("active");
        $(this).addClass("active");
        idy=$(this).attr("alt").split("#").join("");
        embebido='<iframe width="629" height="483" src="http://www.youtube.com/embed/'+idy+'?autoplay=0" frameborder="0" allowfullscreen></iframe><div id="videodesc"></div>';
        $("#exgrandes").html(embebido)
        $.ajax({
            url:"<?= $this->getURL(LANG . "support/tutoItem/") ?>"+$(this).attr("id"),
            success:function(data){
                $("#videodesc").html(data);
            }
        })
        //return false;
    });
    $("#exvisorgal a:first").click();
    $("#btnborrarquery").click(function(){
        $("#exlistbusqueda").empty();
        $("#exlistbusqueda").hide();
    });
    $("#frmexsearch").submit(function(){
        if($("#txtquery").val()!="" && $("#txtquery").val().length>=3){
            $("#exlistbusqueda").show();
            valor=$("#txtquery").val().toString().toLowerCase();
            cad='';
            $("#exvisorgal a span").each(function(){
                mispan=$(this).html().toString().toLowerCase();
                if(mispan.indexOf(valor)!=-1)
                    cad+='<li><a onclick="return irdebuscar(\'#'+$(this).parent().attr("id")+'\')" href="#'+$(this).parent().attr("id")+'">'+$(this).html().split(valor).join("<strong>"+valor+"</strong>")+'</a></li>';
            });
            if(cad!=""){
                $("#exlistbusqueda").html("<ul>"+cad+"</ul>");
            }
            else{
                $("#exlistbusqueda").html("<div><?= __("txtnoitemstoshow") ?></div>");
            }
            if($("#exlistbusqueda li").length>5)
                $("#exlistbusqueda").height(98);
            else
                $("#exlistbusqueda").height("auto");
            $("#exlistbusqueda ul li a").click(function(){
                x=$(this).attr("href");
                $(x).click();
                return false;
            })
        }
        else{
            $("#exlistbusqueda").html();
            $("#exlistbusqueda").hide();
        }
        return false;
    })
    irdebuscar=function(a){
        x=a.split("#");
        if(x[1]!=""){
            if(x.length>1){
                ruta=x[1].split(" ").join("");
                $("#exvisorgal #"+ruta).click();
            }
        }
    }
    $(document).ready(function(){
        irdebuscar(window.location.href);
    })
</script>