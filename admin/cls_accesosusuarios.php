<?php

include("cls_MantixBase20.php");

class Registro extends MantixBase {

    function __construct() {
        $this->ini_datos("fbc_acceso", "uid");
    }

    function formulario() {
//        $m_Form = new MantixForm();
//        $m_Form->atributos = array("texto_submit" => "Registro");
//        $m_Form->datos = $this->datos;
//        $m_Form->controles = array(
//            array("label" => "Cliente - Proyecto", "campo" => "idproyecto", "tipo" => "select", "opciones" => $this->getClienteProyecto()),
//            array("label" => "Servicio:", "campo" => "idpaquete", "tipo" => "select", "tabla_asoc" => "com_paquetes", "campo_asoc" => "nombre_es+precio", "id_asoc" => "id"),
//            array("label" => "Descripción", "campo" => "descripcion"),
//            array("label" => "Precio", "campo" => "precio"),
//            array("label" => "Paypal", "campo" => "paypalurl","extras"=>"readonly")
//        );
//        $res = $m_Form->ver();
//        return $res;
        return "&nbsp;";
    }

    function lista() {
        $r = new MantixGrid();
        $sql = "SELECT a.*,concat(b.firstname,' ',b.lastname) as nombre, b.company from fbc_acceso a inner join fbc_usuario b on a.uid=b.uid collate utf8_unicode_ci";
        $mm='';
        if($_POST["bus_fecha1"]){
            $f1=  "'".preg_replace("/(.[^\/]*)\/(.[^\/]*)\/(.[^\/]*)/", "$3-$2-$1 00:00:00", $_POST["bus_fecha1"])."'";
            if($_POST["bus_fecha2"])
                $f2=  "'".preg_replace("/(.[^\/]*)\/(.[^\/]*)\/(.[^\/]*)/", "$3-$2-$1 23:59:59", $_POST["bus_fecha2"])."'";
            else
                $f2="now()";
            $mm.="  a.fecha >= $f1 and a.fecha<=$f2";
        }
        if($_POST["bus_fullname"]){
            if($mm!="")
                $mm.=' and';
            $mm.=" concat(b.firstname,' ',b.lastname) like '%".mysql_escape_string($_POST["bus_fullname"])."%'";
        }
        if($mm!=""){
            $sql.=" where $mm";
        }
        else{
            $sql.=" where 1=0";
        }
        $r->buscador = array(
            array("label" => "User Full Name", "tipo" => "text", "id" => "fullname", "campo" => "fullname"),
            array("label" => "Start Date", "tipo" => "fecha", "id" => "fecha1", "campo" => "fecha1"),
            array("label" => "End Date", "tipo" => "fecha", "id" => "fecha2", "campo" => "fecha2"),
        );
        $r->atributos = array("sql" => $sql, "nropag" => "20", "ordenar" => "id desc", "ver_buscador" => "1", "sin_buscar"=>"1");
        $r->columnas = array(
            array("titulo" => "Full Name", "campo" => "nombre"),
            array("titulo" => "Fecha", "campo"=>"fecha")
        );
        return $r->ver();
    }
}

?>