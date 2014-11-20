<?php

class CcommunicationManager extends application {

    function __construct() {
        parent::__construct();
        
    }

    function normalizar($valor) {
        $valor = str_replace("\'", "'", $valor);
        $valor = str_replace("'", "\'", $valor);
        return $valor;
    }

    function index($idpage,$y1="",$m1="",$d1="",$y2="",$m2="",$d2="") {
        $this->checkSession();
        $idpage = str_replace("'", "", $idpage);
        $db = $this->dbInstance();
        echo $db->debug(2);

        if ($_POST["txtdesc"] != "") {
            $camposin=array(
                "user_id"=>$_SESSION["fbconexion"]["uid"],
                "page_id"=>$idpage,
            );
            $campos=array(
                "mensaje"=>$this->normalizar($_POST["txtdesc"]),
                "attachTitle"=>$this->normalizar($_POST["txttitleattach"]),
                "attachThumb"=>$this->normalizar($_POST["attachbg"]),
                "attachDesc"=>$this->normalizar($_POST["txtdescattach"]),
                "attachURL"=>$this->normalizar($_POST["txtattach"]),
                "fecha"=>($_POST["txtenviado"]==1?gmmktime()+intval(date("Z"))*-1:($_POST["txtscheduled"]+intval(date("Z"))*-1)),
                "enviado"=>$this->normalizar($_POST["txtenviado"]),
                "access_token"=>$_SESSION["fbconexion"]["access_token"],
            );
            
            if($_POST["txtpid"]!=""){
                //editar
                $db->update("#_pageMessage", $campos, "id=".intval($_POST["txtpid"])." and page_id='".$idpage."'");
                $this->params["rpt"]="txtcmupdated";
            }
            else{
                //insertar
                $db->insert("#_pageMessage", array_merge($camposin, $campos));
                $idp = $db->insertid();
                if ($_POST["txtenviado"] == 1) {
                    $this->publishWall($idp, $idpage);
                }
                $this->params["rpt"]="txtcminserted";
            }
        }
        $fql = "SELECT uid, page_id, type from page_admin WHERE uid=" . $_SESSION["fbconexion"]["uid"] . " and page_id=$idpage";
        $res = $this->fb->fqlQuery($fql);
        if (count($res) > 0) {
            $sql = "select *,FROM_UNIXTIME(fecha+(".intval(date("Z"))."),'%M %D, %Y %h:%i %p') as fecha2 from #_pageMessage where page_id='$idpage' order by fecha desc";
            $sr=true;
            if($m1=="" || $d1=="" || $m2=="" || $d2=="" || $y1=="" || $y2==""){
                $m1=date("n");
                $d1=date("j");
                $m2=$m1;
                $d2=$d1;
                $y1=date("Y");
                $y2=$y1;
                $sr=false;
            }
            
            $sql=str_replace("where","where fecha between '".mktime(0, 0, 0, $m1, $d1, $y1)."' and '".mktime(23, 59, 59, $m2, $d2,$y2)."' and ",$sql);
            if($sr)
                $this->params["hayrango"]='<a href="'.$this->getURL("communicationManager/index/".$idpage).'" id="closerf">x</a>&nbsp;&nbsp;'.str_replace(array("{yy1}","{mm1}","{dd1}","{yy2}","{mm2}","{dd2}"),array($y1,__("txtmes$m1"),$d1,$y2,__("txtmes$m2"),$d2),__("listingrange"));
            
            $this->params["posts"] = $db->loadObjectList($sql);
            $fql = "SELECT name, page_id from page WHERE page_id=$idpage";
            $this->params["page"] = $this->fb->fqlQuery($fql);
            $sql = "select distinct user_id from #_pageMessage where page_id='$idpage'";
            $usuarios=$db->loadObjectList($sql);
            $arusers=array();
            if(count($usuarios)>0)
                foreach ($usuarios as $u) {
                    if(trim($u->user_id)!="")
                        $arusers[]=$u->user_id;
                }
            $fql="select uid,name,pic_square,profile_url from user where uid in (".implode(",",$arusers).")";
            if(count($usuarios)>0)
                foreach($this->fb->fqlQuery($fql) as $ff){
                    $this->params["usuarios"]["f".$ff["uid"]]=$ff;
                }
            $this->loadHtml("comuManager.php", $this->params);
        } else {
            $this->getURL("fbconexion");
        }
    }

    function getgmdate($anio,$mes,$dia,$hora,$min){
        return mktime($hora, $min, null, $mes, $dia, $anio);
    }
    
    function cronWall(){
        $db=$this->dbInstance(true);
        $tiempo=gmmktime()+intval(date("Z"))*-1;
        echo "fecha GMT: $tiempo - ".date("d/m/Y H:i a", $tiempo)."<br/>";
        $sql="select * from #_pageMessage where enviado=0 and fecha<=$tiempo";
        $res=$db->loadObjectList($sql);
        if(count($res)>0){
            $report='<table border="1" cellpaddin="1" cellspacing="1"><tr><th>Mensaje</th><th>Hora Local</th><th>Timestamp</th></tr>';
            foreach($res as $r){
                $url = "https://graph.facebook.com/" . $r->page_id . "/feed";
                $attachment = array(
                    'access_token' => $r->access_token,
                    'message' => $r->mensaje,
                    //'actions' => json_encode(array('name' => $action_name, 'link' => $this->getURL()))
                );
                
                $report.='<tr><td>'.$r->mensaje.'</td><td>'.date("d - M - Y",$r->fecha)." a las ".date("h:i a",$r->fecha).'</td><td>'.$r->fecha.'</td></tr>';
                
                if($r->attachURL!=""){
                    $attachment["name"]=$r->attachTitle;
                    $attachment["link"]=$r->attachURL;
                    $attachment["description"]=$r->attachDesc;
                    $attachment["picture"]=$r->attachThumb;
                    //$attachment["attachment"]=json_encode($compartir);
                }
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL,$url);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($attachment));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  //to suppress the curl output 
                $result = curl_exec($ch);
                curl_close ($ch);
            }
            $report.='</table>';
            echo $report;
            $db->update("#_pageMessage", array(
                "enviado"=>"1"
            ), "enviado=0 and fecha<$tiempo");
        }
    }
    
    function cancelWall($idp,$page_id){
        $this->checkSession();
        $db=$this->dbInstance();
        $db->debug(2);
        $db->setQuery("delete from #_pageMessage where id=".intval($idp)." and page_id='".str_replace("'","",$page_id)."'");
        $db->query();
    }
    
    function publishWall($idp, $page_id) {
        $this->checkSession();
        $db = $this->dbInstance();
        $r = $db->loadObjectRow("select * from #_pageMessage where id=$idp");
        $url = "https://graph.facebook.com/" . $page_id . "/feed";
        $attachment = array(
            'access_token' => $r->access_token,
            'message' => $r->mensaje,
            //'actions' => json_encode(array('name' => $action_name, 'link' => $this->getURL()))
        );
        if($r->attachURL!=""){
            $attachment["name"]=$r->attachTitle;
            $attachment["link"]=$r->attachURL;
            $attachment["description"]=$r->attachDesc;
            $attachment["picture"]=$r->attachThumb;
            //$attachment["attachment"]=json_encode($compartir);
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($attachment));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  //to suppress the curl output 
        $result = curl_exec($ch);
        $this->params["rpta"]=$result;
        curl_close ($ch);
        return 1;
    }

    function getImages() {
        $url = "http://".$_POST["url"];
        
        if (strpos($url, "youtube.com/watch?v=") !== false) {
            //youtube
            $auxdev = str_replace("http://www.youtube.com/watch?v=", "http://i3.ytimg.com/vi/", $url);
            if (strpos($auxdev, "&") !== false)
                $auxdev = str_replace("&", "/default.jpg?", $auxdev);
            else
                $auxdev.="/default.jpg";
            $devolver = array($auxdev);
        }else {
            $ext=strtolower(substr($url, strlen($url)-3));
            switch($ext){
                case 'jpg':
                case 'png':
                case 'gif':
                    $devolver=array($url);
                    break;
                default:
                    $x=file_get_contents($url);
                    $x=str_replace("\n","",$x);
                    preg_match("/(\<img.[^>]*\>)/", $x,$res,PREG_OFFSET_CAPTURE);
                    if(count($res)>0){
                        $salidas=array();
                        foreach ($res as $r) {
                            preg_match('/(src\=")(.[^\"]*)(\")/',$r[0],$y,PREG_OFFSET_CAPTURE);
                            $ext2=strtolower(substr($y[2][0], strlen($y[2][0])-3));
                            if($ext2=="jpg" || $ext2=="png" || $ext2=="gif")
                                $salidas[]=$y[2][0];
                        }
                        $devolver=$salidas;
                    }
                    else{
                        return "";
                    }
                    //$devolver=$this->_getImageFromPage($url);
            }
            /*//si es imagen o no
            $params = array('http' => array(
                    'method' => 'HEAD'
                    ));
            $ctx = stream_context_create($params);
            $fp = @fopen($url, 'rb', false, $ctx);
            if (!$fp) {
                //problema con url, posilemente no es imagen
                $devolver = $this->_getImageFromPage($url);
            } else {
                $meta = stream_get_meta_data($fp);
                if ($meta == false) {
                    $devolver = $this->_getImageFromPage($url);
                }
                $wrapper_data = $meta["wrapper_data"];
                if (is_array($wrapper_data)) {
                    foreach (array_keys($wrapper_data) as $hh) {
                        if (substr($wrapper_data[$hh], 0, 19) == "Content-Type: image"){
                            $devolver = array($url);
                            break;
                        }
                        else{
                            $devolver=$this->_getImageFromPage($url);
                            break;
                        }
                    }
                }
            }*/
        }
        echo json_encode($devolver);
    }

    function getPost($id,$page_id){
        $this->checkSession();
        $db=$this->dbInstance();
        $db->debug(2);
        $id=intval($id);
        $sql="select * from #_pageMessage where id=$id and page_id='".$page_id."'";
        $r=$db->loadObjectRow($sql);
        $result=array(
            "txtdesc"=>$this->normalizar($r->mensaje),
            "txtattach"=>$this->normalizar($r->attachURL),
            "txttitleattach"=>$this->normalizar($r->attachTitle),
            "txtdescattach"=>$this->normalizar($r->attachDesc),
            "attachbg"=>$this->normalizar($r->attachThumb),
            "fecha2"=>$this->normalizar(date("m/d/Y",$r->fecha)),
            "hora"=>$this->normalizar(gmdate("h",$r->fecha)),
            "minu"=>$this->normalizar(gmdate("i",$r->fecha)),
            "ampm"=>$this->normalizar(gmdate("A",$r->fecha)),
        );
        echo json_encode($result);
    }
    
    function _getImageFromPage($url) {
        $x=file_get_contents($url);
        $x=str_replace("\n","",$url);
        preg_match("/(\<img.*\/\>)/", $x,$res,PREG_OFFSET_CAPTURE);
        if(count($res)>0){
            $salidas=array();
            foreach ($res as $r) {
                preg_match('/(src\=)(".[^\"]*)(\")/',$r[0],$y,PREG_OFFSET_CAPTURE);
                $salidas[]=$y[0][1];
            }
            //$r=preg_replace('/(src\=)(".[^\"]*)(\")/',"$2",$res[0][0]);
            return $salidas;
        }
        else{
            return "";
        }
        
        /*
         f<div>dsfds <img width="890px" height="800px" src="http://wwww-dlcfkff.vlvfkfk/mfkfmfm/jfkff.jpg" alt="" /> dsfdsg ghhhhhhh hgggggg</div>ggg
         gfdhgfd hg<img src="http://wwww-dlcfkff.vlvfkfk/mfkfmfm/jfkff.jpg" alt="" />fd
         * hg<span><a>gg<img src="http://wwww-dlcfkff.vlvfkfk/mfkfmfm/jfkff.jpg" alt="" />gg</a></span>h
         * ggg<img src="http://wwww-dlcfkff.vlvfkfk/mfkfmfm/jfkff.jpg" alt="" />fd
         
         */
        /*preg_match("/(\.jpg|\.gif|\.png)/", $url, $matches);
        //print_r($matches);
        if (count($matches) > 0) {
            //se trata de una imagen
            return array($url);
        } else {
            if($url!=null && $url!=""){
                $salidas = array();
                $DOM = new DOMDocument('1.0', 'utf-8');
                $DOM->loadXML($c);
                $entradas = $DOM->getElementsByTagName('img');
                for ($i = 0; $i < $entradas->length; $i++) {
                    $e = $entradas->item($i);
                    $salidas[] = $e->getAttribute("src");
                }
                return salidas;
            }
            else{
                return "";
            }
        }*/
    }

}

?>
