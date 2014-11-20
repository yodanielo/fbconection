<html>
    <head></head>
    <body>
        <div style="width:600px; float:left;">
            <form method="post">
                <label>Texto</label><br/>
                <textarea name="texto" style="width:400px; height:100px;"></textarea><br/>
                <label>Origen</label>
                <div>
                    <label><input type="radio" name="origen" value="1" checked="checked"/>Texto</label>
                    <label><input type="radio" name="origen" value="2"/>Hexadecimal</label>
                    <label><input type="radio" name="origen" value="3"/>Binario</label>
                </div>
                <br/>
                <input type="submit"/>
            </form>
        </div>
        <?php
        if ($_POST["texto"]) {
            $v = trim($_POST["texto"]);
            $texto = "";
            $binario = "";
            $hexadecimal = "";
            switch ($_POST["origen"]) {
                case 1://texto
                    //convertir a hexadecimal y binario
                    $texto = $v;
                    $ar = str_split($v);
                    foreach ($ar as $a) {
                        $binario.=str_pad(decbin(ord($a)), 8, "0", STR_PAD_LEFT) . " ";
                        $hexadecimal.=str_pad(dechex(ord($a)), 2, "0", STR_PAD_LEFT) . " ";
                    }
                    break;
                case 2://hexadecimal
                    //convertir a texto y binario
                    $v=strrev($v);
                    $hexadecimal = $v;
                    $ar = explode(" ", $v);
                    foreach ($ar as $a) {
                        $texto.=chr(hexdec($a));
                        $binario.=str_pad(decbin(hexdec($a)), 8, "0", STR_PAD_LEFT) . " ";
                    }
                    break;
                case 3://binario
                    //convertir a hexadecimal y texto
                    $binario = $v;
                    $ar = explode(" ", $v);
                    foreach ($ar as $a) {
                        $hexadecimal .= str_pad(dechex(bindec(intval($a))), 2, "0", STR_PAD_LEFT) . " ";
                        $texto .= chr(bindec($a));
                    }
                    break;
            }
            ?>
            <div style="float:left;clear:both; width:400px; height:100px; margin-top:10px; border:1px solid #000; overflow: auto;">
                <?=$texto?>
            </div> 
            <div style="float:left;clear:both; width:400px; height:100px; margin-top:10px; border:1px solid #000; overflow: auto;">
                <?=$hexadecimal?>
            </div> 
            <div style="float:left;clear:both; width:400px; height:100px; margin-top:10px; border:1px solid #000; overflow: auto;">
                <?=$binario?>
            </div> 
            <?php
        }
        ?>
    </body>
</html>