$.fn.gradient=function(settings){
    if(!$.browser.msie){
        original={
            type:"linear",
            width:100,
            height:100,
            colors:["#000000","#ffffff"]
        };
        settings=$.extend(original,settings);
        w=settings["width"];
        h=settings["height"];
        colors=settings["colors"];
        $(this).each(function(){
            switch(settings["type"]){
                case "lineal":
                    var ctx = this.getContext('2d');
                    var lingrad = ctx.createLinearGradient(0,0,0,h);
                    rad=1/colors.length;
                    for(i=0;i<colors.length-1;i++){
                        lingrad.addColorStop(i*rad+0.01, colors[i]);
                    }
                    lingrad.addColorStop(1, colors[colors.length-1]);
                    ctx.fillStyle=lingrad;
                    ctx.fillRect(0,0,w,h);
                    break;
                case "radial":
                    rad=(w<h?w/2:h/2);
                    var ctx = this.getContext('2d');
                    var radgrad = ctx.createRadialGradient(rad,rad,0,rad,rad,rad);
                    r=1/colors.length;
                    for(i=0;i<colors.length-1;i++){
                        radgrad.addColorStop(i*r+0.01, colors[i]);
                    }
                    radgrad.addColorStop(1, colors[colors.length-1]);
                    
                    ctx.fillStyle=radgrad;
                    ctx.fillRect(0,0,w,h);
                    break;
            }
        })
    }
}