<?php
$obj = $params["obj"];
$str = $params["str"];
switch ($str->edb_w2) {
    case "Image":
        $files = "'jpg','png','gif'";
        break;
    case "Video":
    default:
        $files = "'mp4','flv'";
        break;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo ($params["pagetitle"] ? trim($params["pagetitle"]) . " | " : "") . 'FB Conexion'; ?></title>
        <meta name="Description" content="<?php echo ($params["sitedescription1"]); ?>" />
        <meta name="author" content="Daniel Pomalaza" />
        <meta name="owner" content="Online Conexion" />
        <?php
        if ($params["follow"])
            echo '<meta name="robots" content="index, follow" />';
        else
            echo '<meta name="robots" content="noindex, nofollow"/>';
        ?>
        <link rel="icon" href="<?php echo $this->getURL("images/favicon.ico") ?>" type="image/x-icon" />
        <?php
        if (count($params["css"]) > 0) {
            foreach ($params["css"] as $key => $sc) {
                if (substr($sc, 0, 7) == "http://" || substr($sc, 0, 8) == "https://")
                    echo '<link rel="stylesheet" type="text/css" href="' . $sc . '" />' . "\n";
                else
                    echo '<link rel="stylesheet" type="text/css" href="' . $this->getURL('/css/' . $sc) . '" />' . "\n";
            }
        }
        ?>
        <script type="text/javascript">lang="<?= LANG ?>"</script>
        <script type="text/javascript" src="<?= $params["livesite"] ?>/js/jquery-1.4.4.min.js"></script>
        <style type="text/css">
            * {
                margin: 0px;
                padding: 0px;
                font-family: Arial;
                font-size: 12px;
            }
            #wrapper {
                width: 520px;
                overflow: hidden;
                margin: 0px auto;
            }
            label {
                display: block;
                line-height: 20px;
                float:left;
                width:250px;
            }
            #txt1,
            #txt2{
                float:left;
                display:block;
                border:1px solid #cececf;
                width:248px;
                height:25px;
                line-height: 25px;
                border-radius:5px;
            }
            #btn1{
                float: right;
                white-space: nowrap;
                padding: 5px;
                background: #000;
                color:#fff;
                margin-top: 5px;
                border:none;
                border-radius:5px;
            }
            #txt3{
                float:left;
                width:518px;
                height:100px;
                border:1px solid #cececf;
                border-radius:5px;
            }
        </style>
    </head>
    <body>
        <div id="fb-root"></div>
        <script type="text/javascript">
            logged=false;
            loguear=function(){
                FB.getLoginStatus(function(response) {
                    if (response.status=="connected") {
                        logged=true;
                        $("#fba").val(response.authResponse.userID);
                    } else {
                        FB.login(function(response) {
                            if (response.status=="connected") {
                                logged=true;
                                $("#fba").val(response.authResponse.userID);
                            }
                        }, {scope: 'email'});
                    }
                });
            }
            window.fbAsyncInit = function() {
                FB.init({
                    appId: '<?= $params["fbcred"]["id"] ?>',
                    status: true, 
                    cookie: true,
                    xfbml: true,
                    //channelUrl  : 'http://www.fbconexion.com/channel.html',
                    oauth : true
                });
                function autores(){
                    FB.Canvas.setAutoResize();
                    setTimeout(autores, 450);
                }
                autores();
                //loguear();

            };
            (function() {
                e = document.createElement('script'); 
                e.async = true;
                e.src = document.location.protocol +
                    '//connect.facebook.net/en_US/all.js';
                document.getElementById('fb-root').appendChild(e);
            }());
        </script>
        <div id="wrapper">
            <?php 
            if(isset($params["okok"])){
                if($params["okok"])
                    echo "bien";
                else
                    echo "mal";
            }
            ?>
            <form name="frmsubirform" id="frmsubirform" action="<?=$this->getURL("tabs/wcontest_form/".$params["idc"]."/index.php")?>" method="post" enctype="multipart/form-data">
                <label>Enter your file URL here</label>
                <label style="float:right;">Or submit your file here</label>
                <input type="text" name="txt1" id="txt1" />
                <input style="float:right;" type="file" name="txt2" id="txt2" />
                <label>Enter a description</label>
                <textarea name="txt3" id="txt3"></textarea>
                <input type="hidden" name="fba" id="fba" value=""/>
                <input type="submit" id="btn1" value="Send" />
            </form>
        </div>
        <script type="text/javascript">
            
            $("#frmsubirform").submit(function(){
                if(logged){
                    archivo=$("#txt1").val();
                    if($("#txt2").val()!="")
                        archivo=$("#txt2").val();
                    if(archivo!=""){
                        aux=archivo.split(".");
                        ext=aux[aux.length-1].toLowerCase();
                        fs=new Array(<?= $files ?>);
                        pasa=false;
                        for(i=0;i<fs.length;i++){
                            if(fs[i]==ext){
                                pasa=true;
                            }
                        }
                        if(pasa==false){
                            alert("Allowed filetypes: <?= str_replace("'", "", $files) ?>");
                            return false;
                        }else{
                            if($("#txt3").val()==""){
                                alert("There is no a description.");
                                return false;
                            }
                        }
                    }
                    else{
                        alert("There is no file to be sent.")
                        return false;
                    }
                }
                else{
                    alert("First you need to be logged.");
                    loguear();
                    return false;
                }
            })
        </script>
    </body>
</html>