<script type="text/javascript">
    function expandir(obj,uid){
        $.ajax({
            url:"<?= $this->getURL(LANG . "partners/report1_aux") ?>",
            data:"uid="+encodeURIComponent(uid),
            type:"POST",
            success:function(data){
                $(obj).parent().parent().find(".r1pages").html(data);
                $(obj).parent().parent().find(".r1pages").slideDown(450, function(){});
                $(obj).fadeOut(450, function(){})
            }
        })
    }
</script>
<div id="cuadrosortby">
    <form action="#" method="post" class="frmsearchfor">
        <label><?= __("Sort by ") ?>:</label>
        <select class="selsortby">
            <option value="0"><?= __("Register date") ?></option>
            <option value="1"><?= __("Update date") ?></option>
        </select>
        <span class="separador">|</span>
        <label><?= __("Search for") ?>:</label>
        <input type="text" class="txtsearchfor"/>
        <input type="image" src="<?= $this->getURL("images/ico_support-search.gif") ?>" class="subsearch"/>
    </form>
</div>
<div class="contreport" id="report1">
    <div id="resultados">
        <?= $params["registros"] ?>
    </div>
    <div style="display: block;">
        <a id="seemore" href="#2"><?= __("txtseemore") ?></a>
    </div>
</div>
<script type="text/javascript">
    numpags=<?= $params["numpags"] ?>;
    pagactual=2;
    if(numpags<=1){
        $("#seemore").hide();
    }else{
        $("#seemore").click(function(){
            $.ajax({
                url:"<?= $this->getURL(LANG . "partners/" . $params["reporte"] . "/") ?>"+pagactual,
                type:"POST",
                data:"sortby="+$(".selsortby").val()+"&searchfor="+encodeURIComponent($(".txtsearchfor").val()),
                success:function(data){
                    $("#report1 #resultados").append(data);
                    pagactual++;
                    $("#seemore").attr("href", "#"+pagactual);
                    if(pagactual>=numpags+1)
                        $("#seemore").hide();
                    else
                        $("#seemore").show();
                }
            })
            return false;
        })
    }
    $(".selsortby").change(function(){
        $("#seemore").attr("href", "#2");
        pagactual=2;
        $.ajax({
            url:"<?= $this->getURL(LANG . "partners/" . $params["reporte"] . "/") ?>1",
            type:"POST",
            data:"sortby="+$(".selsortby").val()+"&searchfor="+encodeURIComponent($(".txtsearchfor").val()),
            success:function(data){
                $("#report1 #resultados").html(data);
                if(pagactual>=numpags+1)
                    $("#seemore").hide();
                else
                    $("#seemore").show();
            }
        })
    })
    $(".frmsearchfor").submit(function(){
        $("#seemore").attr("href", "#2");
        pagactual=2;
        $.ajax({
            url:"<?= $this->getURL(LANG . "partners/" . $params["reporte"] . "/") ?>1",
            type:"POST",
            data:"sortby="+$(".selsortby").val()+"&searchfor="+encodeURIComponent($(".txtsearchfor").val()),
            success:function(data){
                $("#report1 #resultados").html(data);
                if(pagactual>=numpags+1)
                    $("#seemore").hide();
                else
                    $("#seemore").show();
            }
        })
        return false;
    })
</script>