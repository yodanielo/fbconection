<?php

class Ccaptcha extends application {

    function image($token) {
        //genero el texto
        $captcha_texto = "";
        $caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789";
        for ($i = 1; $i <= 6; $i++) {
            mt_srand((double) microtime() * 1000000);
            $valor_aleatorio = mt_rand(0, strlen($caracteres) - 1);
            $captcha_texto .= $caracteres[$valor_aleatorio];
        }
        $_SESSION["captcha"][$token] = $captcha_texto;
        unset($captcha_texto);
        //genero la imagen
        //creamos la imagen definiendo el tamaño del alto y el ancho (140, 35)
        $captcha_imagen = imagecreate(152, 37);
        //creamos el color negro para el fondo y blanco para los caracteres
        $color_negro = imagecolorallocate($captcha_imagen, 0, 0, 0);
        $color_blanco = imagecolorallocate($captcha_imagen, 255, 255, 255);
        //pintamos el fondo con el cplor negro creado anteriormente
        imagefill($captcha_imagen, 0, 0, $color_negro);
        //iniciamos la session para obtener los caracteres a dibujar
        $captcha_texto = $_SESSION["captcha"][$token];
//dibujamos los caracteres de color blanco
        imagechar($captcha_imagen, 4, 10, 8, $captcha_texto[0], $color_blanco);
        imagechar($captcha_imagen, 5, 30, 8, $captcha_texto[1], $color_blanco);
        imagechar($captcha_imagen, 3, 50, 8, $captcha_texto[2], $color_blanco);
        imagechar($captcha_imagen, 4, 70, 8, $captcha_texto[3], $color_blanco);
        imagechar($captcha_imagen, 5, 90, 8, $captcha_texto[4], $color_blanco);
        imagechar($captcha_imagen, 3, 110, 8, $captcha_texto[5], $color_blanco);
//indicamos que lo que vamos a mostrar es una imagen
        header("Content-type: image/jpeg");
//mostramos la imagen
        imagejpeg($captcha_imagen);
    }
    function check($token){
        if(strtolower($_SESSION["captcha"][$token])==strtolower($_POST["value"])){
            echo  "1";
        }else{
            echo "0";
        }
    }
}

?>
