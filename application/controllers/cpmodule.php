<?php

/**
 * clase base para los formularios, debe haber un solo formulario, pero pueden ser varios grids
 */
class cpmodule extends application {

    var $objetos;
    var $idobj;

    function __construct() {
        $this->objetos = array();
        $this->loadModel("autenticacion")->checkLogin();
        $this->params["scripts"][] = "http://www.fbconexion.com/onlineco/flexgrid/flexigrid.js";
        $this->params["scripts"][] = "cpanel.js";
        $this->params["css"][] = "http://www.fbconexion.com/onlineco/flexgrid/css/flexigrid/flexigrid.css";
        /* $this->params["scripts"][]="";
          $this->params["css"][]=""; */
    }

    function pre_upd() {
        
    }

    function pre_ins() {
        
    }

    function pre_del() {
        
    }

    function post_upd() {
        
    }

    function post_ins() {
        
    }

    function post_del() {
        
    }

    protected function acciones($form, $token) {
        $db = $this->dbInstance();
        $this->idobj = $_POST["idobj"];
        switch ($_POST["accion"]) {
            case 'set_editar':
                $sql = "select * from " . $form["tabla_submit"] . " where id=" . intval($this->idobj);
                $res = $db->loadObjectRow($sql);
                return $res;
                break;
            case 'submit_editar':
                if ($token == $_POST["token"]) {
                    //obtengo los campos a subir
                    $this->pre_upd();
                    $campos = array();
                    foreach ($form["campos"] as $c) {
                        if (isset($_POST[$c["campo"]]))
                            $campos[$c["campo"]] = $_POST[$c["campo"]];
                    }
                    $db->update($form["tabla"], $campos, "id=" . $this->idobj);
                    $this->post_upd();
                    $_POST["acciones"] = "set_editar";
                    $this->acciones($form, $token);
                }
                break;
            case 'set_nuevo':
                break;
            case 'submit_nuevo':
                if ($token == $_POST["token"]) {

                    //obtengo los campos a subir
                    $this->pre_ins();
                    $campos = array();
                    foreach ($form["campos"] as $c) {
                        if (isset($_POST["campo"]))
                            $campos[$c["campo"]] = $_POST["campo"];
                    }
                    $db->insert($form["tabla"], $campos);
                    $this->idobj = $db->insertid();
                    $this->post_ins();
                }
                break;
            case 'eliminar_simple':
                if ($token == $_POST["token"]) {
                    $this->pre_del();
                    $campos = array();
                    $db->delete($form["tabla"], "id=" . $this->idobj);
                    $this->post_del();
                }
                break;
            case 'estado_simple':
                if ($token == $_POST["token"]) {
                    $sql = "update " . $form["tabla"] . " set estado=if(estado=0,1,0) where id=" . $this->idobj;
                    $db->setQuery($sql);
                    $db->query();
                }
                break;
            case 'estado_varios':
                if ($token == $_POST["token"]) {
                    $sql = "update " . $form["tabla"] . " set estado=if(estado=0,1,0) where id in(" . $this->idobj . ")";
                    $db->setQuery($sql);
                    $db->query();
                }
                break;
            case 'eliminar_varios':
                if ($token == $_POST["token"]) {
                    $sql = "delete from " . $form["tabla"] . " where id in(" . $this->idobj . ")";
                    $db->setQuery($sql);
                    $db->query();
                }
                break;
        }
    }

    function doForm($info) {
        $token = $info;
        $form = call_user_method($info, $this);
        $form["tabla_submit"] = $form["tabla_submit"] ? $form["tabla_submit"] : $form["tabla"];
        if ($form["default_id"]) {
            if ($_POST["accion"] != "submit_editar")
                $_POST["accion"] = "set_editar";
            if ($_POST["idobj"] == "")
                $_POST["idobj"] = $form["default_id"];
        }

        $reg = $this->acciones($form, $token);
        //lo demas
        $cad = '';
        $cad.="\n" . '<div class="formulario">';
        $cad.="\n" . '<form action="' . $form["action"] . '" id="' . $token . '" name="' . $token . '" method="post" enctype="multipart/form-data">';
        $cad.="\n" . '<div class="titleform">' . $form["titulo"] . '</div>';
        foreach ($form["campos"] as $c) {
            if (!$c["tipo"])
                $c["tipo"] = "text";
            $campo = $c["campo"];
            $cad.="\n" . '<div class="formrow ' . $token . '">';
            if (!$c["label"])
                $c["label"] = $c["campo"];
            switch ($c["tipo"]) {
                case 'fck':
                    if (!in_array("../ckeditor/ckeditor.js", $this->params["scripts"])) {
                        $this->params["scripts"][] = "../ckeditor/ckeditor.js";
                        $this->params["scripts"][] = "../ckeditor/ckfinder/ckfinder.js";
                    }
                    $cad.="\n" . '<label for="' . $c["campo"] . '">' . ucwords($c["label"]) . '</label>';
                    $cad.="\n" . '<div style="float:left;width:570px"><textarea alt="' . ucwords($c["label"]) . '" name="' . $c["campo"] . '" id="' . $token . $c["campo"] . '" class="cinputtext ' . $c["clases"] . '">' . $reg->$campo . '</textarea></div>';
                    $cad.='<script type="text/javascript">';
                    $cad.='    var ' . $c["campo"] . ' = CKEDITOR.replace( "' . $c["campo"] . '",{width:570} );';
                    $cad.='    CKFinder.setupCKEditor( ' . $c["campo"] . ');';
                    $cad.='</script>';
                    break;
                case 'password':
                default:
                    $cad.="\n" . '<label for="' . $c["campo"] . '">' . ucwords($c["label"]) . '</label>';
                    $cad.="\n" . '<input alt="' . ucwords($c["label"]) . '" type="' . $c["tipo"] . '" name="' . $c["campo"] . '" id="' . $token . $c["campo"] . '" class="cinputtext ' . $c["clases"] . '" value="' . $reg->$campo . '"/>';
            }
            $cad.="\n" . '</div>';
        }
        $cad.="\n" . '<div class="formrow ' . $token . ' formsubmit">';
        $cad.="\n" . '<input type="submit" id="submit_' . $token . '" value="' . ($reg->id ? 'Guardar ' : 'Crear ') . 'Registro" />';
        $cad.="\n" . '</div>';
        $cad.="\n" . '<input type="hidden" name="idobj" class="idobj" value="' . $reg->id . '"/>';
        $cad.="\n" . '<input type="hidden" name="accion" class="accion" value="' . ($reg->id ? 'submit_editar' : 'set_nuevo') . '"/>';
        $cad.="\n" . '<input type="hidden" name="token" class="token" value="' . $token . '"/>';
        $cad.="\n" . '</form>';
        $cad.="\n" . '<script type="text/javascript">';
        $cad.="\n" . 'engine_form("' . $token . '");';
        $cad.="\n" . '</script>';
        $cad.="\n" . '</div>';
        $this->params["objetos"][] = $cad;
    }

    function doGrid($info) {
        $token = $info;
        $form = call_user_method($info, $this);
        $form["tabla_submit"] = $form["tabla_submit"] ? $form["tabla_submit"] : $form["tabla"];
        $this->acciones($form, $token);
        $form["vereliminar"] = ($form["vereliminar"] ? $form["vereliminar"] : true);
        $form["vereditar"] = ($form["vereditar"] ? $form["vereditar"] : true);
        $form["verestado"] = ($form["verestado"] ? $form["verestado"] : true);
        $this->objetos[$token] = $form;
        $url = $this->getURL(substr(get_class($this), 1) . "/datagrid/" . $token);
        $cad = '';
        $cad.='<form action="' . $form["action"] . '" name="' . $token . '" id="' . $token . '" method="post">';
        $cad.='<div class="grilla">';
        $cad.='     <div id="' . $token . '">';
        $cad.='     </div>';
        $cad.='
                    <input type="hidden" name="token" class="token" value="' . $token . '"/>
                    <input type="hidden" name="idobj" class="idobj" value=""/>
                    <input type="hidden" name="accion" class="accion" value=""/>';
        $cad.='</div>';
        $cad.='</form>';
        $cad.='<script type="text/javascript">';
        $form["width"] = ($form["width"] ? $form["width"] : "960");
        $width = floor(1 / count($form["campos"]) * ($form["width"] - 70 - 60 - 28)) - 14;
        $cad.='
        $(".grilla #' . $token . '").flexigrid({
            stripped:false,
            "url":"' . $url . '",
            dataType:"json",
            usepager: true,
            ' . ($form["title"] ? "title:" . $form["title"] : "") . '
            useRp: true,
            rp: 15,
            showTableToggleBtn: true,
            width: ' . $form["width"] . ',
            height: ' . ($form["height"] ? $form["height"] : "200") . ',
            sortname:"' . ($form["sortname"] ? $form["sortname"] : "id") . '",
            sortorder:"' . ($form["sortorder"] ? $form["sortorder"] : "desc") . '",
            ' . ($form["searchitems"] ? "searchitems:" . json_encode($form["searchitems"]) . "," : '') . '
            colModel:[';
        $ctl = array();
        if ($form["vereliminar"] == true || $form["vereditar"] == true)
            $ctl[] = '{display:"Acciones",name:"' . $token . 'acciones",width:70,sortable:true,align:"center"}';
        if ($form["verestado"])
            $ctl[] = '{display:"Estado",name:"' . $token . 'estado",width:60,sortable:true,align:"center"}';
        foreach ($form["campos"] as $c) {
            $m_width = ($c["width"] ? $c["width"] : $width);
            $ctl[] = '{display:"' . ucwords($c["label"] ? $c["label"] : $c["campo"]) . '",name:"' . $token . $c["campo"] . '",width:"' . $m_width . '",sortable:' . ($c["sortable"] ? $c["sortable"] : "false") . ',align:"' . ($c["align"] ? $c["align"] : "center") . '"}';
        }
        $cad.=implode(",", $ctl);
        $cad.='],
            buttons:[';
        $ctl = array();
        $ctl[] = "{name:'Invertir Selección',bclass:'toggle_selection',onpress:selectgroup}";
        if ($form["vereliminar"])
            $ctl[] = "{name:'Eliminar',bclass:'toggle_eliminar',onpress:deletegroup}";
        if ($form["verestado"])
            $ctl[] = "{name:'Activar/Desactivar',bclass:'toggle_estado',onpress:estadogroup}";
        $cad.=implode(",\n", $ctl);
        $cad.=']
        });
        
        ';
        $cad.='</script>';
        $this->params["objetos"][] = $cad;
    }

    function datagrid($info) {
        $token = $info;
        $form = call_user_method($info, $this);
        $form["vereliminar"] = ($form["vereliminar"] ? $form["vereliminar"] : true);
        $form["vereditar"] = ($form["vereditar"] ? $form["vereditar"] : true);
        $form["verestado"] = ($form["verestado"] ? $form["verestado"] : true);
        $tabla = $form["tabla"];
        //construyo el sql
        if (strpos($tabla, "select ") === false)
            $sql = "select * from $tabla";
        else
            $sql=$form["tabla"];
        //cojo variables
        $page = $_POST['page'];
        $rp = $_POST['rp'];
        $sortname = $_POST['sortname'];
        $sortorder = $_POST['sortorder'];
        //filtro
        if ($_POST['q']) {
            if (strpos($sql, 'where ') === false)
                $sql.=' where 1=1';
        }
        //ordeno
        if (!$sortname)
            $sortname = 'id';
        if (!$sortorder)
            $sortorder = 'desc';
        $sort = " ORDER BY $sortname $sortorder";
        if (!$page)
            $page = 1;
        if (!$rp)
            $rp = 15;
        $lib = $this->loadModel("paginacion");
        $res = $lib->doPagination($this->dbInstance(), $sql, $rp, $page, $numpags, $totalreg);
        $data = array(
            'page' => $page,
            'total' => $totalreg,
        );
        if (count($res) > 0) {
            foreach ($res as $key => $r) {
                $data['rows'][$key]['id'] = $r->id;
                $auxcell = "";
                //campo accion
                if ($form["vereliminar"])
                    $auxcell.='<a href="javascript:grid_eliminar(\'' . $token . '\',' . $r->id . ')"><img src="' . $this->getURL("images/ico_eliminar.png") . '"/></a>';
                if ($form["vereditar"])
                    $auxcell.='<a href="javascript:grid_editar(\'' . $token . '\',' . $r->id . ')"><img src="' . $this->getURL("images/ico_editar.png") . '"/></a>';
                if ($auxcell != "")
                    $data['rows'][$key]['cell'][] = $auxcell;
                //campo estado
                $auxcell = "";
                if ($form["verestado"])
                    $auxcell = '<a href="javascript:grid_estado_simple(\'' . $token . '\',' . $r->id . ',' . $r->estado . ')"><img src="' . $this->getURL("images/ico_estado_" . $r->estado . ".png") . '"/></a>';
                if ($auxcell != "")
                    $data['rows'][$key]['cell'][] = $auxcell;

                foreach ($form["campos"] as $c) {
                    $campo = $c['campo'];
                    $data['rows'][$key]['cell'][] = $r->$campo;
                }
            }
        }
        echo json_encode($data);
    }

    function doMenu($menu) {
        $cad = '';
        if (count($menu) > 0) {
            $cad.='<ul>';
            foreach ($menu as $m) {
                $cad.='<li>';
                $cad.='<a href="' . $this->getURL($m["url"]) . '">' . $m["label"] . '</a>';
                $cad.=$this->doMenu($m["sub"]);
                $cad.='</li>';
            }
            $cad.='</ul>';
        }
        return $cad;
    }

}
?>
