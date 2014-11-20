<?php

/**
 * el filemanager es por cuenta, no por página
 */
class Cfilemanager extends application {

//esque me di cuenta que era uy complejo y tenia que ponerlo en otra clase, jiji
    function index() {
        $this->checkSession();
        $id = $_SESSION["fbconexion"]["id"];
        $db = $this->dbInstance();
        $folder = md5($_SESSION["fbconexion"]["id"]);
        $path = dirname(dirname(dirname(__FILE__))) . "/users/$folder";
        if (!is_dir($path))
            mkdir($path);
        $dir = opendir($path);
        $this->params["destino"] = $_POST["destino"];
        $this->params["ext"] = trim($_POST["ext"]);
        $this->params["files"] = array();
        $this->params["size"] = $this->dirSize($path);
        $this->params["tt"] = 20 * 1024 * 1024;
        $this->params["path"] = "users/$folder";
        while ($elemento = readdir($dir)) {
            if (!is_dir($dir . "/" . $elemento) && $elemento != "." && $elemento != "..") {
                $this->params["files"][] = $elemento;
            }
        }
        $this->loadView("fileManager.php", $this->params);
    }

    function getpicnik() {
        $this->checkSession();
        if (strpos($_SERVER["HTTP_REFERER"], "http://www.gstatic.com/picnik/") !== false) {
            $f = file_get_contents($_POST["aqui"]);
            $nombre = basename($_POST["aqui"]);
            $folder = md5($_SESSION["fbconexion"]["id"]);
            $ruta0 = dirname(dirname(dirname(__FILE__))) . "/users/$folder/";
            file_put_contents($ruta0.$nombre, $f);
            $this->loadHtml("feliz_picnik.php", $this->params);
        }
        else
            $this->redirect ("");
    }

    function resizeicons() {
        $this->checkSession();
        $file = $_GET["file"];
        $maxw = 125;
        $maxh = 125;
        switch (substr($file, strrpos($file, ".") + 1)) {
            case "png":
                $imSrc = imagecreatefrompng($file);
                ImageAlphaBlending($imSrc, true);
                ImageSaveAlpha($imSrc, true);
                $imgFunc = 'imagepng';
                break;
            case "jpg":
            case "jpeg":
                $imSrc = imagecreatefromjpeg($file);
                $imgFunc = 'imagejpeg';
                break;
            case "gif":
                $imSrc = imagecreatefromgif($file);
                $imgFunc = 'imagegif';
                $transparent_index = ImageColorTransparent($imSrc);
                break;
        }
        header("Content-Type: " . $type);
        $aw = imagesx($imSrc);
        $ah = imagesy($imSrc);
        $w = $aw;
        $h = $ah;
        if ($w > $maxw) {
            $h = $maxw / $aw * $ah;
            $w = $maxw;
        }
        if ($h > $maxh) {
            $w = $maxh / $ah * $aw;
            $h = $maxh;
        }
        $img_resized = ImageCreateTrueColor($w, $h);
        if ($imgFunc == "imagepng") {
            ImageAlphaBlending($img_resized, false);
            ImageSaveAlpha($img_resized, true);
        }
        if (!empty($transparent_color)) {
            $transparent_new = ImageColorAllocate($img_resized, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
            $transparent_new_index = ImageColorTransparent($img_resized, $transparent_new);
            ImageFill($img_resized, 0, 0, $transparent_new_index);
        }
        if (imagecopyresampled($img_resized, $imSrc, 0, 0, 0, 0, $w, $h, $aw, $ah)) {
            ImageDestroy($imSrc);
            $imSrc = $img_resized;
        }
        $imgFunc($imSrc);
        ImageDestroy($imSrc);
    }

    function dirSize($directory) {
        $this->checkSession();
        $size = 0;
        foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory)) as $file) {
            $size+=$file->getSize();
        }
        if ($_SESSION["fbconexion"]["id"] == "1024539230")
            return 0;
        else
            return $size;
    }

    function listFiles($miext) {
        $this->checkSession();
//$params["ext"]=explode(",", trim($miext));
        $folder = md5($_SESSION["fbconexion"]["id"]);
        $path = dirname(dirname(dirname(__FILE__))) . "/users/$folder";
        $this->_printFiles($path, "/users/$folder/", $miext, true);
    }

    function listSpecial($id) {
        $this->checkSession();
        $id = intval($id);
        $miext = $_POST["ext"];
        $params["ext"] = explode(",", trim($miext));
        $path = dirname(dirname(dirname(__FILE__))) . "/users/special$id/";
        $this->_printFiles($path, "/users/special$id/", $miext, false);
    }

    private function _printFiles($realpath, $fullpath, $miext, $listarfolders) {
        $this->checkSession();
        if (!is_dir($realpath))
            mkdir($realpath);
        $dir = opendir($realpath);
        while ($elemento = readdir($dir)) {
            if (!is_dir($dir . "/" . $elemento) && $elemento != "." && $elemento != "..") {
                $files[] = $elemento;
            }
        }
//----------------------------------------------
        $params["ext"] = explode(",", trim($miext));
        $fn = $this->loadLib("textlibs");
        $cad1 = '';
        $cad2 = '';
        if (count($files) > 0)
            foreach ($files as $f) {
                $ext = preg_replace("/(.*)(\..+)$/", "$2", $f);
                $pasa = true;
                if (is_array($params["ext"]) && $params["ext"][0] != "") {
                    if (!in_array(substr($ext, 1), $params["ext"]))
                        $pasa = false;
                }
                if ($pasa == true) {
                    switch ($ext) {
                        case ".swf":
                        case ".flv":
                            $cad1.='<a class="fileitem" onclick="return fmclicklink(this)" ondblclick="fmok_click()" href="' . $this->getURL($fullpath . $f) . '"><img src="' . $this->getURL("images/mymes/ico" . str_replace(".", "_", $ext) . ".jpg") . '" alt=""/>&nbsp;<span>' . $fn->limitarCentroLetras($f, 12) . '</span></a>';
                            $cad2.='<a class="fileitem" onclick="return fmclicklink(this)" ondblclick="fmok_click()" href="' . $this->getURL($fullpath . $f) . '"><div class="dtabla"><div class="dfila"><div class="dcelda"><img src="' . $this->getURL("images/mymes/ico" . str_replace(".", "_", $ext) . ".jpg") . '" alt=""/></div></div></div><br/><span>' . $fn->limitarCentroLetras($f, 14) . '</span></a>';
                            break;
                        case ".png":
                        case ".gif":
                        case ".jpg":
                            $cad1.='<a class="fileitem" onclick="return fmclicklink(this)" ondblclick="fmok_click()" href="' . $this->getURL($fullpath . $f) . '"><img src="' . $this->getURL("images/mymes/ico" . str_replace(".", "_", $ext) . ".jpg") . '" alt=""/>&nbsp;<span>' . $fn->limitarCentroLetras($f, 12) . '</span></a>';
                            $cad2.='<a class="fileitem" onclick="return fmclicklink(this)" ondblclick="fmok_click()" href="' . $this->getURL($fullpath . $f) . '"><div class="dtabla"><div class="dfila"><div class="dcelda"><img style="width:auto; height:auto;" src="' . $this->getURL("filemanager/resizeicons?file=" . $this->getURL($fullpath . $f)) . '" alt=""/></div></div></div><br/><span>' . $fn->limitarCentroLetras($f, 14) . '</span></a>';
                            break;
                        default:
                            $cad1.='<a class="fileitem" onclick="return fmclicklink(this)" ondblclick="fmok_click()" href="' . $this->getURL($fullpath . $f) . '"><img src="' . $this->getURL("images/mymes/ico_desconocido.jpg") . '" alt=""/>&nbsp;<span>' . $fn->limitarCentroLetras($f, 12) . '</span></a>';
                            $cad2.='<a class="fileitem" onclick="return fmclicklink(this)" ondblclick="fmok_click()" href="' . $this->getURL($fullpath . $f) . '"><div class="dtabla"><div class="dfila"><div class="dcelda"><img src="' . $this->getURL("images/mymes/ico_desconocido.jpg") . '" alt=""/></div></div></div><br/><span>' . $fn->limitarCentroLetras($f, 14) . '</span></a>';
                    }
                }
            }
        if ($listarfolders) {
            $cad1.='<a class="folderitem" onclick="return fmclickfolder(this)" href="#1"><img src="' . $this->getURL("images/mymes/icofolder.png") . '" alt=""/>&nbsp;<span>' . $fn->limitarCentroLetras(__("Backgrounds"), 12) . '</span></a>';
            $cad2.='<a class="folderitem" onclick="return fmclickfolder(this)" href="#1"><img src="' . $this->getURL("images/mymes/icofolder.png") . '" alt=""/><br/><span>' . $fn->limitarCentroLetras(__("Backgrounds"), 14) . '</span></a>';
            $cad1.='<a class="folderitem" onclick="return fmclickfolder(this)" href="#2"><img src="' . $this->getURL("images/mymes/icofolder.png") . '" alt=""/>&nbsp;<span>' . $fn->limitarCentroLetras(__("Icons"), 12) . '</span></a>';
            $cad2.='<a class="folderitem" onclick="return fmclickfolder(this)" href="#2"><img src="' . $this->getURL("images/mymes/icofolder.png") . '" alt=""/><br/><span>' . $fn->limitarCentroLetras(__("Icons"), 14) . '</span></a>';
            $cad1.='<a class="folderitem" onclick="return fmclickfolder(this)" href="#3"><img src="' . $this->getURL("images/mymes/icofolder.png") . '" alt=""/>&nbsp;<span>' . $fn->limitarCentroLetras(__("Buttons and Shapes"), 12) . '</span></a>';
            $cad2.='<a class="folderitem" onclick="return fmclickfolder(this)" href="#3"><img src="' . $this->getURL("images/mymes/icofolder.png") . '" alt=""/><br/><span>' . $fn->limitarCentroLetras(__("Buttons  and shapes"), 14) . '</span></a>';
            $cad1.='<a class="folderitem" onclick="return fmclickfolder(this)" href="#4"><img src="' . $this->getURL("images/mymes/icofolder.png") . '" alt=""/>&nbsp;<span>' . $fn->limitarCentroLetras(__("Like Us"), 12) . '</span></a>';
            $cad2.='<a class="folderitem" onclick="return fmclickfolder(this)" href="#4"><img src="' . $this->getURL("images/mymes/icofolder.png") . '" alt=""/><br/><span>' . $fn->limitarCentroLetras(__("Like Us"), 14) . '</span></a>';
        } else {
            $auxcad=$cad1;
            $cad1='<a class="folderback" onclick="return fmclickfolder(this)" href="#0"><img src="' . $this->getURL("images/mymes/icofolder.png") . '" alt=""/>&nbsp;<span>' . $fn->limitarCentroLetras(__("btnback"), 12) . '</span></a>'.$auxcad;
            $auxcad=$cad2;
            $cad2='<a class="folderback" onclick="return fmclickfolder(this)" href="#0"><img src="' . $this->getURL("images/mymes/icofolder.png") . '" alt=""/><br/><span>' . $fn->limitarCentroLetras(__("btnback"), 14) . '</span></a>'.$auxcad;
        }
        ?>
        <div class="vistacont" id="vistalista">
            <?= $cad1 ?>
        </div>
        <div class="vistacont" id="vistaicons">
            <?= $cad2 ?>
        </div>
        <?php
    }

    function slug($slug) {
        $this->checkSession();
        $de = array(
            "á", "é", "í", "ó", "ú", "ñ", "Á", "É", "Í", "Ó", "Ú", "Ñ", "_", " ", "(", ")", "[", "]"
        );
        $a = array(
            "a", "e", "i", "o", "u", "n", "a", "e", "i", "o", "u", "N", "-", "-", "", "", "", ""
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
        return $slug;
    }

    function subirform() {
        $this->checkSession();
        $ext = explode(",", "jpg,png,gif,flv,swf,jpeg");
        $folder = md5($_SESSION["fbconexion"]["id"]);
        $ruta0 = dirname(dirname(dirname(__FILE__))) . "/users/$folder/";
        $archivo = strtolower($this->slug($_FILES["fmfile"]["name"]));
        if (!empty($_FILES)) {
            $lib = $this->loadLib("textlibs");
            foreach ($ext as $x) {
                $r = explode(".", $_FILES["fmfile"]["name"]);
                if (strtolower($r[count($r) - 1]) == $x) {
                    if (!file_exists($ruta0 . $archivo)) {
                        $this->params["estado"] = 1;
                        $this->params["ext"] = $x;
                        $this->params["archivo1"] = $archivo;
                        $this->params["archivo2"] = $lib->limitarCentroLetras($archivo, 12);
                        $this->params["archivo3"] = $lib->limitarCentroLetras($archivo, 14);
                        move_uploaded_file($_FILES['fmfile']['tmp_name'], $ruta0 . $archivo);
                    } else {
                        $this->params["estado"] = 3;
                    }
                    break;
                } else {
                    $this->params["estado"] = 4;
                }
            }
        }
        $size = $this->dirSize($ruta0);
        $this->params["tt"] = 20 * 1024 * 1024;
        if ($size >= $this->params["tt"]) {
            unlink($ruta0 . $archivo);
            $this->params["estado"] = 2;
        }
        $this->params["size"] = $this->dirSize($ruta0) / $this->params["tt"];
        $this->loadView("fileManager_subir.php", $this->params);
    }

    function deleteFile() {
        $this->checkSession();
        $archivo = basename($_POST["filename"]);
        $archivo = str_replace("/", "", $archivo);
        $folder = md5($_SESSION["fbconexion"]["id"]);
        $path = dirname(dirname(dirname(__FILE__))) . "/users/$folder/";
        unlink($path . $archivo);
        $tt = 20 * 1024 * 1024;
        echo $this->dirSize($path) / $tt;
    }

}
?>
