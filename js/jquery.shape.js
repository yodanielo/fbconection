$.fn.shape=function(estilo,colorLinea){
    $(this).each(function(){
        bw1=this.width;
        bh1=this.height;
        $(this).attr("width",bw1);
        $(this).attr("height",bh1);
        todo=this;
        function draw(xxx){
            try{
                cxt=xxx.getContext("2d");
                cxt.clearRect ( 0, 0 , bw1 , bh1 );
                cxt.fillStyle=colorLinea;
                cxt.beginPath();
                switch(estilo){
                    case 0://flecha izquierda
                        cxt.moveTo(bw1,bh1*0.25);
                        cxt.lineTo(bw1,bh1*0.75);
                        cxt.lineTo(bw1*0.25,bh1*0.75);
                        cxt.lineTo(bw1*0.25,bh1);
                        cxt.lineTo(0,bh1*0.50);
                        cxt.lineTo(bw1*0.25,0);
                        cxt.lineTo(bw1*0.25,bh1*0.25);
                        cxt.lineTo(bw1,bh1*0.25);
                        break;
                    case 1://flecha derecha
                        cxt.moveTo(0,bh1*0.25);
                        cxt.lineTo(bw1*0.75,bh1*0.25);
                        cxt.lineTo(bw1*0.75,0);
                        cxt.lineTo(bw1,bh1*0.50);
                        cxt.lineTo(bw1*0.75,bh1);
                        cxt.lineTo(bw1*0.75,bh1*0.75);
                        cxt.lineTo(0,bh1*0.75);
                        cxt.lineTo(0,bh1*0.25);
                        break;
                    case 2://circulo
                        cxt.moveTo(bw1*0.50, 0);
                        cxt.bezierCurveTo(bw1, 0,bw1, bh1,bw1*0.50, bh1);
                        cxt.bezierCurveTo(0, bh1,0, 0,bw1*0.50, 0);
                        break;
                    case 3://cuadrado
                        cxt.moveTo(0, 0);
                        cxt.lineTo(bw1, 0);
                        cxt.lineTo(bw1, bh1);
                        cxt.lineTo(0, bh1);
                        cxt.lineTo(0, 0);
                        break;
                    case 4://doble flecha horizontal
                        cxt.moveTo(0, bh1*0.5);
                        cxt.lineTo(bw1*0.25, 0);
                        cxt.lineTo(bw1*0.25, bh1*0.25);
                        cxt.lineTo(bw1*0.75, bh1*0.25);
                        cxt.lineTo(bw1*0.75, 0);
                        cxt.lineTo(bw1, bh1*0.5);
                        cxt.lineTo(bw1*0.75, bh1);
                        cxt.lineTo(bw1*0.75, bh1*0.75);
                        cxt.lineTo(bw1*0.25, bh1*0.75);
                        cxt.lineTo(bw1*0.25, bh1);
                        cxt.lineTo(0, bh1*0.5);
                        break;
                    case 5://triangulo
                        cxt.moveTo(bw1*0.50, 0);
                        cxt.lineTo(bw1, bh1);
                        cxt.lineTo(0, bh1);
                        cxt.lineTo(bw1*0.5, 0);
                        break;
                    case 6://flecha arriba
                        cxt.moveTo(bw1*0.50, 0);
                        cxt.lineTo(bw1, bh1*0.25);
                        cxt.lineTo(bw1*0.75, bh1*0.25);
                        cxt.lineTo(bw1*0.75, bh1);
                        cxt.lineTo(bw1*0.25, bh1);
                        cxt.lineTo(bw1*0.25, bh1*0.25);
                        cxt.lineTo(0, bh1*0.25);
                        cxt.lineTo(bw1*0.50, 0);
                        break;
                    case 7://flecha abajo
                        cxt.moveTo(bw1*0.25, 0);
                        cxt.lineTo(bw1*0.75, 0);
                        cxt.lineTo(bw1*0.75, bh1*0.75);
                        cxt.lineTo(bw1, bh1*0.75);
                        cxt.lineTo(bw1*0.50, bh1);
                        cxt.lineTo(0, bh1*0.75);
                        cxt.lineTo(bw1*0.25, bh1*0.75);
                        cxt.lineTo(bw1*0.25, 0);
                        break;
                }
                cxt.closePath();
                cxt.fill();
                //cxt.stroke();
            }
            catch(Ex){
                
            }

        }
        function checkdims(objeto){
            //if(bw1!=$(objeto).width() || bh1!=$(objeto).height()){
            bw1=$(objeto).width();
            bh1=$(objeto).height();
            $(objeto).attr("width",bw1);
            $(objeto).attr("height",bh1);
            draw(objeto);
            //}
        }
        draw(this);
        
        setInterval(checkdims, 450,this);
    })
}