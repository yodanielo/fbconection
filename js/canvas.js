$.fn.galeria1=function(images){
    todo=this;
    ixg=4;
    hacerGaleria=function(){
        $(todo).each(function(){
                        
            galeria=this;
            $(this).append('<div class="galeria1-thumbs"></div>');
            $(this).append('<div class="galeria1-big"></div>');
            $(this).append('<div class="galeria1-navigator"><a class="galeria1-prev" href="#"><img src="http://www.fbconexion.com/images/gal_prev.png" alt="" />Prev</a><a class="galeria1-next" href="#">Next<img src="http://www.fbconexion.com/images/gal_next.png" alt="" /></a></div>');
            //lleno las imagenes
            cad1='';
            cad2='';
            cad3='';
            for(i=0;i<images.length;i++){
                img=images[i];
                cad2+='<div class="galeria1_ibig"><img src="'+img["src"]+'" alt="'+img["title"]+'" /></div>';
                cad3+='<div class="galeria1_item"><div class="galeria1_timg"><img src="'+img["src"]+'" alt="'+img["title"]+'" /></div></div>';
                if(i%ixg==0 || i==images.length-1){
                    cad1+='<div class="galeria1-group">'+cad3+'</div>';
                    cad3='';
                }
            }
            $(this).find(".galeria1-thumbs").html(cad1);
            $(this).find(".galeria1-big").html(cad2);
            //pongo dimensiones
            $(this).find(".galeria1-big, .galeria1_ibig").width($(this).width()-260);
            $(this).find(".galeria1-big, .galeria1_ibig").height($(this).height());
            $(this).find(".galeria1_ibig img").css({
                "max-width":$(this).width()-260,
                "max-height":$(this).height()
            });
            $(this).find(".galeria1_ibig:first").show();
            //animaciones
            $(this).find(".galeria1-thumbs").cycle({
                prev:$(this).find(".galeria1-prev"),
                next:$(this).find(".galeria1-next"),
                fx:'scrollLeft',
                speed:'fast',
                timeout:0,
                fastOnEvent: false
            });
            $(this).find(".galeria1_item").click(function(){
                index=$(".galeria1_item").index(this);
                $(galeria).find(".galeria1_ibig").fadeOut(450, function(){});
                $(galeria).find(".galeria1_ibig:eq("+index+")").fadeIn(450, function(){});
                
            })
        })
    }
    if(!$.cycle)
        $.getScript("http://www.fbconexion.com/js/jquery.cycle.js", function(){
            hacerGaleria();
        });
    else
        hacerGaleria();
}

$.fn.galeria3=function(images){
    todo=this;
    hacerGaleria=function(){
        $(todo).each(function(){
            galeria=$(this);
            marca="x"+Math.ceil(Math.random()*100000);
            cw=galeria.parent().width();
            ch=galeria.parent().height();
            galeria.append('<div class="g3contimages"></div>');
            for(i=0;i<images.length;i++){
                img=images[i];
                galeria.find(".g3contimages").append('<div class="g3-item"><img src="'+img["src"]+'" title="'+img["title"]+'" /></div>');
            }
            galeria.append('<div class="g3controles"><a class="g3fizq" id="'+marca+'izq"></a><a class="g3fder" id="'+marca+'der"></a></div>');
            galeria.find(".g3-item img").css({
                "max-width":cw,
                "max-height":ch
            });
            galeria.find(".g3fizq, .g3fder").css({
                "width":(cw/2),
                "height":ch
            });
            galeria.find(".g3-item,.g3controles").css({
                "width":cw,
                "height":ch
            });
            galeria.find(".g3contimages").css({
                "width":cw,
                "height":ch
            })
            galeria.find(".g3contimages").cycle({
                fx:"fade",
                speed:  'fast', 
                timeout: 0, 
                next:   $('#'+marca+'izq'), 
                prev:   $('#'+marca+'der')
            });
        })
    }
    if(!$.cycle)
        $.getScript("http://www.fbconexion.com/js/jquery.cycle.js", function(){
            hacerGaleria();
        });
    else
        hacerGaleria();
}

$.fn.galeria4=function(images){
    $(this).each(function(){
        galeria=this;
        cw=$(galeria).width()/2-10
        ch=$(galeria).width()/2-10
        /*cw=240;
        ch=240;*/
        for(i=0;i<images.length;i++){
            img=images[i];
            $(galeria).append('<div class="galeria4-item"><img src="'+img["src"]+'" title="'+img["title"]+'" /></div>');
        }
        $(galeria).find(".galeria4-item").width(cw);
        $(galeria).find(".galeria4-item").height(ch);
        $(galeria).find(".galeria4-item img").load(function(){
            $(galeria).find(".galeria4-item img").each(function(){
                index=$(galeria).find("img").index(this);
                images[index]["width"]=this.width;
                images[index]["height"]=this.height;
            })
            $(galeria).find(".galeria4-item img").hover(function(){
                index=$(galeria).find("img").index(this);
                if(images[index]["width"]*1>images[index]["height"]*1){
                    $(this).stop().animate({
                        height:ch
                    }, 450, "linear", function(){})
                }
                else{
                    $(this).stop().animate({
                        width:cw
                    }, 450, "linear", function(){})
                }
            },function(){
                index=$(galeria).find("img").index(this);
                if(images[index]["width"]>images[index]["height"]){
                    $(this).stop().animate({
                        height:images[index]["height"]
                    }, 450, "linear", function(){})
                }
                else{
                    $(this).stop().animate({
                        width:images[index]["width"]
                    }, 450, "linear", function(){})
                }
            })
        });
    });
}

$.fn.listadoYoutube=function(eseditor,videos,descs,bw,bh){
    sacarVid=function(url){
        if(url.indexOf("youtube.be")>=0){
            return url.split("http://youtu.be/").join("");
        }else{
            a1=url.split("?");
            a2=a1[1].split("&");
            return a2[0].split("v=").join("");
        }
    }
    $(this).each(function(){
        galeria=this;
        //http://www.youtube.com/watch?v=fjfmE0ZEZKg&feature=feedrec_grec_index
        $(this).append('<div class="encasoeditor"><iframe class="videoprin" frameborder="0" allowfullscreen></iframe></div>');
        $(this).append('<div class="listvideos"></div>');
        anchovid=Math.floor((bw-96)/3);
        for(i=0;i<videos.length;i++){
            v=videos[i];
            if(descs!=null)
                d=descs[i];
            else
                d="";
            idv=sacarVid(v);
            cad='<div class="lvicont"><a class="listvideoitem '+idv+'" href="#'+idv+'"><img src="http://i4.ytimg.com/vi/'+idv+'/default.jpg"/>'+d+'</a></div>';
            $(galeria).find(".listvideos").append(cad);
            if(!eseditor){
                $(galeria).find("."+idv).click(function(){
                    idvideo=$(this).attr("href").split("#").join("");
                    $(galeria).find(".videoprin").attr("src","http://www.youtube.com/embed/"+idvideo);
                    return false;
                });
            }
        //$(galeria).find(".videoprin").attr("src","http://www.youtube.com/embed/"+idv);
        }
        $(this).find(".videoprin")[0].width=bw;
        $(this).find(".videoprin")[0].height=(bw*0.796875);
        $(this).find(".listvideos")[0].width=(bw);
        //$(this).find(".listvideoitem")[0].width=(bw-22);
        //$(this).find(".listvideoitem img").width(anchovid);
        if(!eseditor){
            $(this).find(".listvideoitem:first").click();
        }else{
            $(this).find(".encasoeditor").html('<img style="width:100%;" src="'+$(this).find(".listvideoitem:first img").attr("src").split("default.jpg").join("hqdefault.jpg")+'" />')
        }
    })
}