<?php

class Ltextlibs extends object {

    /**
     * limitar el numero de caracteres de una cadena cortandolo al final
     * @param String $str el texto a ser acortado
     * @param Integer $n el numero limite de letras
     * @param String $end_char el caracter con que finaliza la cadena en caso tenga que ser cortada
     * @return type 
     */
    function limitarLetras($str, $n = 500, $end_char = '&#8230;') {
        if (strlen($str) < $n)
            return $str;
        $str = preg_replace("/\s+/", ' ', str_replace(array("\r\n", "\r", "\n"), ' ', $str));
        if (strlen($str) <= $n)
            return $str;
        $out = "";
        foreach (explode(' ', trim($str)) as $val) {
            $out .= $val . ' ';
            if (strlen($out) >= $n) {
                $out = trim($out);
                return (strlen($out) == strlen($str)) ? $out : $out . $end_char;
            }
        }
    }

    /**
     * limitar el numero de caracteres de una cadena cortandolo al centro
     * @param String $str el texto a ser acortado
     * @param Integer $n el numero limite de letras
     * @param String $end_char el caracter con que finaliza la cadena en caso tenga que ser cortada
     * @return type 
     */
    function limitarCentroLetras($str, $n=500, $end_char='&#8230;') {
        $str = preg_replace("/\s+/", ' ', str_replace(array("\r\n", "\r", "\n"), ' ', $str));
        if (strlen($str) <= $n)
            return $str;
        $out = "";
        $l1 = ceil($n / 2 - 1);
        $l2 = $n - $l1;
        $cad = substr($str, 0, $l1) . $end_char . substr($str, $l2 * -1);
        return $cad;
    }

    /**
     * transforma a links los correos y urls de un texto plano
     * @param type $texto 
     */
    function toLinks($texto) {
        if (trim($texto) != "") {
            $palabras = explode(" ", $texto);
            foreach ($palabras as $k => $p) {
                if (preg_match("/(.+)@(.+)\.(.+)/", $p) > 0) {
                    $palabras[$k] = '<a href="mailto:' . $p . '">' . $p . '</a>';
                } elseif (preg_match("/(www\.)(.+)(\.)(.+)/", $p)) {
                    $palabras[$k] = '<a target="_blank" href="' . $p . '">' . $p . '</a>';
                }
            }
            return implode(" ", $palabras);
        } else {
            return "";
        }
    }

    /**
     * retorna la fecha en texto y de forma aproximada
     * @param int tiempo en unix format
     * @return string
     */
    function fechainexacta($t) {
        if($t=="")
            return false;
    $s = mktime() - $t + 3600;
    $l = $_SESSION["lang"];
    //echo mktime()." / ".$t;
    if ($s < 60) {
        return ($l == "es" ? "Hace pocos segundos" : "Few seconds ago");
    } else {
        //minutos
        $m = ($s - ($s % 60)) / 60;
        if ($m == 1) {
            $cad = ($l == "es" ? "1 minuto" : "1 minute");
        } elseif ($m > 1) {
            $aux = $m % 60;
            $cad = ($l == "es" ? "$aux minutos" : "$aux minutes");
        }
        //horas
        $h = ($m - ($m % 60)) / 60;
        if ($h == 1) {
            $cad = ($l == "es" ? "1 hora" : "1 hour") . ($cad != "" ? ($l == "es" ? " y " : " and ") . $cad : "");
        } elseif ($h > 1) {
            $aux = $h % 24;
            $cad = ($l == "es" ? "$aux horas" : "$aux hours") . ($cad != "" ? ($l == "es" ? " y " : " and ") . $cad : "");
        }
        //days
        $d = ($h - ($h % 24)) / 24;
        if ($d == 1) {
            $cad = ($l == "es" ? "1 día" : "1 day") . ($cad != "" ? ", " . $cad : "");
        } elseif ($d > 1 && $d <= 2) {
            $cad = ($l == "es" ? "$d días" : "$d days") . ($cad != "" ? ", " . $cad : "");
        } else {
            $cad = "";
        }
        if ($cad != "")
            return ($l == "es" ? "Hace " . $cad : $cad . " ago") . ".";
        else {
            $fecha = date("l F d, Y \a\t h:i a", $t);
            if ($l == "es") {
                $fecha = date("l d \d\e F \d\e Y \a \l\a\s  h:i a", $t);
                $meses_en = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
                $meses_es = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                $dias_en = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
                $dias_es = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
                $fecha = str_replace($meses_en, $meses_es, $fecha);
                $fecha = str_replace($dias_en, $dias_es, $fecha);
            }
            return $fecha;
        }
    }
}

}

?>
