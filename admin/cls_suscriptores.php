<?php

include("cls_MantixBase20.php");

class Registro extends MantixBase {

    function __construct() {
        $this->ini_datos("fbc_suscriptores", "id");
    }

    function formulario() {
        $m_Form = new MantixForm();
        $m_Form->atributos = array("texto_submit" => "Registro");
        $m_Form->datos = $this->datos;
        $m_Form->controles = array(
            array("label" => "E-mail", "campo" => "email"),
            array("label" => "Nombre", "campo" => "nombre")
        );
        $res = $m_Form->ver();
        return $res;
    }

    function lista() {
        $r = new MantixGrid();
        $sql = "SELECT * from fbc_suscriptores";
        $r->atributos = array("sql" => $sql, "nropag" => "20", "ordenar" => "id desc");
        $r->columnas = array(
            array("titulo" => "E-mail", "campo" => "email"),
            array("titulo" => "Nombre", "campo" => "nombre"),
        );
        return $r->ver();
    }
}

?>