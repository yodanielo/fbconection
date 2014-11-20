<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>a</title>
        <link type="text/css" rel="stylesheet" href="<?= $this->getURL("application/views/customized/fbconexion/nav.css") ?>" />
        <script type="text/javascript" src="http://www.fbconexion.com/onlineco/js/jquery-1.4.4.min.js"></script>
        <style type="text/css">
            *{
                font-size:12px;
            }
        </style>
    </head>
    <body>
        <div id="wrapper" id="bodyplans">
            <div style="float:right">
                <a style="padding: 5px;" target="_parent" href="http://www.facebook.com/Fan.Page.Latino?sk=app_165906066853430"><img src="http://www.fbconexion.com/images/flag_peru.png"></a>
                <a style="padding: 5px;" target="_parent" href="http://www.facebook.com/online.conexion?sk=app_165906066853430"><img src="http://www.fbconexion.com/images/usa_flag.png"></a>
            </div>
            <div id="cuadronews">
                <form method="post" id="frmpromo" action="#">
                    <div id="newsnota">Enter your Email and get the latest Updates of our Blog</div>
                    <div class="frow">
                        <label for="">Name</label>
                        <input type="text" class="" alt="" id="txtpromoemail" />
                    </div>
                    <div class="frow">
                        <label for="">E-mail</label>
                        <input type="text" class="" alt="" id="txtpromoenombre" />
                    </div>
                    <div class="frow">
                        <input type="submit" class="" value="OK"/>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
            $("#frmpromo").submit(function(){
                m=$("#txtpromoenombre").val();
                n=$("#txtpromoemail").val();
                r=true;
                if(m.split("@").length!=2)
                    r=false;
                else
                    if(m.split("@")[1].indexOf(".")==-1)
                        r=false;
                if(n=="")
                    r=false;
                if(r==true){
                    $.ajax({
                        url:"http://www.fbconexion.com/blog/<?= LANG ?>",
                        type:"post",
                        data:"na=s&nr=widget&ne="+encodeURIComponent(m)+"&nn="+encodeURIComponent(n),
                        success:function(data){
                            alert("you've subscribed!!")
                        }
                    })
                    $("#txtpromoemail").val("");
                    $("#txtpromoenombre").val("");
                }else{
                    alert("Something went wrong");
                }
                return false;
            });
        </script>
    </body>
</html>
