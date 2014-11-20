<?php

include("cls_MantixBase20.php");

class Registro extends MantixBase {

    function __construct() {
        $this->ini_datos("com_servicios", "id");
    }

    function formulario() {
        $m_Form = new MantixForm();
        $m_Form->atributos = array("texto_submit" => "Registro");
        $m_Form->datos = $this->datos;
        $m_Form->controles = array(
            array("label" => "Imagen:", "campo" => "imgservicios", "tipo" => "archivogg",
                "extensiones" => "*.jpg;*.png;*.gif",
                "descripcion" => "Imagen",
                "tooltip" => "Formatos esperados: jpg, png, gif"
            ),
            array("tipo" => "abre_grupo", "campo" => "espanol", "label" => "Español"),
            array("label" => "Título:", "campo" => "nombre_es"),
            array("label" => "Título Reducido:", "campo" => "reducido_es"),
            array("label" => "Slug:", "campo" => "slug_es"),
            array("label" => "Resumen:", "campo" => "resumen_es", "tipo" => "area"),
            array("label" => "Contenido:", "campo" => "contenido_es", "tipo" => "fck"),
            array("tipo" => "cierra_grupo"),
            array("tipo" => "abre_grupo", "campo" => "english", "label" => "English"),
            array("label" => "Título:", "campo" => "nombre_en"),
            array("label" => "Título Reducido:", "campo" => "reducido_en"),
            array("label" => "Slug:", "campo" => "slug_en"),
            array("label" => "Resumen:", "campo" => "resumen_en", "tipo" => "area"),
            array("label" => "Contenido:", "campo" => "contenido_en", "tipo" => "fck"),
            array("tipo" => "cierra_grupo"),
        );
        $res = $m_Form->ver();
        return $res;
    }

    function lista() {
        $r = new MantixGrid();
        $sql = "select * from com_servicios";
        $r->atributos = array("sql" => $sql, "nropag" => "20", "ordenar" => "id");
        $r->columnas = array(
            array("titulo" => "Título", "campo" => "nombre_es")
        );
        return $r->ver();
    }

    function slug($campo, $titulo) {
        $slug = $_POST[$campo];
        if (!$_POST[$campo])
            $slug = $_POST[$titulo];
        $de = array(
            "á", "é", "í", "ó", "ú", "ñ", "Á", "É", "Í", "Ó", "Ú", "Ñ", "_", " "
        );
        $a = array(
            "a", "e", "i", "o", "u", "n", "a", "e", "i", "o", "u", "N", "-", "-"
        );
        $slug = strtolower(str_replace($de, $a, $slug));
        $atrar = str_split($slug);
        $str1 = "";
        foreach ($atrar as $c) {
            if ((ord($c) <= 47 || (ord($c) >= 58 && ord($c) <= 64) || (ord($c) >= 91 && ord($c) <= 96) || ord($c) >= 123) && ord($c) != 45) {
                //no se hace nada, jaja
            } else {
                $str1.=$c;
            }
        }
        $this->datos->agregar($campo, $slug);
    }
    function pre_ins(){
        $this->slug("slug_es", "titulo_es");
        $this->slug("slug_en", "titulo_en");
    }
    function pre_upd(){
        $this->slug("slug_es", "titulo_es");
        $this->slug("slug_en", "titulo_en");
    }
}

?>