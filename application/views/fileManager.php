<?php
$tt = $params["tt"];
$tu = $params["size"];
$tr = 150;
$path = $params["path"];
?>
<div class="files_title"><a href="#" class="fmck" id="fmcancel"><img alt="" src="<?= $this->getURL("images/no.png") ?>"/>Cancel</a><a href="#" class="fmck" id="fmok"><img alt="" src="<?= $this->getURL("images/yes.png") ?>"/>Select</a>My F<span style="font-family:Arial; font-weight: bold">i</span>les</div>
<div id="files_toolbar">
    <ul>
        <li>
            <span>Used Space</span>
        </li>
        <li>
            <div id="pbsize">
                <div id="pbused" style="width:<?= ceil($tu * $tr / $tt) ?>px"></div>
            </div>
        </li>
        <li>
            <span>View&nbsp;<img src="<?= $this->getURL("/images/ico_view.jpg") ?>" alt="view"/></span>
            <ul id="tabview">
                <li><a href="#vistaicons">Icons</a></li>
                <li><a href="#vistalista">List</a></li>
            </ul>
        </li>
        <li id="fmdelete">
            <span class="fmconicono">Delete&nbsp;<img src="<?= $this->getURL("/images/ico_delete.jpg") ?>" alt="Delete"/></span>
        </li>
        <li id="fmpicnik">
            <a class="fmconicono" target="_blank" href="#">Edit with Picnik<img src="<?= $this->getURL("/images/ico_edit.jpg") ?>" alt="Edit with Picnik"/></a>
        </li>
    </ul>
</div>
<div id="contarchivos">
    <?= $this->loadController("filemanager")->listFiles($params["ext"]) ?>
</div>
<div id="contfmsubir">
    <span style="position:relative; border:none;overflow: hidden; float:left;"><iframe name="ifsubir" title="Upload your files" src="<?= $this->getURL("filemanager/subirform") ?>" style="margin: -2px; width:653px; height:29px;" scrolling="no" border="0"></iframe></span>
</div>
<div style="display:none">
    <div id="fdiag"></div>
</div>
<script type="text/javascript">
    //$(".vistacont").css({"display":"block","opacity":1});
    $("#tabview li").click(function(){
        a=$(this).find("a").attr("href");
        /*if(a=="#vistaicons")
            $("#vistalista").animate({"opacity":0}, 450, "linear", function(){
                $("#vistalista").hide();
            });
        else
            $("#vistaicons").animate({"opacity":0}, 450, "linear", function(){
                $("#vistaicons").hide();
            });
        $(a).show().animate({"opacity":100}, 450, "linear", function(){});*/
        a="#"+a.split("#")[1];
        $(".vistacont").hide();
        $(a).show();
        $("#tabview li.active").removeClass("active");
        $(this).addClass("active");
        return false;
    });
    $("#tabview li:first").click();
    function fmclickfolder(bb){
        $("#contarchivos").empty();
        idfolder=$(bb).attr("href").split("#")[1]
        ruta="<?= $this->getURL("filemanager/listSpecial/") ?>";
        if(idfolder==0)
            ruta="<?= $this->getURL("filemanager/listFiles/" . urlencode($params["ext"])) ?>";
        $.ajax({
            url:ruta+idfolder,
            dara:"ext=<?= ($params["ext"] != "" ? urlencode($params["ext"]) : '') ?>",
            type:"POST",
            success:function(data){
                $("#contarchivos").html(data);
                $("#tabview li.active").click();
            }
        })
        return false;
    }
    function fmclicklink(bb){
        $("#contarchivos a.active").removeClass("active");
        esto=$(bb).attr("href");
        $("#contarchivos a[href="+esto+"]").addClass("active");
        $("#fmpicnik a").attr("href","http://www.picnik.com/service/?_apikey=b04060d7223cda8bde1761ec00dc37ac&_import="+encodeURIComponent(esto)+"&_export=<?= urlencode($this->getURL(LANG . "filemanager/getpicnik/")) ?>&_export_agent=browser&_export_method=POST&_export_field=aqui");
        return false;
    }
    $("#fmpicnik a").click(function(){
        $("#fmcancel").click();
    })
    $("#fmcancel").click(function(){
        $("#fmanager").dialog("close");
        return false;
    });
    $("#fmdelete").click(function(){
        if($("#contarchivos a.active:first").length>0){
            $("#fdiag").html("<?= __("txtdelfmanager") ?>");
            $("#fdiag").dialog({
                title:"<?= __("titalert") ?>",
                modal:true,
                buttons:{
                    "<?= __("txtyes") ?>":function(){
                        archivo=$("#contarchivos a.active:first").attr("href").split("#")[0];
                        $.ajax({
                            url:"/filemanager/deleteFile/",
                            type:"POST",
                            data:"filename="+encodeURIComponent(archivo),
                            success:function(data){
                                $("#contarchivos a.active").remove();
                                setused(data);
                            }
                        });
                        $(this).dialog("close");
                    },
                    "<?= __("txtno") ?>":function(){
                        $(this).dialog("close");
                    }
                }
            });
        }
        return false;
    });
    
    function setused(size){
        r=parseInt($("#pbsize").width()*size);
        $("#pbused").width(r);
    }
    fmok_click=function(){
        if($("#contarchivos a.active:first").length>0){
            archivo=$("#contarchivos a.active:first").attr("href");
            destino="#"+"<?= $params["destino"] ?>".split("#")[1];
            $(destino).val(archivo);
            $("#fmanager").dialog("close");
            $(".pahtml").change()
        }
        return false;
    }
    
    $("#fmok").click(fmok_click);
</script>