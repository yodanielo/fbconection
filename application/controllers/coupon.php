<?php
class Ccoupon extends application{
    function __construct() {
        parent::__construct();
        $this->checkSession();
    }
    function normalizar($valor) {
        $valor = str_replace("\'", "'", $valor);
        $valor = str_replace("'", "\'", $valor);
        return $valor;
    }
    function add(){
        $this->loadView("couponForm_".$_SESSION["lang"].".php");
    }
    function saveCoupon(){
        $db=$this->dbInstance();
        $db->debug(2);
        $f1=explode("-", $_POST["txt6"]);
        $f2=explode("-", $_POST["txt7"]);
        if($_POST["txt3"]){
            $valores=array(
                "offerimage"=>$this->normalizar($_POST["txt1"]),
                "barcode"=>$this->normalizar($_POST["txt2"]),
                "title"=>$this->normalizar($_POST["txt3"]),
                "shortdescription"=>$this->normalizar($_POST["txt4"]),
                "fulldescription"=>$this->normalizar($_POST["txt5"]),
                "startdate"=>$f1[2]."-".$f1[0]."-".$f1[1],
                "enddate"=>$f2[2]."-".$f2[0]."-".$f2[1],
                "numcoupons"=>intval($_POST["txt8"]),
                "numprints"=>intval(0),
                "termsandconditionsarea"=>$this->normalizar($_POST["txt9"]),
                "termsandconditions"=>$this->normalizar($_POST["txt10"]),
                "premium"=>$this->normalizar($_POST["txt11"]),
                "idtab"=>$this->normalizar($_POST["idtab"]),
            );
            if(intval($_POST["idc"])!=0){
                //echo "actualizar";
                $db->update("#_coupon", $valores, "idtab=".intval($_POST["idtab"])." and id=".intval($_POST["idc"]));
                echo intval($_POST["idc"]);
            }
            else{
                //insertar
                $db->insert("#_coupon", $valores);
                echo $db->insertid();
            }
        }
    }
    function delCoupon($idtab,$idcoupon){
        $db=$this->dbInstance();
        $idtab=intval($idtab);
        $idcoupon=intval($idcoupon);
        $db->delete("#_coupon", "id=$idcoupon and idtab=$idtab");
    }
    function publish($id){
        $id=intval($id);
        $db = $this->dbInstance();
        $sql = "select count(*) from #_tab where uid='" . $_SESSION["fbconexion"]["id"] . "' and id=" . intval($id);
        if ($db->loadResult($sql) == 1) {
            //preparar para la publicación
            $sql = "select a.*,b.appid, b.appsecret,b.appkey from #_tab a inner join #_aplicacion b on a.idapp=b.id where a.uid='" . $_SESSION["fbconexion"]["id"] . "' and a.id=" . intval($id);
            $r = $db->loadObjectRow($sql);
            $fb = $this->loadModel("fbSDK");
            $fb->login($r->appid, $r->appsecret);
            $fql = "select has_added_app,page_url from page where page_id=" . $r->idpagina;
            $res = $fb->fqlQuery($fql, $r->appid, $r->appsecret);
            if ($res[0]["has_added_app"] == "true" || $res[0]["has_added_app"] == true) {
                echo $res[0]["page_url"]."?sk=app_".$r->appid;
            } else {
                echo "http://facebook.com/add.php?api_key=" . $r->appkey . "&pages=1&page=$r->idpagina";
            }
        }
    }
}
?>
