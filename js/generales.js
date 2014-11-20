function isdefined( variable)
{
    return (typeof(window[variable]) == "undefined")?  false: true;
}
if(isdefined("$zopim"))
    $zopim(function() {
        /*$zopim.livechat.setLanguage('es')*/
        $zopim.livechat.window.setColor('#000000');
    });
$.fn.starcount=function(){
    clase=".tescroller";
        $(this).mouseup(function(e){
            x=Math.ceil((e.pageX-$(this).offset().left)/20)*20;
            $(this).find(clase).width(x);
            $(this).attr("alt",x/20);
        })
}
$.fn.Dtabs=function(contents){
    todo=this;
    $(this).click(function(){
        indice=$(todo).index(this);
        $(todo).removeClass("active");
        $(this).addClass("active");
        a=$(contents)[indice];
        $(contents).slideUp(450, function(){});
        Dtabs_expand=function(){
            $(a).slideDown(450, function(){});
        }
        setTimeout(Dtabs_expand, 450);
        return false;
    });
    $(this).filter(":first").click();
}
$.fn.autogrow = function(options) {
    this.filter('textarea').each(function() {
        var $this       = $(this),
        minHeight   = $this.height(),
        lineHeight  = $this.css('lineHeight');
        var shadow = $('<div></div>').css({
            position:   'absolute',
            top:        -10000,
            left:       -10000,
            width:      $(this).width() - parseInt($this.css('paddingLeft')) - parseInt($this.css('paddingRight')),
            fontSize:   $this.css('fontSize'),
            fontFamily: $this.css('fontFamily'),
            lineHeight: $this.css('lineHeight'),
            resize:     'none'
        }).appendTo(document.body);
        var update = function() {
    
            var times = function(string, number) {
                for (var i = 0, r = ''; i < number; i ++) r += string;
                return r;
            };
                
            var val = this.value.replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/&/g, '&amp;')
            .replace(/\n$/, '<br/>&nbsp;')
            .replace(/\n/g, '<br/>')
            .replace(/ {2,}/g, function(space) {
                return times('&nbsp;', space.length -1) + ' '
            });
                
            shadow.html(val);
            $(this).css('height', Math.max(shadow.height() + 20, minHeight));
            
        }
        $(this).change(update).keyup(update).keydown(update);
        update.apply(this);
    });
    return this;
}
function fmanager(a,b,c){
    $(a).click(function(){
        if(c==null)
            destino=$(this).attr("href");
        else
            destino=c;
        $.ajax({
            url:"/filemanager/index/",
            data:"ext="+encodeURIComponent(b)+"&destino="+encodeURIComponent(destino),
            type:"POST",
            success:function(data){
                $("#fmanager").remove();
                $('<div id="fmanager"></div>').appendTo("body");
                $("#fmanager").html(data);
                $("#fmanager").dialog({
                    //draggable:false,
                    resizable:false,
                    title:"File Manager",
                    height:590,
                    width:700,
                    position:"top"
                });
            }
        });
        return false;
    });
}
function engine_form(id){
    $(id).find(".pacalendar").each(function(){
        $(this).datepicker({
            dateFormat:'mm-dd-yy'
        });
    });
    $(id).find(".pafmanager").each(function(){
        padre=$(this).parent(":first");
        mid=$(this).attr("id");
        $(this).after('<a class="edb_icopafile"></a>');
        $(this).animate({
            width:"-=22"
        }, 100, "linear", function(){});
        fmanager($(this).next(), "", "#"+mid);
    })
    $(id).find(".paurl").css({
        "background":"url(/images/prev_link.gif) no-repeat left",
        "padding-left":40
    }).animate({
        "width":"-=40"
    }, 100, "linear", function(){});
    engine_paurl=function(){
        $(id).find(".paurl").each(function(){
            value=$(this).val();
            if(value.indexOf("http://")!=-1 || value.indexOf("https://")!=-1)
                $(this).val(value.split("http://").join("").split("https://").join(""));
        })
        setTimeout(engine_paurl, 300);
    }
    setTimeout(engine_paurl, 300);
}
$.fn.couponValidator=function(){
    engine_form(this);
    todo=this;
    $(todo).find(".btn_delcou").click(function(){
        idcoupon=$(this).parent().parent().find(".couponid").val();
        esto=$(this).parent().parent().parent();
        $(this).hide();
        $.ajax({
            url:"/coupon/delCoupon/"+idtab+"/"+idcoupon,
            success:function(data){
                $(todo).find(".couponitem").val(data);
                $("#coudialogo").html("Coupon Deleted");
                $("#coudialogo").dialog({
                    title:"Alert",
                    modal:true,
                    buttons: {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    }
                });
                $(esto).remove();
            //esto.remove();
            //esto.fadeOut(450, function(){})
            }
        });
    })
    $(todo).find(".cousubtitle").click(function(){
        $(".coucuadroform").stop().slideUp(450, function(){});
        $(this).next(".coucuadroform").stop().slideDown(450, function(){});
    })
    $(todo).find(".cousubtitle:first").click();
    if($(todo).find(".couponitem").val()=="")
        $(todo).find(".cousubtitle").click();
    updateTitle=function(){
            if($(this).val()!=""){
                $(todo).find(".cousubtitle span").html($(this).val());
            }
            else{
                $(todo).find(".cousubtitle span").html("Coupon");
            }
        //setTimeout(updateTitle, 200, esto,todo)
    };
    $(todo).find(".cib3").blur(updateTitle);
    //setTimeout(updateTitle, 200, $(todo).find(".cib3"),todo)
    $(todo).find(".cib3").blur();
    $(todo).find(".frmcouitem").submit(function(){
        tpl=" field is mandatory.<br/>";
        msg="";
        $(this).find(".required").each(function(){
            if($(this).val().split(" ").join("")==""){
                msg+=$(this).attr("alt")+tpl;
            }
        })
        if(msg!=""){
            $("#coudialogo").html(msg);
            $("#coudialogo").dialog({
                modal:true,
                title:"Alert"
            })
        }
        else{
            cad='idtab='+idtab+"&idc="+$(todo).find(".couponitem").val();
            i=1;
            $(todo).find(".cibinput").each(function(){
                if($(this).hasClass("continy"))
                    cad+='&txt'+i+'='+encodeURIComponent(tinyMCE.get($(this).attr("id")).getContent());
                else
                    cad+='&txt'+i+'='+encodeURIComponent($(this).val());
                i++;
            });
            $.ajax({
                url:"/coupon/saveCoupon/",
                type:"POST",
                data:cad,
                success:function(data){
                    $(todo).find(".couponid").val(data);
                    $("#coudialogo").html("Coupon Saved");
                    $("#coudialogo").dialog({
                        title:"Alert",
                        modal:true,
                        buttons: {
                            "Ok": function() {
                                $(this).dialog("close");
                            }
                        }
                    });
                }
            });
        }
        return false;
    })
}
about_tab=function(){
    function animar(x,t){
        mt=x.style.marginTop.split("px").join("")*1;
        mt+=3;
        x.style.marginTop=mt+"px";
        if(mt>$("#contminis").height()+10)
            $(x).remove();
        else
            setTimeout(animar, t, x, t);
    }
    crear_mini=function(){
        elegido=Math.round(Math.random()*10);
        dbj=$(".mini")[elegido-1]
        obj=$(dbj).clone().appendTo("#contminis").removeClass("mini").addClass("miniclon");
        obj.css({
            "margin-left":Math.round(Math.random()*(490-obj.width()))
        });
        /*obj.animate({
                "margin-top":$("#contminis").height()+10
            }, Math.round(Math.random()*5000+1000), "linear", function(){
                $(this).remove();
            })*/
        animar(obj[0],Math.round(Math.random()*70+10));
        setTimeout(crear_mini, Math.round(Math.random()*700+100));
    }
    crear_mini();
}
$.fn.contactForm=function(settings){
    $(this).submit(function(){
        cad1="";
        cad2="";
        $(this).find(".required").each(function(){
            if($(this).val()==""){
                cad1+=$(this).attr("alt")+' field is mandatory.\n';
            }
            else{
                cad2+='&'+$(this).attr("rel")+'='+encodeURIComponent($(this).val());
            }
        });
        if(cad1!="")
            alert(cad1);
        else{
            $.ajax({
                url:"/tabs/processWContact",
                data:"token=1"+cad2+"&e2s="+encodeURIComponent(settings["e2s"])+"&e2r="+encodeURIComponent(settings["e2r"]),
                type:"POST",
                success:function(data){
                    alert(data);
                }
            })
        }
        return false;
    });
}