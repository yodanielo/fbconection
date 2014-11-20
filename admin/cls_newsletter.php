<?php

include("cls_MantixBase20.php");

class Registro extends MantixBase {

    function __construct() {
        $_POST["quiensoy"] = "W";
        $this->ini_datos("fbc_newsletter", "id");
    }

    function lista() {
        $r = new MantixGrid();
        $r->atributos = array("tabla" => "fbc_newsletter", "nropag" => "20", "ordenar" => "id");
        $r->columnas = array(
            array("titulo" => "T&iacute;tulo", "campo" => "titulo", "obligatorio" => "1"),
            array("titulo" => "Enviado", "campo" => "sent"),
            array("titulo" => "Fecha", "campo" => "inserted", "obligatorio" => "1")
        );
        /* $r->botones = array(
          array("nombre"=>"btnsend","label"=>"Send","ir"=>"/?opcenviar=1","accion"=>2)
          ); */
        return $r->ver();
    }

    function formulario() {
        $m_Form = new MantixForm();
        $m_Form->atributos = array("texto_submit" => "Newsletter");
        $m_Form->datos = $this->datos;
        $m_Form->controles = array(
            array("label" => "T&iacute;tulo:", "campo" => "titulo", "obligatorio" => "1"),
            array("label" => "Descripci&oacute;n:", "campo" => "descripcion", "tipo" => "fck"),
        );
        return $m_Form->ver();
    }

    function enviarmail() {
        include('phpmailer.php');
        $body = $_POST["descripcion"];
        $body.='<div><a href="http://www.fbconexion.com/es/unsuscribe?token='.urlencode(md5($r->email)).'&mail='.urlencode($r->email).'"><img style="border:none;" src="http://www.fbconexion.com/images/mail1.4.jpg"/></a></div>';
        $res = $this->datos->ejecutar("select * from fbc_suscriptores where estado=1 and id > 0 and id <= 5135 limit 50");
            $Mail = new phpmailer();
        while($r=mysql_fetch_object($res)) {
            $Mail->From = "info@fbconexion.com";
            $Mail->FromName = "FB Conexion";
            $Mail->AddAddress($r->email);
            $Mail->AddReplyTo($Mail->From);
            $Mail->Subject = "FBConexion";
            $Mail->IsHTML(true);
            $Mail->Body = utf8_decode($body);
            $Mail->Send();
            $Mail->to=array();
            $this->datos->ejecutar("update fbc_suscriptores set estado=0 where id=".$r->id);
        }
            unset($Mail);
    }

    function pre_ins() {
        if ($_POST["opcenviar"] != 0) {
            $this->enviarmail();
            $this->datos->agregar("sent", "Enviado");
        }
    }

    function pre_upd() {
        if ($_POST["opcenviar"] != 0) {
            $this->enviarmail();
            $this->datos->agregar("sent", "Enviado");
        }
    }

}

?>