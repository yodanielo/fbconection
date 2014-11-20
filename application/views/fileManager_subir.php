<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title></title>
        <style type="text/css">
            *{
                margin:0px;
                padding: 0px;
                font-family: Arial,Helvetica,sans-serif;
                font-size: 14px;
                color:#6F6F6F;
                border:none;
            }
            #fmfile{
                float:left;
                width:250px;
                margin-right:10px;
            }
            #fmfile input{
                width:100%;
                height:18px;
                float:left;
                border:none;
            }
            label{
                float:left;
                width:120px;
                margin-right: 10px;
                line-height: 20px;
                height:20px;
            }
            #btnupload{
                float:left;
                width:100px;
                height:22px;
                line-height:20px;
                cursor:pointer;
                border:1px solid #CECECF;
                background:#fff;
                -moz-border-radius: 5px;
                -webkit-border-radius: 5px;
            }
            body{
                border:none;
                padding-left: 10px;
                padding-top: 2px;
            }
        </style>
        <link rel="stylesheet" type="text/css" href="<?=$this->getURL("css/jquery.inputfile.css")?>" /> 
        <script type="text/javascript" src="<?=$this->getURL("js/jquery-1.4.4.min.js")?>"></script>
        <script type="text/javascript" src="<?=$this->getURL("js/jQuery.fileinput.js")?>"></script>
    </head>
    <body>
        <?php
        switch ($params["estado"]) {
            case "1":
                ?>
                File uploaded succesfully.
                <script type="text/javascript">
                    function addFile(a,b){
                        <?php
                        if(in_array($params["ext"], array("jpg","gif","png")))
                            $params["archivo31"]="/users/".md5($_SESSION["fbconexion"]["id"])."/".$params["archivo1"];
                        else
                            $params["archivo31"]=$this->getURL("/images/mymes/ico_".$params["ext"].".jpg");
                        ?>
                        cad1='<a onclick="return fmclicklink(this)" href="#<?=$params["archivo1"]?>"><img src="<?=$this->getURL("images/mymes/ico_".$params["ext"].".jpg")?>"/>&nbsp;<?=$params["archivo2"]?></a>';
                        cad2='<a onclick="return fmclicklink(this)" href="#<?=$params["archivo1"]?>"><img src="<?=$this->getURL("filemanager/resizeicons?file=".$this->getURL($params["archivo31"]))?>"/><br/><?=$params["archivo3"]?></a>';
                        window.parent.document.getElementById("vistalista").innerHTML+=cad1;
                        window.parent.document.getElementById("vistaicons").innerHTML+=cad2;
                        window.parent.setused(<?=$params["size"]?>);
                        
                    }
                        addFile();
                    function revertir(){
                        location.href = location.href;
                    }
                    setTimeout(revertir, 2000);
                </script>
                <?php
                break;
            case "2":
                ?>
                Sorry, your file couldn't uploaded, the disk is full.
                <script type="text/javascript">
                    function revertir(){
                        location.href = location.href;
                    }
                    setTimeout(revertir,2000);
                </script>
                <?php
                break;
            case "3":
                ?>
                Sorry, your file couldn't uploaded, the file already exists.
                <script type="text/javascript">
                    function revertir(){
                        location.href = location.href;
                    }
                    setTimeout(revertir,2000);
                </script>
                <?php
                break;
            case "4":
                ?>
                Sorry, the file doesn't contain a compatible file type
                <script type="text/javascript">
                    function revertir(){
                        location.href = location.href;
                    }
                    setTimeout(revertir,2000);
                </script>
                <?php
                break;
            default:
                ?>
                <div id="todoelform">
                <form action="<?=$this->getURL("filemanager/subirform")?>" method="post" name="frmsubir" id="frmsubir" enctype="multipart/form-data">
                    <label for="fmfile">Upload File:</label>
                    <div id="fmfile"><input type="file" name="fmfile" /></div>
                    <input type="submit" id="btnupload" value="Upload"/>
                </form>
                </div>
                <div id="mensajedelform" style="display:none">
                    Your file is being uploaded.
                </div>
                <script type="text/javascript">
                    function alsubir(){
                        if(document.frmsubir.fmfile.value==""){
                            return false;
                        }
                        else{
                            extensiones="jpg,gif,png,swf,flv,pdf,doc".split(",");
                            archivo=document.frmsubir.fmfile.value;
                            e=archivo.split(".");
                            r=false;
                            for(i=0;i<extensiones.length;i++){
                                if(e[e.length-1].toLowerCase()==extensiones[i])
                                    r=true;
                            }
                            if(r){
                                $("#todoelform").hide();
                                $("#mensajedelform").show();
                                $("#frmsubir").submit();
                            }
                        }
                    }
                    $("#btnupload").click(alsubir);
                    $("#fmfile input").customFileInput();	
                </script>
                <?php
                break;
        }
        ?>
    </body>
</html>
