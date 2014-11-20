<?php

class Chome extends application {

    function __construct() {
        parent::__construct();
    }

    /* function index(){
      $this->loadView("onbuild.php");
      } */

    function index() {
        if ($_GET["logout"] == 1 || $_GET["amount3"])
            unset($_SESSION["fbconexion"]);
        $this->params["fblogin"] = $this->fb->permisionsLink();
        $this->params["scripts"][] = "http://connect.facebook.net/es_ES/all.js";
        $db = $this->dbInstance();
        $sql = "select * from #_estaticos where id=1";
        $this->params["registro"] = $db->loadObjectRow($sql);
        $this->params["follow"] = true;
        $this->params["pagetitle"] = __("ptinicio");
        $this->params["sitedescription1"] = __("pdinicio");
        $this->params["css"][] = "internalpages.css";
        $this->params["hayzopim"] = false;
        $this->loadHtml("home2_" . $_SESSION["lang"] . ".php", $this->params);
    }

    function reportes($id=1) {
        //SELECT fbc_usuario.uid, fbc_usuario.firstname,fbc_usuario.lastname,count(fbc_tab.id) as 'tabs creados', tienetrial,plan,fbc_usuario.fechains FROM `fbc_tab` right join fbc_usuario on fbc_tab.uid=fbc_usuario.uid
        //where fbc_usuario.fechains between '2011-10-16 0:0:0' and now()
        //group by fbc_usuario.uid, fbc_usuario.firstname,fbc_usuario.lastname
        //order by firstname,count(fbc_tab.id)
        //
        //SELECT a.uid,a.firstname,a.lastname, a.fechains,b.idpagina from fbc_usuario a inner join fbc_tab b on a.uid=b.uid where a.fechains between '2011-10-16 0:0:0' and now()
        //
        //SELECT CONCAT(  'http://facebook.com/', a.idpagina,  '?sk=app_', c.appid ) AS tab, c.nombre, CONCAT(  'http://www.facebook.com/', b.uid ) AS  'user facebook', b.firstname, b.lastname
        //FROM fbc_tab a
        //INNER JOIN fbc_usuario b ON a.uid = b.uid
        //INNER JOIN fbc_aplicacion c ON a.idapp = c.id
        //
        //update `fbc_usuario` set tienetrial=1, trialfechafin=date_add(now(),interval 15 day), trialplan=4, trialcode='WELCOMEFANS'
        //where uid='1572957464' 
        header('Content-type: application/vnd.ms-excel');
        header("Content-Disposition: attachment; filename=reporte_" . date("d-m-Y-h-i-s-a") . ".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        echo '<html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            </head>
            <body>';
        switch ($id) {
            case 2:
                $sql = "SELECT a.uid,a.firstname,a.lastname, a.fechains,b.idpagina from fbc_usuario a inner join fbc_tab b on a.uid=b.uid where a.fechains between '2011-10-16 0:0:0' and now()";
                break;
            case 3:
                $sql = "select distinct concat('http://www.facebook.com/',a.idpagina) as pagina, concat('http://www.facebook.com/',b.uid) as 'user facebook',b.firstname,b.lastname from fbc_tab a inner join fbc_usuario b on a.uid=b.uid";
                break;
            case 1:
            default:
                $sql = "SELECT fbc_usuario.uid, fbc_usuario.firstname,fbc_usuario.lastname,count(fbc_tab.id) as 'tabs creados', tienetrial,plan,fbc_usuario.fechains FROM `fbc_tab` right join fbc_usuario on fbc_tab.uid=fbc_usuario.uid
                where fbc_usuario.fechains between '2011-10-16 0:0:0' and now()
                group by fbc_usuario.uid, fbc_usuario.firstname,fbc_usuario.lastname
                order by firstname,count(fbc_tab.id)";
                break;
        }
        if ($sql) {
            $db = $this->dbInstance();
            $res = $db->loadAssocList($sql);
            $db->query($sql);
            $tabla.='<table cellpadding="0" cellspacing="0" border="1">';
            //listando cabeceras
            $i = 0;
            $tabla.="<tr>";
            while ($i < mysql_num_fields($db->_cursor)) {
                $meta = mysql_fetch_field($db->_cursor, $i);

                if (!$meta) {
                    $tabla.="<th>&nbsp;</th>";
                } else {
                    $tabla.="<th>" . $meta->name . "</th>";
                }
                $i++;
            }
            $tabla.="</tr>";
            foreach ($res as $row) {
                $tabla.='<tr>';
                $inscrito = true;
                foreach ($row as $campo) {
                    if ($inscrito) {
                        $tabla.='<td>';
                        $tabla.=htmlentities($campo);
                        $tabla.='</td>';
                    }
                    $inscrito = !$inscrito;
                }
                $tabla.='</tr>';
            }
            $tabla.='</table>';
            echo $tabla;
        }
        echo '</body>
            </html>
            <html><head><title>hoja 2</title></head><body>
                <table><tr><td>hola</td><td>1</td></tr></table>
            </body></html>';
    }

    function terms() {
        $this->loadHtml("terms_" . $_SESSION["lang"] . ".php", $this->params);
    }

    function entrada() {
        $this->redirect("");
    }

}

?>
