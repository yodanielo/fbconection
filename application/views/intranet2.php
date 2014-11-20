<?php
$lib = $this->loadLib("textlibs");
$idobj = $_POST["idobj"];
$r = $params["registro"];
$settings = $params["settings"];
if ($_SESSION["fbconexion"]["INTROFB"])
    $r->espremium = 4;
?>
<!--<script src="<?= $this->getURL("js/jquery.shape.js") ?>"></script>-->
<div id="contpaso2">

    <div id="edcol1">
        <div id="edlblwidgets">
            <div class="edlbl" id="edlbl2" href="#edwmostpopular"></div>
            <div class="edlbl" id="edlbl1" href="#edwpopular"></div>
            <?php
            /* $tabs=array("","edwfree","edwprofessional","edwpremium","edwenterprise");
              for($i=1;$i<=3;$i++)
              if($i>$r->espremium)
              echo '<div class="edlbl edblbldisabled" id="edlbl'.$i.'" href="#'.$tabs[$i].'"></div>';
              else
              echo '<div class="edlbl" id="edlbl'.$i.'" href="#'.$tabs[$i].'"></div>';
             */
            ?>
        </div>
        <div id="edwidgets">
            <div id="edcuadroazul">
                <div id="edpagename">
                    <?= '<a class="llla" href="' . $params["pagina"]->link . '" target="_blank">' . $lib->limitarLetras($params["registro"]->nompagina, 50) . '</a><a class="lllb" href="' . $params["pagina"]->link . '?sk=app_' . $r->appid . '" target="_blank">' . $lib->limitarLetras($params["registro"]->appname, 50) ?>
                </div>
                <div id="edctlpage">
                    <a class="ed_eliminar" title="Delete" href="#" ><img src="<?= $this->getURL("images/ico_eliminar2.png") ?>"/></a>
                    <a class="ed_clonar" title="Copy to" href="#"><img src="<?= $this->getURL("images/ico_clonar.png") ?>"/></a>
                </div>
                <div id="indicaciones">
                    <?=__("txtindicaciones")?>
                </div>
            </div>
            <div id="edcwidgets">
                <div class="edwcontent" id="edwmostpopular">
                    <div class="edwenabled">
                        <a alt="xv39" title="<?= __("wid12") ?>" class="m_widgets mw_draggable" id="w12" href="<?= $this->getURL(LANG . "fbforms/widgets/p12") ?>"><span></span></a>
                        <a alt="xv41" title="<?= __("wid17") ?>" class="m_widgets mw_draggable wipad" id="w17" href="<?= $this->getURL(LANG . "fbforms/widgets/p17") ?>"><span></span></a>
                        <a alt="xv36" title="<?= __("wid1") ?>" class="m_widgets mw_draggable" id="w1" href="<?= $this->getURL(LANG . "fbforms/widgets/p1") ?>"><span></span></a>
                        <a alt="xv35" title="<?= __("wid2") ?>" class="m_widgets mw_draggable" id="w2" href="<?= $this->getURL(LANG . "fbforms/widgets/p2") ?>"><span></span></a>
                        <a alt="xv34" title="<?= __("wid3") ?>" class="m_widgets mw_draggable" id="w3" href="<?= $this->getURL(LANG . "fbforms/widgets/p3") ?>"><span></span></a>
                        <a alt="xv42" title="<?= __("wid5") ?>" class="m_widgets mw_draggable" id="w5" href="<?= $this->getURL(LANG . "fbforms/widgets/p5") ?>"><span></span></a>
                        <a alt="xv37" title="<?= __("wid7") ?>" class="m_widgets mw_draggable" id="w7" href="<?= $this->getURL(LANG . "fbforms/widgets/p7") ?>"><span></span></a>
                        <a alt="xv32" title="<?= __("wid9") ?>" class="m_widgets mw_draggable" id="w9" href="<?= $this->getURL(LANG . "fbforms/widgets/p9") ?>"><span></span></a>
                        <a alt="" title="<?= __("wid18") ?>" class="m_widgets mw_draggable" id="w18" href="<?= $this->getURL(LANG . "fbforms/widgets/p18") ?>"><span></span></a>
                        <a alt="" title="<?= __("wid23") ?>" class="m_widgets mw_draggable" id="w23" href="<?= $this->getURL(LANG . "fbforms/widgets/p23") ?>"><span></span></a>
                        <a alt="" title="<?= __("wid29") ?>" class="m_widgets mw_draggable wie9" id="w29" href="<?= $this->getURL(LANG . "fbforms/widgets/p29") ?>"><span></span></a>
                    </div>
                    <div class="edwenabled">
                        <a alt="" title="<?= __("wid10") ?>" class="m_widgets mw_draggable" id="w10" href="<?= $this->getURL(LANG . "fbforms/widgets/p10") ?>"><span></span></a>
                        <a alt="xv30" title="<?= __("wid13") ?>" class="m_widgets mw_draggable" id="w13" href="<?= $this->getURL(LANG . "fbforms/widgets/p13") ?>"><span></span></a>
                        <a alt="xv38" title="<?= __("wid21") ?>" class="m_widgets mw_draggable" id="w21" href="<?= $this->getURL(LANG . "fbforms/widgets/p21") ?>"><span></span></a>
                        <a alt="" title="<?= __("wid22") ?>" class="m_widgets mw_draggable" id="w22" href="<?= $this->getURL(LANG . "fbforms/widgets/p22") ?>"><span></span></a>
                        <a alt="xv28" title="<?= __("wid24") ?>" class="m_widgets mw_draggable" id="w24" href="<?= $this->getURL(LANG . "fbforms/widgets/p24") ?>"><span></span></a>
                        <a alt="xv24" title="<?= __("wid25") ?>" class="m_widgets mw_draggable" id="w25" href="<?= $this->getURL(LANG . "fbforms/widgets/p25") ?>"><span></span></a>
                        <a alt="" title="<?= __("wid27") ?>" class="m_widgets mw_draggable" id="w27" href="<?= $this->getURL(LANG . "fbforms/widgets/p27") ?>"><span></span></a>
                        <a alt="" title="<?= __("wid30") ?>" class="m_widgets mw_draggable" id="w30" href="<?= $this->getURL(LANG . "fbforms/widgets/p30") ?>"><span></span></a>
                        <a alt="xv25" title="<?= __("wid32") ?>" class="m_widgets mw_draggable" id="w32" href="<?= $this->getURL(LANG . "fbforms/widgets/p32") ?>"><span></span></a>
                        <a alt="" title="<?= __("wid41") ?>" class="m_widgets mw_draggable" id="w41" href="<?= $this->getURL(LANG . "fbforms/widgets/p41") ?>"><span></span></a>
                        <a alt="" title="<?= __("wid43") ?>" class="m_widgets mw_draggable" id="w43" href="<?= $this->getURL(LANG . "fbforms/widgets/p43") ?>"><span></span></a>
                        <a alt="" title="<?= __("wid44") ?>" class="m_widgets mw_draggable" id="w44" href="<?= $this->getURL(LANG . "fbforms/widgets/p44") ?>"><span></span></a>
                        <a alt="" title="<?= __("wid45") ?>" class="m_widgets mw_draggable" id="w45" href="<?= $this->getURL(LANG . "fbforms/widgets/p45") ?>"><span></span></a>
                    </div>
                </div>
                <div class="edwcontent edwenabled" id="edwpopular">
                    <a alt="" title="<?= __("wid38") ?>" class="m_widgets mw_draggable" id="w38" href="<?= $this->getURL(LANG . "fbforms/widgets/p38") ?>"><span></span></a>
                    <a alt="xv33" title="<?= __("wid4") ?>" class="m_widgets mw_draggable" id="w4" href="<?= $this->getURL(LANG . "fbforms/widgets/p4") ?>"><span></span></a>
                    <a alt="" title="<?= __("wid8") ?>" class="m_widgets mw_draggable" id="w8" href="<?= $this->getURL(LANG . "fbforms/widgets/p8") ?>"><span></span></a>
                    <a alt="xv26" title="<?= __("wid19") ?>" class="m_widgets mw_draggable" id="w19" href="<?= $this->getURL(LANG . "fbforms/widgets/p19") ?>"><span></span></a>
                    <a alt="xv27" title="<?= __("wid14") ?>" class="m_widgets mw_draggable" id="w14" href="<?= $this->getURL(LANG . "fbforms/widgets/p14") ?>"><span></span></a>
                    <a alt="xv29" title="<?= __("wid26") ?>" class="m_widgets mw_draggable" id="w26" href="<?= $this->getURL(LANG . "fbforms/widgets/p26") ?>"><span></span></a>
                    <a alt="xv31" title="<?= __("wid15") ?>" class="m_widgets mw_draggable" id="w15" href="<?= $this->getURL(LANG . "fbforms/widgets/p15") ?>"><span></span></a>
                    <a alt="" title="<?= __("wid33") ?>" class="m_widgets mw_draggable" id="w33" href="<?= $this->getURL(LANG . "fbforms/widgets/p33") ?>"><span></span></a>
                    <a alt="" title="<?= __("wid34") ?>" class="m_widgets mw_draggable" id="w34" href="<?= $this->getURL(LANG . "fbforms/widgets/p34") ?>"><span></span></a>
                    <a alt="" title="<?= __("wid35") ?>" class="m_widgets mw_draggable" id="w35" href="<?= $this->getURL(LANG . "fbforms/widgets/p35") ?>"><span></span></a>
                    <a alt="" title="<?= __("wid36") ?>" class="m_widgets mw_draggable" id="w36" href="<?= $this->getURL(LANG . "fbforms/widgets/p36") ?>"><span></span></a>
                    <a alt="" title="<?= __("wid37") ?>" class="m_widgets mw_draggable" id="w37" href="<?= $this->getURL(LANG . "fbforms/widgets/p37") ?>"><span></span></a>
                    <a alt="" title="<?= __("wid40") ?>" class="m_widgets mw_draggable" id="w40" href="<?= $this->getURL(LANG . "fbforms/widgets/p40") ?>"><span></span></a>
                    <a alt="" title="<?= __("wid39") ?>" class="m_widgets mw_draggable" id="w39" href="<?= $this->getURL(LANG . "fbforms/widgets/p39") ?>"><span></span></a>
                    <a alt="" title="<?= __("wid42") ?>" class="m_widgets mw_draggable" id="w42" href="<?= $this->getURL(LANG . "fbforms/widgets/p42") ?>"><span></span></a>
                    <a alt="" title="<?= __("wid46") ?>" class="m_widgets mw_draggable" id="w46" href="<?= $this->getURL(LANG . "fbforms/widgets/p46") ?>"><span></span></a>
                    <a alt="" title="<?= __("wid47") ?>" class="m_widgets mw_draggable" id="w47" href="<?= $this->getURL(LANG . "fbforms/widgets/p47") ?>"><span></span></a>
                    <a alt="" title="<?= __("wid48") ?>" class="m_widgets mw_draggable" id="w48" href="<?= $this->getURL(LANG . "fbforms/widgets/p48") ?>"><span></span></a>
                    <a style="display:none" alt="" title="<?= __("wid49") ?>" class="m_widgets mw_draggable" id="w49" href="<?= $this->getURL(LANG . "fbforms/widgets/p49") ?>"><span></span></a>
                </div>
            </div>
        </div>
    </div>
    <div id="edcol2">
        <div id="edtoolbar">
            <div class="btnnaranja" id="edpublish"><?= __("btnpublish") ?></div>
            <div class="btnnaranja" id="edunpublish"><?= __("btnunpublish") ?></div>
            <div class="btnnaranja" id="edupgrade"><?= __("titstartover") ?></div>
            <div class="btnnaranja" id="edcuadricula"><?= __("titgrid") ?></div>
            <div class="btnnaranja" id="edsettings"><?= __("titsettings") ?></div>
            <div class="btnnaranja" id="edtemplates"><?= __("tittemplates") ?></div>
            <!--<a class="btnnaranja" id="edbtnmypages" href="<?= $this->getURL(LANG . "fbconexion") ?>"><?= __("titmypages") ?></a>-->
        </div>
        <div id="reglasuperior"></div>
        <div id="reglacentral">
            <div id="conteditor" style="background-image: url(<?= $settings->edb_w2 ?>); background-position: <?= str_replace("+"," ",$settings->edb_w3) ?>; background-repeat: <?= $settings->edb_w4 ?>;">
                <?php
                if (count($params["widgets"]) > 0)
                    foreach ($params["widgets"] as $w) {
                        $clase = substr($w->marca, 0, strpos($w->marca, "_") - 1);
                        $e = json_decode(rawurldecode($w->estructura));
                        echo '<div class="wm_editor ' . $clase . '" id="' . $w->marca . '" style="width:' . abs($e->width) . 'px;height:' . abs($e->height) . 'px; left:' . abs($e->left) . 'px; top:' . abs($e->top) . 'px; z-index:' . ($e->sp_1 != "" ? "$e->sp_1" : "5") . '!important; border:' . ($e->sp_2 == "1" ? $e->sp_4 : "0") . 'px solid ' . ($e->sp_2 == "1" && $e->sp_3 != "" ? $e->sp_3 : '#cececf') . '">';
                        echo '<div class="wmcover"></div>';
                        echo '<div class="wm_edco">' . $w->contenido_ed . '</div>';
                        echo '</div>';
                    }
                ?>
            </div>
            <canvas width="810" height="810" id="bgeditor"></canvas>
        </div>
        <a name="widget"></a>
        <div id="reglainferior"></div>
    </div>
</div>
<div id="nover" style="display:none">
    <div id="controlbox">
        <span title="Edit" id="ieditor_editar" onclick="return editarbox(this)"></span>
        <span title="Delete" id="ieditor_eliminar" onclick="return eliminarbox(this)"></span>
    </div>
    <div id="dialogo"></div>
    <div class="tplencuesta">
        <div class="boxdiseno">
            <?= __("doyouwishdesign") ?>
            <div clas="tesubmit">
                <input type="button" class="btncongrat btncg1" value="<?= __("txtyes") ?>"/>
                <input type="button" class="btncongrat btncg2" value="<?= __("txtno") ?>"/>
            </div>
        </div>
        <div class="boxencuesta">
            <div class="tetitle"><?= __("txtcuentanos") ?></div>
            <div class="telabel"><?= __("teq1") ?></div>
            <div class="testar testar1" alt="0"><div class="tescroller"></div></div>
            <div class="telabel"><?= __("teq2") ?></div>
            <div class="testar testar2" alt="0"><div class="tescroller"></div></div>
            <div class="telabel"><?= __("teq3") ?></div>
            <div class="testar testar3" alt="0"><div class="tescroller"></div></div>
            <div class="telabel"><?= __("teq4") ?></div>
            <div class="testar testar4" alt="0"><div class="tescroller"></div></div>
            <div class="telabel"><?= __("teq5") ?></div>
            <div class="testar testar5" alt="0"><div class="tescroller"></div></div>
            <div class="telabel"><?= __("teq6") ?></div>
            <div class="tecomentario testar6">
                <textarea></textarea>
            </div>
            <div class="telabel tesubmit">
                <input type="button" id="tesend" value="<?= __("btnsend") ?>" />
            </div>
            <script type="text/javascript">
                $(".testar").starcount();
                $(".btncg1").click(function(){
                    contactodesign();
                })
                $(".btncg2").click(function(){
                    $("#dialogo .boxdiseno").remove();
                })
                $("#tesend").click(function(){
                    suma=0;
                    $("#dialogo .testar").each(function(){
                        if($(this).attr("alt")*1>0)
                            suma+=1;
                    })
                    if(suma>=5){
                        $.ajax({
                            url:"<?= $this->getURL(LANG . "fbconexion/encuesta") ?>",
                            data:"pb1="+encodeURIComponent($("#dialogo .testar1").attr("alt"))+"&pb2="+encodeURIComponent($("#dialogo .testar2").attr("alt"))+"&pb3="+encodeURIComponent($("#dialogo .testar3").attr("alt"))+"&pb4="+encodeURIComponent($("#dialogo .testar4").attr("alt"))+"&pb5="+encodeURIComponent($("#dialogo .testar5").attr("alt"))+"&pb6="+encodeURIComponent($("#dialogo .testar6 textarea").val()),
                            type:"POST",
                            success:function(data){
                                $("#dialogo .boxencuesta").remove();
                            }
                        })
                    }
                });
            </script>
        </div>
    </div>
    <div id="templates_bg"></div>
    <div id="templates_box">

    </div>
    <div id="nuevotab">
        <a href="javascript:$('#nuevotab').dialog('close')" class="ntimage">
            <img src="<?= $this->getURL("images/ntblank.png") ?>" />
            <br/>A blank page
        </a>
        <a href="#" id="nttemplate" class="ntimage">
            <img src="<?= $this->getURL("images/nttemplate.png") ?>" />
            <br/>Choose a template
        </a>
    </div>
</div>

<script type="text/javascript">
    if($.browser.msie && parseInt($.browser.version)<=9){
        $(".wie9").removeClass("mw_draggable").attr("title","Compatible only with Safari, Chrome and Firefox.");
        $(".wie9 span").css("background-position-x", "-41px");
    }
    isiPad = navigator.userAgent.match(/iPad/i) != null;
    if(isiPad){
        $(".wipad").removeClass("mw_draggable").attr("title","Compatible only with Safari, Chrome and Firefox.");
        $(".wipad span").css("background-position-x", "-41px");
    }
    x=new Array();
    mipageX=0;
    mipageY=0;
    primeravez=0;
    btnalert='<div class="alertbotonera"><a href="javascript:$.dialog()"></a></div>';
    $(".edlbl").click(function(){
        $(".edlbl.active").removeClass("active");
        $(this).addClass("active");
        r=$(this).attr("href");
        $(".edwcontent").slideUp(450, function(){});
        $(r).slideDown(450, function(){});
        
    })
    $(".edlbl:first").click();
    id=<?= $r->id ?>;
    $("#edupgrade").click(function(){
        $("#dialogo").html("<?= __("txtstartover") ?>");
        $("#dialogo").dialog({
            title:"<?= __("titalert") ?>",
            modal:true,
            buttons:{
                "<?= __("txtyes") ?>":function(){
                    $.ajax({
                        url:"<?= $this->getURL(LANG . "fbconexion/cleanPage/$r->id") ?>",
                        success:function(data){
                            x=window.location.href.split("#");
                            window.location.href=x[0];
                        }
                    });
                    $("#dialogo").dialog("close");
                },
                "<?= __("txtno") ?>":function(){
                    $("#dialogo").dialog("close");
                }
            }
        });
    })
    $(".ed_eliminar").click(function(){
        $.ajax({
            url:"<?= $this->getURL(LANG . "fbconexion/deletePage/$r->id") ?>",
            success:function(data){
                //alert(data);
                window.location.href=window.location.href;
            }
        });
        return false;
    });
    $(".ed_clonar").click(function(){
        msgbox("<?= $this->getURL(LANG . "fbforms/clonar/$r->id") ?>","<?= __("titcopyto") ?>");
        return false;
    });
    $("#edcuadricula").click(function(){
        $("#conteditor").toggleClass("concuadricula");
    });
    $("#edsettings").click(function(){
        msgbox("<?= $this->getURL(LANG . "fbforms/settings/$r->id") ?>", "<?= __("titsettings") ?>")
        return false;
    });
    $("#edtemplates").click(function(){
        $.ajax({
            url:"/<?= LANG ?>fbconexion/boxTemplates",
            success:function(data){
                $("#templates_box").html(data);
                $("#templates_box").dialog({
                    "title":"<?= __("chooseyourtemplate") ?>",
                    "modal":true,
                    "width":742,
                    buttons: { }
                })
                
            }
        });
        return false;
    });
    $("#edunpublish").click(function(){
        $.ajax({
            url:"<?=$this->getURL(LANG."fbconexion/unpublish/$r->id")?>",
            type:"post",
            success:function(data){
                $("#dialogo").html('<div id="pubmsg"><?=__("txtsuccesspublish")?></div>');
                $("#dialogo").dialog({
                    modal:true,
                    resizable:false,
                    width:300,
                    title:"<?=__("txtunpublish")?>",
                    buttons:{
                        "OK":function(){
                            $(this).dialog("close");
                        }
                    }
                })
            }
        });
    })
    $("#edpublish").click(function(){
        $.ajax({
            url:"/<?= LANG ?>fbconexion/paso3/<?= $r->id ?>",
            type:"post",
            success:function(data){
                //alert(data);
                if(data.indexOf("http")>-1){
                    window.location.href=data;
                }
                $("#dialogo").html('<div id="pubmsg">'+"<?= __("txttabcreated") ?>".split("{here}").join($("#edpagename a:last").attr("href"))+'</div><input type="button" value="OK" id="pubok"/>');
                $("#dialogo #pubok").click(function(){
                    $("#dialogo").dialog("close");
                })
                $("#dialogo").append($(".tplencuesta").html());
                $("#dialogo").dialog({
                    position:"top",
                    modal:true,
                    width:300,
                    resizable:false,
                    title:"<?= __("tittabcreated") ?>",
                    buttons: {}
                });
            }
        })
        return false;
    });
    function saveProperty(marca,idw){
        $("#contenttabs .ctab").hide();
        //$("#labeltabs div").Dtabs("#contenttabs .ctab");
        $("#labeltabs div").click(function(){
            $("#labeltabs div.active").removeClass("active");
            $(this).addClass("active");
            indice=$("#labeltabs div").index($(this));
            r=$("#contenttabs .ctab")[indice];
            $("#contenttabs .ctab").slideUp(450, function(){});
            $(r).slideDown(450, function(){});
        
        })
        $("#labeltabs div:first").click();
        $('.pasetcolor').ColorPicker({
            onSubmit: function(hsb, hex, rgb, el) {
                $(el).val("#"+hex);
                $(el).ColorPickerHide();
            },
            onBeforeShow: function () {
                $(this).ColorPickerSetColor(this.value);
            }
        })
        $(".pahtml").change(function(){
            ph=$(this).val().split("http://").join("");
            $(this).val(ph);
        })
        $(".pahtml").change();
        /*.focus(function(){
        $(this).ColorPickerShow();
    });*/
        $("#"+marca).formValidator({
            eol:"\n",
            onValidated:function(msg){
                if(msg)
                    alert(msg)
                else{
                
                    cad="";
                    $(".edb_campo").each(function(){
                        if($(this).hasClass("pahtml") && $(this).val()!="")
                            $(this).val("http://"+$(this).val());
                        $(this).val($(this).val().split("http://https://").join("https://"))
                        cad+="&"+$(this).attr("id")+"="+encodeURIComponent($(this).val())
                    });
                    t=idw.split("_")
                    /*if(typeof(editor) != "undefined"){
                    aux=editor.getData();
                    editor.destroy();
                    cad+="&texto="+escape(aux);
                }*/
                    if(t[0]=="w17"){
                        $(".mceListBoxMenu").remove();
                        if($.browser.msie && parseInt($.browser.version)==8){
                            cad+="&texto="+encodeURIComponent($("#edb_w1").val());
                        }
                        else{
                            cad+="&texto="+encodeURIComponent(tinyMCE.get('edb_w1').getContent());
                        }
                    }
                    //alert(cad);
                    miurl="/<?= LANG ?>fbsetform/"+t[0]+"/<?= $r->id ?>/"+idw;
                    $.ajax({
                        url:miurl,
                        data:"token=0"+cad,
                        type:"POST",
                        success:function(data){
                            $("#"+idw+" .wm_edco").html(data);
                            if(t[0]=="w17"){
                                $("#"+idw).height($("#"+idw+" .wm_edco").outerHeight());
                                resizado($("#"+idw)[0]);
                                resizando($("#"+idw)[0]);
                            }
                            $("#dialogo").dialog("close");
<?php
if ($_SESSION["fbconexion"]["primeravez"]) {
    unset($_SESSION["fbconexion"]["primeravez"]);
    ?>
                                    if(primeravez==0){
                                        primeravez=1;
                                        $("#dialogo").html("<?= __("ttclickpublish") ?>");
                                        $("#dialogo").dialog({
                                            "title":"<?= __("titalert") ?>",
                                            "modal":true,
                                            "buttons":{
                                                "OK":function(){
                                                    $("#dialogo").dialog("close");
                                                }
                                            }
                                        });
                                    }
    <?php
}
?>
                            ////guardar_pl();
                        }
                    });
                    return false;
                }
            }
        });
    }
    function msgbox(m_link,m_title,m_params,ww){
        if(!ww)
            ww=300;
        $.ajax({
            url:m_link,
            type:"POST",
            data:(m_params?m_params:""),
            success:function(data){
                $("#dialogo").html(data);
                $("#dialogo").dialog({
                    draggable:true,
                    resizable:false,
                    title:m_title,
                    width:ww,
                    modal:true,
                    position:"top",
                    close:function(){
                        if(typeof(editor) != "undefined")
                            editor.destroy();
                        $("#dialogo").empty();
                    },
                    buttons: { }
                })
            }
        })
    }
    $(".m_widgets").click(function(){
        return false;
    });
    function updateEditor(){
        $(document).ready(function(){
            mayor=0;
            $(".wm_editor").each(function(){
                medida=$(this).height()+$(this).position().top;
                if(medida>mayor){
                    mayor=medida;
                }
            });
            $("#conteditor").height(mayor+150);
            redim_canvas();
        })
    }
    function redim_canvas(){
        //$("#bgeditor").attr("height",$("#conteditor").height());
        tipo="<?= strtolower($settings->edb_w1c) ?>";
        if(tipo!=""){
            $("#bgeditor").height($("#conteditor").height());
            $("#bgeditor").gradient({
                type:"<?= strtolower($settings->edb_w1c) ?>",
                width:810,
                height:810,
                colors:[
<?php
$fc = ($settings->edb_w1a != "" ? $settings->edb_w1a : "#ffffff");
echo "'" . $fc . "',\n";
$sc = (trim($settings->edb_w1b) != "" ? $settings->edb_w1b : $fc);
echo "'" . $sc . "'\n";
?>
                ]
            });
            $("#bgeditor").css("background-color","<?= $sc ?>");
        }
    }
    function guardar_pl(){
<?php
//esto viene cuando se reordena, se publica, se agrega, se quita un widget, se edita?
//guarda la estructura de los widgets
?>
        a=$("#conteditor").clone();
        //ed=a.html()
        x=new Array();
        a.find(".wm_editor").each(function(){
            x.push($(this).attr("id"));
        });
        //aqui tengo q redimensionar el canvas
        redim_canvas();
        $.ajax({
            url:"/<?= LANG ?>fbconexion/saveTab/<?= $r->id ?>",
            type:"POST",
            data:"estructura="+encodeURIComponent(x.join(",")),
            success:function(data){
                //no hace nada
                //alert(data)
            }
        });
    }
    //controlbox pa los widgets
    function editarbox(a){
        idcontrol=$(a).attr("href");
        tripas=idcontrol.split("_");
        ctl=tripas[0];
        url=$(ctl).attr("href")+"/"+idcontrol.split("#").join("")+"/"+id+"/"+$(ctl).attr("alt");
        if(ctl=="#w17" || ctl=="#w29")
            msgbox(url, "Properties","",535);
        else
            msgbox(url, "Properties","",300);
        //return false;
    }
    function eliminarbox(a){
        idhref=$(a).attr("href");
        $("#controlbox").hide();
        $("#controlbox").appendTo("body");
        $("#conteditor "+idhref).remove();
        $.ajax({
            url:"<?= $this->getURL(LANG . "fbconexion/removeWidget/$r->id/") ?>"+idhref.split("#").join(""),
            type:"POST",
            success:function(data){
                if(data!=""){
                    //alert(data);
                }
            }
        });
        guardar_pl();
        return false;
    }
    $(document).mousemove(function(e){
        pp=$("#conteditor").position();
        mipageX=e.pageX-pp.left;
        mipageY=e.pageY-pp.top-30;
    })
    //engranaje principal
    function engine(){
        //drag and drop
        $(".edwenabled .mw_draggable").draggable({
            revert: true
            //helper: "clone"
        });
        $("#conteditor").droppable({
            accept:".edwenabled .mw_draggable",
            drop:function(event,ui){
                iddrag=$(ui.draggable).attr("id");
                $.ajax({
                    url:"/<?= LANG ?>fbwidgets/"+iddrag,
                    success:function(data){
                        $("#conteditor").append(data)
                        //destruir draggable y droppable
                        $(".mw_draggable").draggable("destroy");
                        $("#conteditor").droppable("destroy");
                        //volver a crear
                        //window.location.href="javascript:fleXenv.fleXcrollMain('scroller')";
                        resizando($(".wm_editor:last"));
                        //alert($(ui.draggable).position().left+" - "+$(ui.draggable).position());
                        $(".wm_editor:last").css({
                            "left":mipageX,
                            "top":mipageY+Math.abs(175-$("#edcol2").offset().top)-25
                        });
                        resizado($(".wm_editor:last")[0]);
                        engine();
                        guardar_pl();
                        //resizar($(".wm_editor:first")[0]);
                    }
                });
            }
        });
        //aparecer controles de edicion
        $("#conteditor > .wm_editor").hover(function(){
            ided=$(this).attr("id");
            p=$(this).position();
            w=$(this).width();
            $("#controlbox").show();
            $("#controlbox").css({
                "position":"absolute!important",
                //left:p.left,
                "left":0,
                "margin-left":w-44,
                "width":44
            });
            $("#controlbox").appendTo(this);
            $("#controlbox span").each(function(){
                $(this).attr("href","#"+ided)
            });
        }, function(){
            $("#controlbox").hide();
        })
        //ordenar
        $("#conteditor .wm_editor").draggable({
            containment:"#conteditor",
            snap:"#conteditor",
            //grid:[5,5],
            snapTolerance:5,
            stop:function(event,ui){
                xx=this;
                resizado(xx);
            }
        });
    
        resizando=function(a){
            $(a).each(function(){
                $(this).find(".paresizar").width($(this).width());
                $(this).find(".paresizar").height($(this).height());
            })
        }
        resizado=function(a){
            //ajusto
            if($(a).width()+$(a).position().left>$("#conteditor").width()+1){
                $(a).css("left", 519-$(a).width());
            }
            if($(a).height()+$(a).position().top>=$("#conteditor").height()-50){
                $("#conteditor").stop().animate({
                    height:"+=150"
                }, 450, "linear", function(){
                    //window.location.href="javascript:fleXenv.fleXcrollMain('scroller')";
                    redim_canvas();
                });
            }
            //guardo
            t=$(a).attr("id").split("_");
            pa=$(a).position();
            miurl="/<?= LANG ?>fbsetform/"+t[0]+"/<?= $r->id ?>/"+$(a).attr("id");
            //alert(miurl);
            $.ajax({
                url:miurl,
                type:"POST",
                data:"height="+$(a).height()+"&width="+$(a).width()+"&left="+pa.left+"&top="+pa.top,
                success:function(){
                    //listo
                }
            });
            //guardar_pl();
        }
        resizar=function(a){
            w=$(a).width();
            h=$(a).height();
            $(a).find(".paresizar").width(w);
            $(a).find(".paresizar").height(h);
        }
        $(".wm_editor").resizable({
            maxWidth: 810,
            minWidth: 20,
            containment: "#conteditor",
            grid: 2,
            resize:function(event,ui){
                a=$(ui.originalElement[0]);
                resizar(a);
            },
            stop:function(event,ui){
                a=$(ui.originalElement[0]);
                resizado(a);
            }
        });
        //alert("T");
        $("#coneditor").disableSelection();
        $(".wm_editor").each(function(){
            if($(this).css("visibility")=="hidden"){
                $(this).remove();
                guardar_pl();
            }
        });
    }
    $(document).ready(function(){
        engine();
        //redim_canvas();
        updateEditor();
        resizando($(".wm_editor"));
        $(".m_widgets").each(function(){
            $(this).append('<div class="tooltip">'+$(this).attr("title")+'</div>');
        })
<?php
if ($params["esnuevo"]) {
    ?>
                $("#nuevotab").dialog({
                    modal:true,
                    buttons:{},
                    width:596,
                    title:"<?= __("Getting Started") ?>"
                });
                $("#nttemplate").click(function(){
                    $("#edtemplates").click()
                    $("#nuevotab").dialog("close")
                    return false;
                })
    <?php
}
?>
    })
</script>
