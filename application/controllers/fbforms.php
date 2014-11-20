<?php

class Cfbforms extends application {

    function plantillas($id) {
        $sql = "select contenido from #_templates where id=" . intval($id);
        $db = $this->dbInstance();
        echo $db->loadResult($sql);
    }

    function widgets($mp, $id,$e,$help) {
        $this->$mp($id,$help);
    }

    function _getCTL($id) {
        $db = $this->dbInstance();
        $sql = "select * from #_widgeted where marca='" . $id . "'";
        $res = $db->loadObjectRow($sql);
        return $res->estructura;
    }

    function _displayOptions($vars, $compare="") {
        if (count($vars) > 0)
            foreach ($vars as $key => $v) {
                echo "\n\t" . '<option value="' . $key . '" ' . ($compare == $key ? "selected" : "") . '>' . $v . '</option>';
            }
    }

    function _extras($obj) {
        ?>
        <div class="ctab">
            <div class="edbox_fila edbox_fila2">
                <label><?=__("lblwidth")?></label>
                <input alt="<?=__("lblwidth")?>" class="edb_campo edb_text integer" id="width" value="<?= round(abs($obj->width?$obj->width:"150")) ?>"/>
            </div>
            <div class="edbox_fila edbox_fila4">
                <label><?=__("lblheight")?></label>
                <input alt="<?=__("lblheight")?>" class="edb_campo edb_text integer" id="height" value="<?= round(abs($obj->height?$obj->height:"150")) ?>"/>
            </div>
            <div class="edbox_fila">
                <label><?=__("lblsendto")?></label>
                <select alt="<?=__("lblsendto")?>" class="edb_campo required edb_text" id="sp_1">
                    <?=$this->_displayOptions(array(
                        "5"=>__("txtnormal"),
                        "7"=>__("txtfront"),
                        "3"=>__("txtback"),
                    ), $obj->sp_1)?>
                </select>
            </div>
            <div class="edbox_fila">
                <label><?=__("Use border")?></label>
                <select alt="<?=__("Use border")?>" class="edb_campo required edb_text" id="sp_2">
                    <?=$this->_displayOptions(array(
                        "0"=>__("txtno"),
                        "1"=>__("txtyes"),
                    ), $obj->sp_2)?>
                </select>
            </div>
            <div class="edbox_fila edbox_fila2">
                <label><?=__("Border Color")?></label>
                <input alt="<?=__("Border Color")?>" class="edb_campo edb_text pasetcolor" id="sp_3" value="<?=$obj->sp_3?>"/>
            </div>
            <div class="edbox_fila edbox_fila4">
                <label><?=__("Border Width")?></label>
                <select alt="<?=__("Border Width")?>" class="edb_campo required edb_text" id="sp_4">
                    <?=$this->_displayOptions(array(
                        "1"=>1,
                        "2"=>2,
                        "3"=>3,
                        "4"=>4,
                        "5"=>5,
                        "6"=>6,
                        "7"=>7,
                        "8"=>8,
                        "9"=>9,
                        "10"=>10,
                    ), $obj->sp_4)?>
                </select>
            </div>
        </div>
        <?php
    }

    /**
     * HTML
     */
    function p1($id,$help="") {
        $real = $this->_getCTL($id);
        $a = json_decode(urldecode($real));
        $marca = mktime() . "form";
        ?>
        <div id="edbox_bodyw1">
            <div id="edbox_content">
                <form id="<?= $marca ?>" method="post" action="#">
                    <div id="labeltabs">
                        <div>Widget</div>
                         <div>General</div><?=($help!=""?'<a target="_blank" href="'.$this->getURL(LANG."support/tutorials#".$help).'">Help</a>':'')?>
                    </div>
                    <div id="contenttabs">
                        <div class="ctab">
                            <div class="edbox_fila">
                                <label><?=__("HTML Code")?></label>
                                <textarea alt="<?=__("HTML Code")?>" class="edb_campo edb_text edb_area" id="edb_w1"><?= $a->edb_w1 ?></textarea>
                            </div>
                        </div>

                        <?= $this->_extras($a) ?>
                    </div>
                    <div class="edbox_fila">
                        <input type="submit" id="edb_submit" value="<?=__("btnsave")?>"/>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
            saveProperty('<?= $marca ?>','<?= $id ?>');
        </script>
        <?php
    }

    /**
     * insertar Flash
     */
    function p2($id,$help="") {
        $real = $this->_getCTL($id);
        $a = json_decode(urldecode($real));
        $marca = mktime() . "form";
        ?>
        <div id="edbox_bodyw1">
            <div id="edbox_content">
                <form id="<?= $marca ?>" method="post" action="#">
                    <div id="labeltabs">
                        <div>Widget</div>
                        <div>General</div><?=($help!=""?'<a target="_blank" href="'.$this->getURL(LANG."support/tutorials#".$help).'">Help</a>':'')?>
                    </div>
                    <div id="contenttabs">
                        <div class="ctab">
                            <div class="edbox_fila">
                                <label><?=__("Link")?>:</label>
                                <input alt="<?=__("Link")?>" class="edb_campo required edb_text edb_pafilem pahtml" id="edb_w1" value="<?= $a->edb_w1 ?>"/>
                                <a href="#edb_w1" id="btn_fm1" title="Attach a picture from your computer" class="edb_icopafile"></a>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Flash Vars")?>:</label>
                                <input alt="<?=__("Flash Vars")?>" class="edb_campo edb_text" id="edb_w2" value="<?= $a->edb_w2 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Quality")?>:</label>
                                <select alt="<?=__("Quality")?>" class="edb_campo required edb_text" id="edb_w3">
                                    <option value="best" <?= ($a->edb_w3 == "best" ? "selected" : "") ?>>best</option>
                                    <option value="high" <?= ($a->edb_w3 == "high" ? "selected" : "") ?>>high</option>
                                    <option value="medium" <?= ($a->edb_w3 == "medium" ? "selected" : "") ?>>medium</option>
                                    <option value="autohight" <?= ($a->edb_w3 == "autohight" ? "selected" : "") ?>>autohight</option>
                                    <option value="autolow" <?= ($a->edb_w3 == "autolow" ? "selected" : "") ?>>autolow</option>
                                    <option value="low" <?= ($a->edb_w3 == "low" ? "selected" : "") ?>>low</option>
                                </select>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Wmode")?></label>
                                <select alt="<?=__("Wmode")?>" class="edb_campo required edb_text" id="edb_w4">
                                    <option value="transparent" <?= ($a->edb_w4 == "transparent" ? "selected" : "") ?>>transparent</option>
                                    <option value="opaque" <?= ($a->edb_w4 == "opaque" ? "selected" : "") ?>>opaque</option>
                                </select>
                            </div>
                        </div>
                        <?= $this->_extras($a) ?>
                    </div>
                    <div class="edbox_fila">
                        <input type="submit" id="edb_submit" value="<?=__("btnsave")?>"/>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
        fmanager("#btn_fm1","swf");
        saveProperty('<?= $marca ?>','<?= $id ?>');
        </script>
        <?php
    }

    /**
     * insertar Comentario
     */
    function p3($id,$help="") {
        $real = $this->_getCTL($id);
        $a = json_decode(urldecode($real));
        $marca = mktime() . "form";
        ?>
        <div id="edbox_bodyw1">
            <div id="edbox_content">
                <form id="<?= $marca ?>" method="post" action="#">
                    <div id="labeltabs">
                        <div>Widget</div>
                        <div>General</div><?=($help!=""?'<a target="_blank" href="'.$this->getURL(LANG."support/tutorials#".$help).'">Help</a>':'')?>
                    </div>
                    <div id="contenttabs">
                        <div class="ctab">
                            <div class="edb_campo edbox_fila">
                                <label><?=__("URL to discuss")?>:</label>
                                <input alt="<?=__("URL to discuss")?>" class="edb_campo edb_text pahtml" id="edb_w1" value="<?= $a->edb_w1 ?>"/>
                            </div>
                            <div class="edb_campo edbox_fila">
                                <label><?=__("Number of posts")?>:</label>
                                <input alt="<?=__("Number of posts")?>" class="edb_campo required number integer edb_text" id="edb_w2" value="<?= $a->edb_w2 ?>"/>
                            </div>
                            <div class="edb_campo edbox_fila">
                                <label><?=__("Publish feed")?>:</label>
                                <select alt="<?=__("Publish feed")?>" class="edb_campo required edb_text" id="edb_w4">
                                    <option value="true" <?= ($a->edb_w4 == "true" ? "selected" : "") ?>>Yes</option>
                                    <option value="false" <?= ($a->edb_w4 == "false" ? "selected" : "") ?>>No</option>
                                </select> 
                            </div>
                            <div class="edb_campo edbox_fila">
                                <label><?=__("Color scheme")?>:</label>
                                <select alt="<?=__("Color Scheme")?>" class="edb_campo required edb_text" id="edb_w3">
                                    <option value="light" <?= ($a->edb_w3 == "light" ? "selected" : "") ?>>Light</option>
                                    <option value="dark" <?= ($a->edb_w3 == "dark" ? "selected" : "") ?>>Dark</option>
                                </select>                        
                            </div>
                        </div>
                        <?= $this->_extras($a) ?>
                    </div>
                    <div class="edbox_fila">
                        <input type="submit" id="edb_submit" value="<?=__("btnsave")?>"/>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
        saveProperty('<?= $marca ?>','<?= $id ?>');
        </script>
        <?php
    }

    /**
     * insertar vídeo
     */
    function p4($id,$help="") {
        $real = $this->_getCTL($id);
        $a = json_decode(urldecode($real));
        $marca = mktime() . "form";
        ?>
        <div id="edbox_bodyw1">
            <div id="edbox_content">
                <form id="<?= $marca ?>" method="post" action="#">
                    <div id="labeltabs">
                        <div>Widget</div>
                        <div>General</div><?=($help!=""?'<a target="_blank" href="'.$this->getURL(LANG."support/tutorials#".$help).'">Help</a>':'')?>
                    </div>
                    <div id="contenttabs">
                        <div class="ctab">
                            <div class="edbox_fila">
                                <label><?=__("Link")?>:</label>
                                <input alt="<?=__("Link")?>" class="edb_campo required edb_text edb_pafilem pahtml" id="edb_w1" value="<?= $a->edb_w1 ?>"/>
                                <a href="#edb_w1" id="btn_fm1" title="Attach a picture from your computer" class="edb_icopafile"></a>
                            </div>
                        </div>
                        <div class="edbox_fila">
                            <label><?=__("Image cover")?>:</label>
                            <input alt="<?=__("Image Cover")?>" class="edb_campo edb_text edb_pafilem pahtml" id="edb_w2" value="<?= $a->edb_w2 ?>"/>
                            <a id="btn_fm2" href="#edb_w2" title="Attach a picture from your computer" class="edb_icopafile"></a>
                        </div>
                        <?= $this->_extras($a) ?>
                    </div>
                    <div class="edbox_fila">
                        <input type="submit" id="edb_submit" value="<?=__("btnsave")?>"/>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
        fmanager("#btn_fm1","flv");
        fmanager("#btn_fm2","jpg,png,gif");
        saveProperty('<?= $marca ?>','<?= $id ?>');
        </script>
        <?php
    }

    /**
     * RSS
     */
    function p5($id,$help="") {
        $real = $this->_getCTL($id);
        $a = json_decode(urldecode($real));
        $marca = mktime() . "form";
        ?>
        <div id="edbox_bodyw1">
            <div id="edbox_content">
                <form id="<?= $marca ?>" method="post" action="#">
                    <div id="labeltabs">
                        <div>Widget</div>
                        <div>General</div><?=($help!=""?'<a target="_blank" href="'.$this->getURL(LANG."support/tutorials#".$help).'">Help</a>':'')?>
                    </div>
                    <div id="contenttabs">
                        <div class="ctab">
                            <div class="edbox_fila">
                                <label>Feed URL:<em>http://www.mysite.com/feed</em></label>
                                <input alt="<?=__("Feed URL")?>" class="edb_campo required edb_text pahtml" id="edb_w1" value="<?= $a->edb_w1 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Show Title")?>:</label>
                                <select alt="<?=__("Show Title")?>" class="edb_campo required edb_text" id="edb_w2">
                                    <?=
                                    $this->_displayOptions(array(
                                        "yes" => "Yes",
                                        "no" => "No",
                                            ), $a->edb_w2);
                                    ?>
                                </select>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Display mode")?>:</label>
                                <select alt="<?=__("Display mode")?>" class="edb_campo required edb_text" id="edb_w3">
                                    <?=
                                    $this->_displayOptions(array(
                                        "brief" => "Brief",
                                        "detail" => "Detail",
                                        "compact" => "Compact",
                                            ), $a->edb_w3);
                                    ?>
                                </select>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Number of Feeds")?>:</label>
                                <input alt="<?=__("Number of feeds")?>" class="edb_campo required edb_text" id="edb_w4" value="<?= $a->edb_w4 ?>"/>
                            </div>
                        </div>
                        <?= $this->_extras($a) ?>
                    </div>
                    <div class="edbox_fila">
                        <input type="submit" id="edb_submit" value="<?=__("btnsave")?>"/>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
        saveProperty('<?= $marca ?>','<?= $id ?>');
        </script>
        <?php
    }

    /**
     * insertar youtube
     */
    function p7($id,$help="") {
        $real = $this->_getCTL($id);
        $a = json_decode(urldecode($real));
        $marca = mktime() . "form";
        ?>
        <div id="edbox_bodyw1">
            <div id="edbox_content">
                <form id="<?= $marca ?>" method="post" action="#">
                    <div id="labeltabs">
                        <div>Widget</div>
                        <div>General</div><?=($help!=""?'<a target="_blank" href="'.$this->getURL(LANG."support/tutorials#".$help).'">Help</a>':'')?>
                    </div>
                    <div id="contenttabs">
                        <div class="ctab">
                            <div class="edbox_fila">
                                <label><?=__("Video URL")?>:<em>http://www.youtube.com/watch?v=aYyb2Zs6Arc</em></label>
                                <input alt="<?=__("Video URL")?>" class="edb_campo required edb_text pahtml" id="edb_w1" value="<?= $a->edb_w1 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Watch in HD")?>:</label>
                                <select alt="<?=__("Watch in HD")?>" class="edb_campo required edb_text" id="edb_w2">
                                    <option value="0" <?= $a->edb_w2 == 0 ? "select" : "" ?>>No</option>
                                    <option value="1" <?= $a->edb_w2 == 1 ? "select" : "" ?>>Sí</option>
                                </select>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Image cover")?>:</label>
                                <input alt="<?=__("Image Cover")?>" class="edb_campo edb_text edb_pafilem pahtml" id="edb_w3" value="<?= $a->edb_w3 ?>"/>
                                <a id="btn_fm1" href="#edb_w3" title="Attach a picture from your computer" class="edb_icopafile"></a>
                            </div>
                        </div>
                        <?= $this->_extras($a) ?>
                    </div>
                    <div class="edbox_fila">
                        <input type="submit" id="edb_submit" value="<?=__("btnsave")?>"/>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
        fmanager("#btn_fm1","jpg,png,gif");
        saveProperty('<?= $marca ?>','<?= $id ?>');
        </script>
        <?php
    }

    /**
     * mixpod
     */
    function p8($id,$help="") {
        $real = $this->_getCTL($id);
        $a = json_decode(urldecode($real));
        $marca = mktime() . "form";
        ?>
        <div id="edbox_bodyw1">
            <div id="edbox_content">
                <form id="<?= $marca ?>" method="post" action="#">
                    <div id="labeltabs">
                        <div>Widget</div>
                        <div>General</div><?=($help!=""?'<a target="_blank" href="'.$this->getURL(LANG."support/tutorials#".$help).'">Help</a>':'')?>
                    </div>
                    <div id="contenttabs">
                        <div class="ctab">
                            <div class="edbox_fila">
                                <label><?=__("Playlist URL")?>:</label>
                                <input alt="<?=__("Playlist URL")?>" class="edb_campo required edb_text pahtml" id="edb_w1" value="<?= $a->edb_w1 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Autoplay")?>:</label>
                                <select alt="<?=__("Autoplay")?>" class="edb_campo required edb_text" id="edb_w2">
                                    <?=
                                    $this->_displayOptions(array(
                                        "false" => "No",
                                        "true" => "Yes",
                                            ), $a->edb_w2)
                                    ?>
                                </select>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Random")?>:</label>
                                <select alt="<?=__("Random")?>" class="edb_campo required edb_text" id="edb_w3">
                                    <?=
                                    $this->_displayOptions(array(
                                        "0" => "No",
                                        "1" => "Yes",
                                            ), $a->edb_w3)
                                    ?>
                                </select>
                            </div>
                        </div>
                        <?= $this->_extras($a) ?>
                    </div>
                    <div class="edbox_fila">
                        <input type="submit" id="edb_submit" value="<?=__("btnsave")?>"/>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
        saveProperty('<?= $marca ?>','<?= $id ?>');
        </script>
        <?php
    }

    /**
     * addthis
     */
    function p9($id,$help="") {
        $real = $this->_getCTL($id);
        $a = json_decode(urldecode($real));
        $marca = mktime() . "form";
        ?>
        <div id="edbox_bodyw1">
            <div id="edbox_content">
                <form id="<?= $marca ?>" method="post" action="#">
                    <div id="labeltabs">
                        <div>Widget</div>
                        <div>General</div><?=($help!=""?'<a target="_blank" href="'.$this->getURL(LANG."support/tutorials#".$help).'">Help</a>':'')?>
                    </div>
                    <div id="contenttabs">
                        <div class="ctab">
                            <div class="edbox_fila">
                                <label><?=__("URL to share")?>:</label>
                                <input alt="<?=__("URL to share")?>" class="edb_campo required edb_text pahtml" id="edb_w1" value="<?= $a->edb_w1 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("txtnombre")?>:</label>
                                <input alt="<?=__("txtnombre")?>" class="edb_campo edb_text" id="edb_w3" value="<?= $a->edb_w3 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("AddThis ID")?>:</label>
                                <input alt="<?=__("Addthis ID")?>" class="edb_campo edb_text" id="edb_w4" value="<?= $a->edb_w4 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Style")?>:</label>
                                <select alt="<?=__("Style")?>" class="edb_campo required edb_text" id="edb_w2">
                                    <?=
                                    $this->_displayOptions(array(
                                        "compact" => "Compact",
                                        "big" => "Big",
                                        "boxcount" => "Box Count",
                                            ), $a->edb_w2)
                                    ?>
                                </select>
                            </div>
                        </div>
                        <?= $this->_extras($a) ?>
                    </div>
                    <div class="edbox_fila">
                        <input type="submit" id="edb_submit" value="<?=__("btnsave")?>"/>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
        saveProperty('<?= $marca ?>','<?= $id ?>');
        </script>
        <?php
    }

    /**
     * insertar listado de youtube
     */
    function p10($id,$help="") {
        $real = $this->_getCTL($id);
        $a = json_decode(urldecode($real));
        $marca = mktime() . "form";
        ?>
        <div id="edbox_bodyw1" class="">
            <div id="edbox_content">
                <form id="<?= $marca ?>" method="post" action="#">
                    <div id="labeltabs">
                        <div>Widget</div>
                        <div>General</div><?=($help!=""?'<a target="_blank" href="'.$this->getURL(LANG."support/tutorials#".$help).'">Help</a>':'')?>
                    </div>
                    <div id="contenttabs">
                        <div class="ctab">
                            <div class="edbox_fila">
                                <label><?=__("Videos")?>:</label>
                                <div id="edb_contimages">
                                    <?php
                                    for ($i = 0; $i < count($a->edb_wc); $i++) {
                                        echo '<div class="edb_imagesitems"><div class="edb_eliminar" onclick="removeGal(this)">x</div><span>' . $a->edb_wc[$i] . '</span></div>';
                                        echo '<div class="edb_imagestitles"><textarea class="edb_campo edb_text edb_textarea" id="edb_wd[]">' . $a->edb_wd[$i] . '</textarea></div>';
                                    }
                                    ?>
                                </div>
                                <input type="text" id="edb_subirgal" class="edb_subirtxt edb_pafilem"/>
                                <a id="btn_fm2" href="#edb_subirgal" title="Click to upload your pictures." class="edb_icopasubir">+</a>
                                <div style="display:none" id="edb_wb">
                                </div>
                                <input type="hidden" id="edb_conteo" value="<?= $a->edb_conteo ?>"/>
                            </div>
                        </div>
                        <?= $this->_extras($a) ?>
                    </div>
                    <div class="edbox_fila">
                        <input type="submit" id="edb_submit" value="<?=__("btnsave")?>"/>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
        $(".edb_icopasubir").css("margin-left", 1);
        //sucede cuando se va agregar una foto a la lista
        $(".edb_icopasubir").click(function(){
            obj=$(this).attr("href");
            r=$(obj).val();
            addGalItem(r);
            $(obj).val("");
            $(obj).empty();
            return false;
        });
                                                            
        refreshGal=function(){
            $("#edb_wb").empty();
            i=0;
            cad='';
            $("#edb_contimages span").each(function(){
                cad+='<input type="hidden" class="edb_campo edb_text edb_textarea" id="edb_wc[]" value="'+$(this).text()+'"/>';
                i++;
            });
            $("#edb_conteo").val(i);
            $("#edb_wb").html(cad);
            $(".edb_imagesitems").unbind('click').click(function(){
                $(this).next().slideToggle(450, function(){});
            });
        }
        removeGal=function(r){
            a=$(r).parent().next().remove();
            a=$(r).parent().remove();
                                                                
            refreshGal();
        }
        addGalItem=function(r,x){
            if(x==null)
                x="";
            r=r.split("<").join("").split(">").join("");
            if(r.split(" ").join("")!=""){
                cad='<div class="edb_imagesitems"><div class="edb_eliminar" onclick="removeGal(this)">x</div><span>'+r+'</span></div>';
                cad+='<div class="edb_imagestitles"><textarea class="edb_campo edb_text edb_textarea">'+x+'</textarea></div>';
                $("#edb_contimages").append(cad);
            }
            refreshGal();
        }
        refreshGal();
        saveProperty('<?= $marca ?>','<?= $id ?>');
        </script>
        <?php
    }

    /**
     * insertar Imágen
     */
    function p12($id,$help="") {
        $real = $this->_getCTL($id);
        $a = json_decode(urldecode($real));
        $marca = mktime() . "form";
        ?>
        <div id="edbox_bodyw1">
            <div id="edbox_content">
                <form id="<?= $marca ?>" method="post" action="#">
                    <div id="labeltabs">
                        <div>Widget</div>
                        <div>General</div><?=($help!=""?'<a target="_blank" href="'.$this->getURL(LANG."support/tutorials#".$help).'">Help</a>':'')?>
                    </div>
                    <div id="contenttabs">
                        <div class="ctab">
                            <div class="edbox_fila">
                                <label><?=__("Image")?>:</label>
                                <input alt="<?=__("Image")?>" class="edb_campo required edb_text edb_pafilem pahtml" id="edb_w1" value="<?= $a->edb_w1 ?>"/>
                                <a id="btn_fm1" href="#edb_w1" title="Attach a picture from your computer" class="edb_icopafile"></a>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Link")?>:</label>
                                <input alt="<?=__("Link")?>" class="edb_campo edb_text pahtml" id="edb_w2" value="<?= $a->edb_w2 ?>"/>
                            </div>
                        </div>
                        <?= $this->_extras($a) ?>
                    </div>
                    <div class="edbox_fila">
                        <input type="submit" id="edb_submit" value="<?=__("btnsave")?>"/>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
        fmanager("#btn_fm1","jpg,png,gif,jpeg");
        saveProperty('<?= $marca ?>','<?= $id ?>');
        </script>
        <?php
    }

    /**
     *
     * @param type $id insertar twitter
     */
    function p13($id,$help="") {
        $real = $this->_getCTL($id);
        $a = json_decode(urldecode($real));
        $marca = mktime() . "form";
        ?>
        <div id="edbox_bodyw1">
            <div id="edbox_content">
                <form id="<?= $marca ?>" method="post" action="#">
                    <div id="labeltabs">
                        <div>Widget</div>
                        <div>General</div><?=($help!=""?'<a target="_blank" href="'.$this->getURL(LANG."support/tutorials#".$help).'">Help</a>':'')?>
                    </div>
                    <div id="contenttabs">
                        <div class="ctab">
                            <div class="edbox_fila">
                                <label><?=__("Query")?>:</label>
                                <input alt="<?=__("Query")?>" class="edb_campo required edb_text" id="edb_w1" value="<?= $a->edb_w1 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Title")?>:</label>
                                <input alt="<?=__("Title")?>" class="edb_campo required edb_text" id="edb_w2" value="<?= $a->edb_w2 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Sub Title")?>:</label>
                                <input alt="<?=__("Sub Title")?>" class="edb_campo required edb_text" id="edb_w3" value="<?= $a->edb_w3 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Background color of the widget")?>:</label>
                                <input alt="<?=__("Background color of the widget")?>" class="edb_campo required edb_text pasetcolor" id="edb_w4" value="<?= $a->edb_w4 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Background color of the tweets")?>:</label>
                                <input alt="<?=__("Background color of the tweets")?>" class="edb_campo required edb_text pasetcolor" id="edb_w5" value="<?= $a->edb_w5 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Letter color")?>:</label>
                                <input alt="<?=__("Letter color")?>" class="edb_campo required edb_text pasetcolor" id="edb_w6" value="<?= $a->edb_w6 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Links color")?>:</label>
                                <input alt="<?=__("Links color")?>" class="edb_campo required edb_text pasetcolor" id="edb_w7" value="<?= $a->edb_w7 ?>"/>
                            </div>
                        </div>
                        <?= $this->_extras($a) ?>
                    </div>
                    <div class="edbox_fila">
                        <input type="submit" id="edb_submit" value="<?=__("btnsave")?>"/>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
        saveProperty('<?= $marca ?>','<?= $id ?>');
        </script>
        <?php
    }

    /**
     * ustrean
     */
    function p14($id,$help="") {
        $real = $this->_getCTL($id);
        $a = json_decode(urldecode($real));
        $marca = mktime() . "form";
        ?>
        <div id="edbox_bodyw1">
            <div id="edbox_content">
                <form id="<?= $marca ?>" method="post" action="#">
                    <div id="labeltabs">
                        <div>Widget</div>
                        <div>General</div><?=($help!=""?'<a target="_blank" href="'.$this->getURL(LANG."support/tutorials#".$help).'">Help</a>':'')?>
                    </div>
                    <div id="contenttabs">
                        <div class="ctab">
                            <div class="edbox_fila">
                                <label><?=__("URL to channel or recorded video")?>:</label>
                                <input alt="<?=__("URL to channel or recorded video")?>" class="edb_campo required edb_text pahtml" id="edb_w1" value="<?= $a->edb_w1 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Image cover")?>:</label>
                                <input alt="<?=__("Image Cover")?>" class="edb_campo edb_text edb_pafilem pahtml" id="edb_w2" value="<?= $a->edb_w2 ?>"/>
                                <a id="btn_fm1" href="#edb_w2" title="Attach a picture from your computer" class="edb_icopafile"></a>
                            </div>
                        </div>
                        <?= $this->_extras($a) ?>
                    </div>
                    <div class="edbox_fila">
                        <input type="submit" id="edb_submit" value="<?=__("btnsave")?>"/>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
        fmanager("#btn_fm1","jpg,png,gif");
        saveProperty('<?= $marca ?>','<?= $id ?>');
        </script>
        <?php
    }

    /**
     * me gusta
     */
    function p15($id,$help="") {
        $real = $this->_getCTL($id);
        $a = json_decode(urldecode($real));
        $marca = mktime() . "form";
        ?>
        <div id="edbox_bodyw1">
            <div id="edbox_content">
                <form id="<?= $marca ?>" method="post" action="#">
                    <div id="labeltabs">
                        <div>Widget</div>
                        <div>General</div><?=($help!=""?'<a target="_blank" href="'.$this->getURL(LANG."support/tutorials#".$help).'">Help</a>':'')?>
                    </div>
                    <div id="contenttabs">
                        <div class="ctab">
                            <div class="edbox_fila">
                                <label><?=__("URL to like")?>:</label>
                                <input alt="<?=__("URL to like")?>" class="edb_campo required edb_text pahtml" id="edb_w1" value="<?= $a->edb_w1 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Send Button")?>:</label>
                                <select alt="<?=__("Send Button")?>" class="edb_campo required edb_text" id="edb_w2">
                                    <?=
                                    $this->_displayOptions(array(
                                        "false" => "No",
                                        "true" => "Yes",
                                            ), $a->edb_w2)
                                    ?>
                                </select>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Layout Style")?>:</label>
                                <select alt="<?=__("Layout Style")?>" class="edb_campo required edb_text" id="edb_w3">
                                    <?=
                                    $this->_displayOptions(array(
                                        "standard" => "Standar",
                                        "button_count" => "Button Count",
                                        "box_count" => "Box Count",
                                            ), $a->edb_w3)
                                    ?>
                                </select>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Show faces")?>:</label>
                                <select alt="<?=__("Show faces")?>" class="edb_campo required edb_text" id="edb_w4">
                                    <?=
                                    $this->_displayOptions(array(
                                        "false" => "No",
                                        "true" => "Yes",
                                            ), $a->edb_w4)
                                    ?>
                                </select>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Verb to display")?>:</label>
                                <select alt="<?=__("Verb to display")?>" class="edb_campo required edb_text" id="edb_w5">
                                    <?=
                                    $this->_displayOptions(array(
                                        "like" => "Like",
                                        "recommend" => "Recommended",
                                            ), $a->edb_w5)
                                    ?>
                                </select>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Color Scheme")?>:</label>
                                <select alt="<?=__("Color Scheme")?>" class="edb_campo required edb_text" id="edb_w6">
                                    <?=
                                    $this->_displayOptions(array(
                                        "light" => "Light",
                                        "dark" => "Dark",
                                            ), $a->edb_w6)
                                    ?>
                                </select>
                            </div>
                        </div>
                        <?= $this->_extras($a) ?>
                    </div>
                    <div class="edbox_fila">
                        <input type="submit" id="edb_submit" value="<?=__("btnsave")?>"/>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
        saveProperty('<?= $marca ?>','<?= $id ?>');
        </script>
        <?php
    }

    /**
     * texto
     */
    function p17($id,$help="") {
        $real = $this->_getCTL($id);
        $a = json_decode(urldecode($real));
        $marca = mktime() . "form";
        ?>
        <div id="edbox_bodyw1" class="edbox_ckeditor">
            <div id="edbox_content">
                <form id="<?= $marca ?>" method="post" action="#">
                    <div id="labeltabs">
                        <div>Widget</div>
                        <div>General</div><?=($help!=""?'<a target="_blank" href="'.$this->getURL(LANG."support/tutorials#".$help).'">Help</a>':'')?>
                    </div>
                    <div id="contenttabs">
                        <div class="ctab">
                            <div class="edbox_fila">
                                <div style="clear:both;">
                                    <textarea alt="<?=__("HTML Code")?>" class=" edb_area" name="edb_w1" id="edb_w1"><?= (trim($a->texto)!=""?$a->texto:"<div>$a->texto</div>") ?></textarea>
                                </div>
                            </div>
                        </div>
                        <?= $this->_extras($a) ?>
                    </div>
                    <div class="edbox_fila">
                        <input type="submit" id="edb_submit" value="<?=__("btnsave")?>"/>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
            
        /*config = {
            toolbar : [
                ['Source'],
                ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink'],
                [ 'TextColor','BGColor' ],['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
                ['UIColor'],[ 'Styles','Format','Font','FontSize' ],
                [ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak' ]
            ],
            autoUpdateElement:true
        };
        var editor = CKEDITOR.replace( 'edb_w1',config );*/
        iniciarck=function(){
            tinyMCE.init({
                    theme : "advanced",
                    mode : "exact",
                    elements : "edb_w1",
                    plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
                    theme_advanced_buttons1 : "bold,italic,underline,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontselect,fontsizeselect",
                    theme_advanced_buttons2 : "bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,|,forecolor,backcolor",
                    theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,|,charmap,emotions,iespell,media,advhr,|,ltr,rtl",
                    //theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
                    theme_advanced_toolbar_location : "top",
                    theme_advanced_toolbar_align : "left",
                    force_br_newlines : false,
                    force_p_newlines : false,
                    relative_urls : false,
                    theme_advanced_fonts : 
                        "Arial=arial;"+
                        "Helvetica=helvetica;"+
                        "Sans Serif=sans-serif;"+
                        "Arial Black=arial black;"+
                        "Avant Garde=avant garde;"+
                        "Book Antiqua=book antiqua;"+
                        "Palatino=palatino;"+
                        "Comic Sans MS=comic sans ms;"+
                        "Courier New=courier new;"+
                        "Courier=courier;"+
                        "Georgia=georgia;"+
                        "Impact=impact;"+
                        "Chicago=chicago;"+
                        "Symbol=symbol;"+
                        "Tahoma=tahoma;"+
                        "Terminal=terminal;"+
                        "Monaco=monaco;"+
                        "Times New Roman=times new roman;"+
                        "Times=times;"+
                        "Trebuchet MS=trebuchet ms;"+
                        "Geneva=geneva;"+
                        "Verdana=verdana;"+
                        "Webdings=webdings;"+
                        "Wingdings=wingdings;"+
                        "Zapf Dingbats=zapf dingbats;",
                    forced_root_block : '' // Needed for 3.x
            });
        }
        if($.browser.msie && parseInt($.browser.version)==8){
            //no se hace nada
        }
        else{
            setTimeout(iniciarck, 1000);
        }
        saveProperty('<?= $marca ?>','<?= $id ?>');
        </script>
        <?php
    }

    /**
     * livestream chat
     */
    function p18($id,$help="") {
        $real = $this->_getCTL($id);
        $a = json_decode(urldecode($real));
        $marca = mktime() . "form";
        ?>
        <script src="" type="text/javascript"></script>
        <div id="edbox_bodyw1" class="">
            <div id="edbox_content">
                <form id="<?= $marca ?>" method="post" action="#">
                    <div id="labeltabs">
                        <div>Widget</div>
                        <div>General</div><?=($help!=""?'<a target="_blank" href="'.$this->getURL(LANG."support/tutorials#".$help).'">Help</a>':'')?>
                    </div>
                    <div id="contenttabs">
                        <div class="ctab">
                            <div class="edbox_fila">
                                <label><?=__("Always post to friends")?>:</label>
                                <select alt="<?=__("Always post to friends")?>" class="edb_campo required edb_text" id="edb_w2">
                                    <?=
                                    $this->_displayOptions(array(
                                        "false" => "No",
                                        "true" => "Yes"
                                            ), $a->edb_w2)
                                    ?>
                                </select>
                            </div>
                        </div>
                        <?= $this->_extras($a) ?>
                    </div>
                    <div class="edbox_fila">
                        <input type="submit" id="edb_submit" value="<?=__("btnsave")?>"/>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
        saveProperty('<?= $marca ?>','<?= $id ?>');
        </script>
        <?php
    }

    /**
     * follow us
     */
    function p19($id,$help="") {
        $real = $this->_getCTL($id);
        $a = json_decode(urldecode($real));
        $marca = mktime() . "form";
        ?>
        <script src="" type="text/javascript"></script>
        <div id="edbox_bodyw1" class="">
            <div id="edbox_content">
                <form id="<?= $marca ?>" method="post" action="#">
                    <div id="labeltabs">
                        <div>Widget</div>
                        <div>General</div><?=($help!=""?'<a target="_blank" href="'.$this->getURL(LANG."support/tutorials#".$help).'">Help</a>':'')?>
                    </div>
                    <div id="contenttabs">
                        <div class="ctab">
                            <div class="edbox_fila">
                                <label><?=__("Twitter ID")?>:</label>
                                <input alt="<?=__("Twitter URL")?>" class="edb_campo edb_text" id="edb_w1" value="<?= $a->edb_w1 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Feed URL")?>:</label>
                                <input alt="<?=__("Feed URL")?>" class="edb_campo edb_text pahtml" id="edb_w2" value="<?= $a->edb_w2 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("txtemail")?>:</label>
                                <input alt="<?=__("txtemail")?>" class="edb_campo edb_text" id="edb_w3" value="<?= $a->edb_w3 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Delicious URL")?>:</label>
                                <input alt="<?=__("Delicious URL")?>" class="edb_campo edb_text pahtml" id="edb_w4" value="<?= $a->edb_w4 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("My Space URL")?>:</label>
                                <input alt="<?=__("My Space URL")?>" class="edb_campo edb_text pahtml" id="edb_w5" value="<?= $a->edb_w5 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Yahoo ID")?>:</label>
                                <input alt="<?=__("Yahoo ID")?>" class="edb_campo edb_text" id="edb_w6" value="<?= $a->edb_w6 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Skype ID")?>:</label>
                                <input alt="<?=__("Skype ID")?>" class="edb_campo edb_text" id="edb_w7" value="<?= $a->edb_w7 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Windows Live Address")?>:</label>
                                <input alt="<?=__("Windows Live Address")?>" class="edb_campo edb_text" id="edb_w8" value="<?= $a->edb_w8 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Google Buzz ID")?>:</label>
                                <input alt="<?=__("Google Buzz ID")?>" class="edb_campo edb_text" id="edb_w9" value="<?= $a->edb_w9 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Youtube ID")?>:</label>
                                <input alt="<?=__("Youtube ID")?>" class="edb_campo edb_text" id="edb_w10" value="<?= $a->edb_w10 ?>"/>
                            </div>
                        </div>
                        <?= $this->_extras($a) ?>
                    </div>
                    <div class="edbox_fila">
                        <input type="submit" id="edb_submit" value="<?=__("btnsave")?>"/>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
        saveProperty('<?= $marca ?>','<?= $id ?>');
        </script>
        <?php
    }

    /**
     * galeria fb
     */
    function p21($id,$help="") {
        $real = $this->_getCTL($id);
        $a = json_decode(urldecode($real));
        $marca = mktime() . "form";
        ?>
        <div id="edbox_bodyw1" class="">
            <div id="edbox_content">
                <form id="<?= $marca ?>" method="post" action="#">
                    <div id="labeltabs">
                        <div>Widget</div>
                        <div>General</div><?=($help!=""?'<a target="_blank" href="'.$this->getURL(LANG."support/tutorials#".$help).'">Help</a>':'')?>
                    </div>
                    <div id="contenttabs">
                        <div class="ctab">
                            <div class="edbox_fila">
                                <label><?=__("Style")?>:</label>
                                <label class="optgal"><img src="<?= $this->getURL("images/mini_gal2.jpg") ?>"/></label>
                                <label class="optgal"><img src="<?= $this->getURL("images/mini_gal3.jpg") ?>"/></label>
                                <label class="optgal"><img src="<?= $this->getURL("images/mini_gal0.jpg") ?>"/></label>
                                <label class="optgal"><img src="<?= $this->getURL("images/mini_gal1.jpg") ?>"/></label>
                                <input type="hidden" id="edb_w1" value="<?= $a->edb_w1 ?>" class="edb_campo edb_text"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Images")?></label>
                                <div id="edb_contimages">
                                    <?php
                                    for ($i = 0; $i < count($a->edb_wc); $i++) {
                                        echo '<div class="edb_imagesitems"><div class="edb_eliminar" onclick="removeGal(this)">x</div><span>' . $a->edb_wc[$i] . '</span></div>';
                                        echo '<div class="edb_imagestitles"><textarea class="edb_campo edb_text edb_textarea" id="edb_wd[]">' . $a->edb_wd[$i] . '</textarea></div>';
                                    }
                                    ?>
                                </div>
                                <input type="text" id="edb_subirgal" class="edb_subirtxt edb_pafilem edb_pafilegal"/>
                                <a id="btn_fm1" href="#edb_subirgal" title="Attach a picture from your computer" class="edb_icopafile"></a>
                                <a id="btn_fm2" href="#edb_subirgal" title="Click to upload your pictures." class="edb_icopasubir">+</a>
                                <div style="display:none" id="edb_wb">
                                </div>
                                <input type="hidden" id="edb_conteo" class="required" value="<?= $a->edb_conteo ?>"/>
                            </div>
                        </div>
                        <?= $this->_extras($a) ?>
                    </div>
                    <div class="edbox_fila">
                        <input type="submit" id="edb_submit" value="<?=__("btnsave")?>"/>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
        fmanager("#btn_fm1","jpg,png,gif");
        $(".optgal").click(function(){
            $(".optgal.selected").removeClass("selected");
            $(this).addClass("selected");
            $("#edb_w1").val($(".optgal").index(this));
        });
        adb=$(".optgal")[<?= $a->edb_w1 ?>]
        $(adb).addClass("selected");
        $(".edb_icopasubir").css("margin-left", 1);
        //sucede cuando se va agregar una foto a la lista
        $(".edb_icopasubir").click(function(){
            obj=$(this).attr("href");
            r=$(obj).val();
            addGalItem(r);
            $(obj).val("");
            $(obj).empty();
            return false;
        });
                                                            
        refreshGal=function(){
            $("#edb_wb").empty();
            i=0;
            cad='';
            $("#edb_contimages span").each(function(){
                cad+='<input type="hidden" class="edb_campo edb_text edb_textarea" id="edb_wc[]" value="'+$(this).text()+'"/>';
                i++;
            });
            if(i==0)
                $("#edb_conteo").val("");
            else
                $("#edb_conteo").val(i);
            $("#edb_wb").html(cad);
            $(".edb_imagesitems").unbind('click').click(function(){
                $(this).next().slideToggle(450, function(){});
            });
        }
        removeGal=function(r){
            a=$(r).parent().next().remove();
            a=$(r).parent().remove();
                                                                
            refreshGal();
        }
        addGalItem=function(r,x){
            if(x==null)
                x="";
            r=r.split("<").join("").split(">").join("");
            if(r.split(" ").join("")!=""){
                cad='<div class="edb_imagesitems"><div class="edb_eliminar" onclick="removeGal(this)">x</div><span>'+r+'</span></div>';
                cad+='<div class="edb_imagestitles"><textarea class="edb_campo edb_text edb_textarea">'+x+'</textarea></div>';
                $("#edb_contimages").append(cad);
            }
            refreshGal();
        }
        refreshGal();
        saveProperty('<?= $marca ?>','<?= $id ?>');
        </script>
        <?php
    }

    /**
     * google maps
     * 520 x 250
     */
    function p22($id,$help="") {
        $real = $this->_getCTL($id);
        $a = json_decode(urldecode($real));
        $marca = mktime() . "form";
        ?>
        <div id="edbox_bodyw1" class="">
            <div id="edbox_content">
                <form id="<?= $marca ?>" method="post" action="#">
                    <div id="labeltabs">
                        <div>Widget</div>
                        <div>General</div><?=($help!=""?'<a target="_blank" href="'.$this->getURL(LANG."support/tutorials#".$help).'">Help</a>':'')?>
                    </div>
                    <div id="contenttabs">
                        <div class="ctab">
                            <div class="edbox_fila">
                                <label><?=__("Country")?>:</label>
                                <input alt="<?=__("Country")?>" class="edb_campo required edb_text" id="edb_w4" value="<?= $a->edb_w4 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("State/Region")?>:</label>
                                <input alt="<?=__("State/Region")?>" class="edb_campo required edb_text" id="edb_w1" value="<?= $a->edb_w1 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("City")?>:</label>
                                <input alt="<?=__("City")?>" class="edb_campo required edb_text" id="edb_w2" value="<?= $a->edb_w2 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Address")?>:</label>
                                <input alt="<?=__("Address")?>" class="edb_campo required edb_text" id="edb_w3" value="<?= $a->edb_w3 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Zoom level")?>:</label>
                                <div style="float: left; clear: both; width:272px;padding: 5px 0px;">
                                    <div class="signos_slider">-</div><div class="slider" id="edb_slider1"></div><div class="signos_slider">+</div>
                                    <input alt="" class="edb_campo required edb_text marcadorspin" readonly="readonly" id="edb_w5" value="<?= $a->edb_w5 ?>" type="text"/>
                                </div>
                            </div>
                        </div>
                        <?= $this->_extras($a) ?>
                    </div>
                    <div class="edbox_fila">
                        <input type="submit" id="edb_submit" value="<?=__("btnsave")?>"/>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript" src=""></script>
        <script type="text/javascript">
        $("#edb_slider1").slider({
            range:"min",
            value:$( "#edb_w5" ).val(),
            min:1,
            max:20,
            slide: function( event, ui ) {
                $( "#edb_w5" ).val( ui.value );
            }
        })
        saveProperty('<?= $marca ?>','<?= $id ?>');
        </script>
        <?php
    }

    /**
     * paypal donate
     * 520 x 250
     */
    function p23($id,$help="") {
        $real = $this->_getCTL($id);
        $a = json_decode(urldecode($real));
        $marca = mktime() . "form";
        ?>
        <div id="edbox_bodyw1" class="">
            <div id="edbox_content">
                <form id="<?= $marca ?>" method="post" action="#">
                    <div id="labeltabs">
                        <div>Widget</div>
                        <div>General</div><?=($help!=""?'<a target="_blank" href="'.$this->getURL(LANG."support/tutorials#".$help).'">Help</a>':'')?>
                    </div>
                    <div id="contenttabs">
                        <div class="ctab">
                            <div class="edbox_fila">
                                <label><?=__("Organization's name or Service name")?>:</label>
                                <input alt="<?=__("Organization's name or Service's name")?>" class="edb_campo required edb_text" id="edb_w1" value="<?= $a->edb_w1 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Button style")?>:</label>
                                <select alt="<?=__("Button style")?>" class="edb_campo required edb_text" id="edb_w2">
                                    <?=
                                    $this->_displayOptions(array(
                                        "0" => "Simple button",
                                        "1" => "Smaller button",
                                        "2" => "Button with flags"
                                            ), $a->edb_w2)
                                    ?>
                                </select>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Item name")?>:</label>
                                <input alt="<?=__("Item name")?>" class="edb_campo required edb_text" id="edb_w3" value="<?= $a->edb_w3 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Item number")?>:</label>
                                <input alt="<?=__("Item number")?>" class="edb_campo required edb_text" id="edb_w6" value="<?= $a->edb_w6 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Currency")?>:</label>
                                <select alt="<?=__("Currency")?>" class="edb_campo required edb_text" id="edb_w4">
                                    <?=
                                    $this->_displayOptions(array(
                                        "USD" => "USD",
                                        "THB" => "THB",
                                        "CZK" => "CZK",
                                        "DKK" => "DKK",
                                        "NOK" => "NOK",
                                        "SEK" => "SEK",
                                        "AUD" => "AUD",
                                        "CAD" => "CAD",
                                        "HKD" => "HKD",
                                        "NZD" => "NZD",
                                        "SGD" => "SGD",
                                        "EUR" => "EUR",
                                        "HUF" => "HUF",
                                        "CHF" => "CHF",
                                        "GBP" => "GBP",
                                        "TWD" => "TWD",
                                        "ILS" => "ILS",
                                        "PHP" => "PHP",
                                        "MXN" => "MXN",
                                        "BRL" => "BRL",
                                        "JPY" => "JPY",
                                        "PLN" => "PLN",
                                            ), $a->edb_w4)
                                    ?>
                                </select>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("E-mail Address of your Paypal Account")?>:</label>
                                <input alt="<?=__("E-mail Address of your Paypal Account")?>" class="edb_campo required edb_text" id="edb_w5" value="<?= $a->edb_w5 ?>"/>
                            </div>
                        </div>
                        <?= $this->_extras($a) ?>
                    </div>
                    <div class="edbox_fila">
                        <input type="submit" id="edb_submit" value="<?=__("btnsave")?>"/>
                    </div>
                    <div style="display:none;">
                        <img src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif"/>
                        <img src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif"/>
                        <img src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif"/>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript" src=""></script>
        <script type="text/javascript">
                                                                                                            
        saveProperty('<?= $marca ?>','<?= $id ?>');
        </script>
        <?php
    }

    /**
     * galeria flikr
     */
    function p24($id,$help="") {
        $real = $this->_getCTL($id);
        $a = json_decode(urldecode($real));
        $marca = mktime() . "form";
        ?>
        <div id="edbox_bodyw1" class="">
            <div id="edbox_content">
                <form id="<?= $marca ?>" method="post" action="#">
                    <div id="labeltabs">
                        <div>Widget</div>
                        <div>General</div><?=($help!=""?'<a target="_blank" href="'.$this->getURL(LANG."support/tutorials#".$help).'">Help</a>':'')?>
                    </div>
                    <div id="contenttabs">
                        <div class="ctab">
                            <div class="edbox_fila">
                                <label><?=__("Style")?>:</label>
                                <label class="optgal"><img src="<?= $this->getURL("images/mini_gal2.jpg") ?>"/></label>
                                <label class="optgal"><img src="<?= $this->getURL("images/mini_gal3.jpg") ?>"/></label>
                                <label class="optgal"><img src="<?= $this->getURL("images/mini_gal0.jpg") ?>"/></label>
                                <label class="optgal"><img src="<?= $this->getURL("images/mini_gal1.jpg") ?>"/></label>
                                <input type="hidden" id="edb_w1" value="<?= $a->edb_w1 ?>" class="edb_campo edb_text"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Flikr username")?>:</label>
                                <input alt="<?=__("Flikr Username")?>" class="edb_campo required edb_text" id="edb_w2" value="<?= $a->edb_w2 ?>"/>
                            </div>
                        </div>
                        <?= $this->_extras($a) ?>
                    </div>
                    <div class="edbox_fila">
                        <input type="submit" id="edb_submit" value="<?=__("btnsave")?>"/>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
        saveProperty('<?= $marca ?>','<?= $id ?>');
        $(".optgal").click(function(){
            $(".optgal.selected").removeClass("selected");
            $(this).addClass("selected");
            $("#edb_w1").val($(".optgal").index(this));
        });
        adb=$(".optgal")[<?= $a->edb_w1 ?>]
        $(adb).addClass("selected");
        </script>
        <?php
    }

    /**
     * galeria picasa
     */
    function p25($id,$help="") {
        $real = $this->_getCTL($id);
        $a = json_decode(urldecode($real));
        $marca = mktime() . "form";
        ?>
        <div id="edbox_bodyw1" class="">
            <div id="edbox_content">
                <form id="<?= $marca ?>" method="post" action="#">
                    <div id="labeltabs">
                        <div>Widget</div>
                        <div>General</div><?=($help!=""?'<a target="_blank" href="'.$this->getURL(LANG."support/tutorials#".$help).'">Help</a>':'')?>
                    </div>
                    <div id="contenttabs">
                        <div class="ctab">
                            <div class="edbox_fila">
                                <label><?=__("Style")?>:</label>
                                <label class="optgal"><img src="<?= $this->getURL("images/mini_gal2.jpg") ?>"/></label>
                                <label class="optgal"><img src="<?= $this->getURL("images/mini_gal3.jpg") ?>"/></label>
                                <label class="optgal"><img src="<?= $this->getURL("images/mini_gal0.jpg") ?>"/></label>
                                <label class="optgal"><img src="<?= $this->getURL("images/mini_gal1.jpg") ?>"/></label>
                                <input type="hidden" id="edb_w1" value="<?= $a->edb_w1 ?>" class="edb_campo edb_text"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Picasa Album URL")?>:</label>
                                <input alt="<?=__("Picasa Album URL")?>" class="edb_campo required edb_text" id="edb_w2" value="<?= $a->edb_w2 ?>"/>
                            </div>
                        </div>
                        <?= $this->_extras($a) ?>
                    </div>
                    <div class="edbox_fila">
                        <input type="submit" id="edb_submit" value="<?=__("btnsave")?>"/>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
        saveProperty('<?= $marca ?>','<?= $id ?>');
        $(".optgal").click(function(){
            $(".optgal.selected").removeClass("selected");
            $(this).addClass("selected");
            $("#edb_w1").val($(".optgal").index(this));
        });
        adb=$(".optgal")[<?= $a->edb_w1 ?>]
        $(adb).addClass("selected");
        </script>
        <?php
    }

    /**
     * video facebook
     */
    function p26($id,$help="") {
        $real = $this->_getCTL($id);
        $a = json_decode(urldecode($real));
        $marca = mktime() . "form";
        ?>
        <div id="edbox_bodyw1">
            <div id="edbox_content">
                <form id="<?= $marca ?>" method="post" action="#">
                    <div id="labeltabs">
                        <div>Widget</div>
                        <div>General</div><?=($help!=""?'<a target="_blank" href="'.$this->getURL(LANG."support/tutorials#".$help).'">Help</a>':'')?>
                    </div>
                    <div id="contenttabs">
                        <div class="ctab">
                            <div class="edbox_fila">
                                <label><?=__("Video URL")?>:</label>
                                <input alt="<?=__("Video URL")?>" class="edb_campo required edb_text pahtml" id="edb_w1" value="<?= $a->edb_w1 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Image cover")?>:</label>
                                <input alt="<?=__("Image Cover")?>" class="edb_campo edb_text edb_pafilem pahtml" id="edb_w3" value="<?= $a->edb_w3 ?>"/>
                                <a id="btn_fm1" href="#edb_w3" title="Attach a picture from your computer" class="edb_icopafile"></a>
                            </div>
                        </div>
                        <?= $this->_extras($a) ?>
                    </div>
                    <div class="edbox_fila">
                        <input type="submit" id="edb_submit" value="<?=__("btnsave")?>"/>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
        fmanager("#btn_fm1","jpg,png,gif");
        saveProperty('<?= $marca ?>','<?= $id ?>');
        </script>
        <?php
    }

    /**
     * iframe w
     */
    function p27($id,$help="") {
        $real = $this->_getCTL($id);
        $a = json_decode(urldecode($real));
        $marca = mktime() . "form";
        ?>
        <div id="edbox_bodyw1">
            <div id="edbox_content">
                <form id="<?= $marca ?>" method="post" action="#">
                    <div id="labeltabs">
                        <div>Widget</div>
                        <div>General</div><?=($help!=""?'<a target="_blank" href="'.$this->getURL(LANG."support/tutorials#".$help).'">Help</a>':'')?>
                    </div>
                    <div id="contenttabs">
                        <div class="ctab">
                            <div class="edbox_fila edbox_fila2">
                                <label><?=__("Source")?>:</label>
                                <input alt="<?=__("Source")?>" class="edb_campo required edb_text pahtml" id="edb_w1" value="<?= $a->edb_w1 ?>"/>
                            </div>
                        </div>
                        <?= $this->_extras($a) ?>
                    </div>
                    <div class="edbox_fila">
                        <input type="submit" id="edb_submit" value="<?=__("btnsave")?>"/>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
                                                                        
        fmanager("#btn_fm1","jpg,png,gif");
        saveProperty('<?= $marca ?>','<?= $id ?>');
        </script>
        <?php
    }

    /**
     * shapes
     */
    function p29($id,$help="") {
        $real = $this->_getCTL($id);
        $a = json_decode(urldecode($real));
        $marca = mktime() . "form";
        ?>
        <div id="edbox_bodyw1" class="edbox_ckeditor">
            <div id="edbox_content">
                <form id="<?= $marca ?>" method="post" action="#">
                    <div id="labeltabs">
                        <div>Widget</div>
                        <div>General</div><?=($help!=""?'<a target="_blank" href="'.$this->getURL(LANG."support/tutorials#".$help).'">Help</a>':'')?>
                    </div>
                    <div id="contenttabs">
                        <div class="ctab">
                            <div class="edbox_fila">
                                <label><?=__("Style")?>:</label>
                                <div class="fshapeitem" id="ishape1"><div></div></div>
                                <div class="fshapeitem" id="ishape2"><div></div></div>
                                <div class="fshapeitem" id="ishape3"><div></div></div>
                                <div class="fshapeitem" id="ishape4"><div></div></div>
                                <div class="fshapeitem" id="ishape5"><div></div></div>
                                <div class="fshapeitem" id="ishape6"><div></div></div>
                                <div class="fshapeitem" id="ishape7"><div></div></div>
                                <div class="fshapeitem" id="ishape8"><div></div></div>
                                <input alt="<?=__("Style")?>" type="hidden" class="edb_campo required edb_text" id="edb_w1" value="<?= $a->edb_w1 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("lblbackcolor")?>:</label>
                                <input alt="<?=__("lblbackcolor")?>" class="edb_campo required edb_text pasetcolor" id="edb_w2" value="<?= $a->edb_w2 ?>"/>
                            </div>
                            
                        </div>
                        <?= $this->_extras($a) ?>
                    </div>
                    <div class="edbox_fila">
                        <input type="submit" id="edb_submit" value="<?=__("btnsave")?>"/>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
        
        $(".fshapeitem").click(function(){
            $(".fshapeitem.selected").removeClass("selected");
            $(this).addClass("selected");
            $("#edb_w1").val($(".fshapeitem").index(this));
        });
        adb=$(".fshapeitem")[<?= $a->edb_w1 ?>]
        $(adb).click();
        saveProperty('<?= $marca ?>','<?= $id ?>');
        </script>
        <?php
    }

    /**
     * contact form
     */
    function p30($id,$help="") {
        $real = $this->_getCTL($id);
        $a = json_decode(urldecode($real));
        $marca = mktime() . "form";
        ?>
        <div id="edbox_bodyw1">
            <div id="edbox_content">
                <form id="<?= $marca ?>" method="post" action="#">
                    <div id="labeltabs">
                        <div>Widget</div>
                        <div>General</div><?=($help!=""?'<a target="_blank" href="'.$this->getURL(LANG."support/tutorials#".$help).'">Help</a>':'')?>
                    </div>
                    <div id="contenttabs">
                        <div class="ctab">
                            <div class="edbox_fila ">
                                <label><?=__("E-mail to send")?>:</label>
                                <input alt="<?=__("E-mail to send")?>" class="edb_campo required edb_text email" id="edb_w1" value="<?= $a->edb_w1 ?>"/>
                            </div>
                            <div class="edbox_fila ">
                                <label><?=__("E-mail to receive")?>:</label>
                                <input alt="<?=__("E-mail to receive")?>" class="edb_campo required edb_text email" id="edb_w2" value="<?= $a->edb_w2 ?>"/>
                            </div>
                            <div class="edbox_fila ">
                                <label><?=__("Text before form")?>:</label>
                                <input alt="<?=__("Text before form")?>" class="edb_campo edb_text" id="edb_w3" value="<?= $a->edb_w3 ?>"/>
                            </div>
                            <div class="edbox_fila edbox_fila2">
                                <label><?=__("Show Name")?>:</label>
                                <select id="edb_w4" class="edb_campo required edb_text"><?= $this->_displayOptions(array("1" => "Yes", "0" => "No"), $a->edb_w4) ?></select>
                            </div>
                            <div class="edbox_fila edbox_fila4">
                                <label><?=__("Show E-mail")?>:</label>
                                <select id="edb_w5" class="edb_campo required edb_text"><?= $this->_displayOptions(array("1" => "Yes", "0" => "No"), $a->edb_w5) ?></select>
                            </div>
                            <div class="edbox_fila edbox_fila2">
                                <label><?=__("Show Phone")?>:</label>
                                <select id="edb_w10" class="edb_campo required edb_text"><?= $this->_displayOptions(array("1" => "Yes", "0" => "No"), $a->edb_w10) ?></select>
                            </div>
                            <div class="edbox_fila edbox_fila4">
                                <label><?=__("Show Address")?>:</label>
                                <select id="edb_w6" class="edb_campo required edb_text"><?= $this->_displayOptions(array("1" => "Yes", "0" => "No"), $a->edb_w6) ?></select>
                            </div>
                            <div class="edbox_fila edbox_fila2">
                                <label><?=__("Show Country")?>:</label>
                                <select id="edb_w7" class="edb_campo required edb_text"><?= $this->_displayOptions(array("1" => "Yes", "0" => "No"), $a->edb_w7) ?></select>
                            </div>
                            <div class="edbox_fila edbox_fila4">
                                <label><?=__("Show City")?>:</label>
                                <select id="edb_w8" class="edb_campo required edb_text"><?= $this->_displayOptions(array("1" => "Yes", "0" => "No"), $a->edb_w8) ?></select>
                            </div>
                            <div class="edbox_fila edbox_fila2">
                                <label><?=__("Show Comments")?>:</label>
                                <select id="edb_w9" class="edb_campo required edb_text"><?= $this->_displayOptions(array("1" => "Yes", "0" => "No"), $a->edb_w9) ?></select>
                            </div>
                            <div class="edbox_fila ">
                                <label><?=__("lblbackcolor")?>:</label>
                                <input alt="<?=__("lblbackcolor")?>" class="edb_campo edb_text pasetcolor required" id="edb_w10" value="<?= $a->edb_w10 ?>"/>
                            </div>
                        </div>
                        <?= $this->_extras($a) ?>
                    </div>
                    <div class="edbox_fila">
                        <input type="submit" id="edb_submit" value="<?= __("btnsave") ?>"/>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
        saveProperty('<?= $marca ?>','<?= $id ?>');
        </script>
        <?php
    }

    /**
     * skype
     */
    function p32($id,$help="") {
        $real = $this->_getCTL($id);
        $a = json_decode(urldecode($real));
        $marca = mktime() . "form";
        ?>
        <div id="edbox_bodyw1">
            <div id="edbox_content">
                <form id="<?= $marca ?>" method="post" action="#">
                    <div id="labeltabs">
                        <div>Widget</div>
                        <div>General</div><?=($help!=""?'<a target="_blank" href="'.$this->getURL(LANG."support/tutorials#".$help).'">Help</a>':'')?>
                    </div>
                    <div id="contenttabs">
                        <div class="ctab">
                            <div class="edbox_fila">
                                <label><?=__("Skype username")?>:</label>
                                <input alt="<?=__("lblbackcolor")?>" class="edb_campo required edb_text" id="edb_w1" value="<?= $a->edb_w1 ?>"/>
                            </div>
                            <div class="edbox_fila " style="display:none">
                                <label><?=__("Skype Status")?>:</label>
                                <select id="edb_w2" class="edb_campo required edb_text">
                                    <?=
                                    $this->_displayOptions(array(
                                        1 => "Yes",
                                        0 => "No",
                                            ), $a->edb_w2)
                                    ?>
                                </select>
                            </div>
                            <div class="edbox_fila ">
                                <label><?=__("Function")?>:</label>
                                <select id="edb_w3" class="edb_campo required edb_text">
                                    <?=
                                    $this->_displayOptions(array(
                                        "call" => "Call me!",
                                        "add" => "Add me to skype",
                                            //"chatwithme"=>"Chat with me",
                                            //"viewmyprofile"=>"View my profile",
                                            //"leavemevoicemail"=>"Leave me voicemail",
                                            //"sendmeafile"=>"Send me a file",
                                            ), $a->edb_w3)
                                    ?>
                                </select>
                            </div>
                            <div class="edbox_fila ">
                                <label><?=__("Skype Photo")?>:</label>
                                <input alt="" class="edb_campo edb_text edb_pafilem pahtml" id="edb_w4" value="<?= $a->edb_w4 ?>"/>
                                <a href="#edb_w4" id="btn_fm1" title="Attach a picture from your computer" class="edb_icopafile"></a>                                
                            </div>
                            
                        </div>
                        <?= $this->_extras($a) ?>
                    </div>
                    <div class="edbox_fila">
                        <input type="submit" id="edb_submit" value="<?=__("btnsave")?>"/>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
            fmanager("#btn_fm1","jpg,png,gif");
            saveProperty('<?= $marca ?>','<?= $id ?>');
        </script>
        <?php
    }

    /**
     * yelp
     */
    function p33($id,$help="") {
        $real = $this->_getCTL($id);
        $a = json_decode(urldecode($real));
        $marca = mktime() . "form";
        ?>
        <div id="edbox_bodyw1">
            <div id="edbox_content">
                <form id="<?= $marca ?>" method="post" action="#">
                    <div id="labeltabs">
                        <div>Widget</div>
                        <div>General</div><?=($help!=""?'<a target="_blank" href="'.$this->getURL(LANG."support/tutorials#".$help).'">Help</a>':'')?>
                    </div>
                    <div id="contenttabs">
                        <div class="ctab">
                            <div class="edbox_fila">
                                <label><?=__("Business URL")?>:<em>http://www.yelp.com/biz/my_business</em></label>
                                <input alt="<?=__("Business URL")?>" class="edb_campo required edb_text pahtml" id="edb_w1" value="<?= $a->edb_w1 ?>"/>
                            </div>
                        </div>
                        <?= $this->_extras($a) ?>
                    </div>
                    <div class="edbox_fila">
                        <input type="submit" id="edb_submit" value="<?=__("btnsave")?>"/>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
        saveProperty('<?= $marca ?>','<?= $id ?>');
        </script>
        <?php
    }

    /**
     * scribd
     */
    function p34($id,$help="") {
        $real = $this->_getCTL($id);
        $a = json_decode(urldecode($real));
        $marca = mktime() . "form";
        ?>
        <div id="edbox_bodyw1">
            <div id="edbox_content">
                <form id="<?= $marca ?>" method="post" action="#">
                    <div id="labeltabs">
                        <div>Widget</div>
                        <div>General</div><?=($help!=""?'<a target="_blank" href="'.$this->getURL(LANG."support/tutorials#".$help).'">Help</a>':'')?>
                    </div>
                    <div id="contenttabs">
                        <div class="ctab">
                            <div class="edbox_fila">
                                <label><?=__("Scribd URL")?>:<em>http://www.scribd.com/doc/48465710/my_book</em></label>
                                <input alt="<?=__("Scribd URL")?>" class="edb_campo required edb_text pahtml" id="edb_w1" value="<?= $a->edb_w1 ?>"/>
                            </div>
                        </div>
                        <?= $this->_extras($a) ?>
                    </div>
                    <div class="edbox_fila">
                        <input type="submit" id="edb_submit" value="<?=__("btnsave")?>"/>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
        saveProperty('<?= $marca ?>','<?= $id ?>');
        </script>
        <?php
    }

    /**
     * lastfm
     */
    function p35($id,$help="") {
        $real = $this->_getCTL($id);
        $a = json_decode(urldecode($real));
        $marca = mktime() . "form";
        ?>
        <div id="edbox_bodyw1">
            <div id="edbox_content">
                <form id="<?= $marca ?>" method="post" action="#">
                    <div id="labeltabs">
                        <div>Widget</div>
                        <div>General</div><?=($help!=""?'<a target="_blank" href="'.$this->getURL(LANG."support/tutorials#".$help).'">Help</a>':'')?>
                    </div>
                    <div id="contenttabs">
                        <div class="ctab">
                            <div class="edbox_fila">
                                <label><?=__("Last FM Username")?>:</label>
                                <input alt="<?=__("Last FM Username")?>" class="edb_campo required edb_text" id="edb_w1" value="<?= $a->edb_w1 ?>"/>
                            </div>
                        </div>
                        <?= $this->_extras($a) ?>
                    </div>
                    <div class="edbox_fila">
                        <input type="submit" id="edb_submit" value="<?=__("btnsave")?>"/>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
        saveProperty('<?= $marca ?>','<?= $id ?>');
        </script>
        <?php
    }

    /**
     * lastfm
     */
    function p36($id,$help="") {
        $real = $this->_getCTL($id);
        $a = json_decode(urldecode($real));
        $marca = mktime() . "form";
        ?>
        <div id="edbox_bodyw1">
            <div id="edbox_content">
                <form id="<?= $marca ?>" method="post" action="#">
                    <div id="labeltabs">
                        <div>Widget</div>
                        <div>General</div><?=($help!=""?'<a target="_blank" href="'.$this->getURL(LANG."support/tutorials#".$help).'">Help</a>':'')?>
                    </div>
                    <div id="contenttabs">
                        <div class="ctab">
                            <div class="edbox_fila">
                                <label><?=__("Count")?>:</label>
                                <input alt="<?=__("Count")?>" class="edb_campo required edb_text integer" id="edb_w1" value="<?= $a->edb_w1 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Topic")?>:</label>
                                <select class="edb_campo required edb_text" id="edb_w2">
                                    <?=$this->_displayOptions(array(
                                        "all"=>"All",
                                        "business"=>"Business",
                                        "entertaiment"=>"Entertaiment",
                                        "gaming"=>"Gaming",
                                        "lifestyle"=>"Lifestyle",
                                        "offbeat"=>"Offbeat",
                                        "politics"=>"Politics",
                                        "science"=>"Science",
                                        "sports"=>"Sports",
                                        "technology"=>"Technology",
                                        "world_news"=>"World News",
                                    ), $obj->edb_w2)?>
                                </select>
                            </div>
                        </div>
                        <?= $this->_extras($a) ?>
                    </div>
                    <div class="edbox_fila">
                        <input type="submit" id="edb_submit" value="<?=__("btnsave")?>"/>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
        saveProperty('<?= $marca ?>','<?= $id ?>');
        </script>
        <?php
    }

    /**
     * dailymotion
     */
    function p37($id,$help="") {
        $real = $this->_getCTL($id);
        $a = json_decode(urldecode($real));
        $marca = mktime() . "form";
        ?>
        <div id="edbox_bodyw1">
            <div id="edbox_content">
                <form id="<?= $marca ?>" method="post" action="#">
                    <div id="labeltabs">
                        <div>Widget</div>
                        <div>General</div><?=($help!=""?'<a target="_blank" href="'.$this->getURL(LANG."support/tutorials#".$help).'">Help</a>':'')?>
                    </div>
                    <div id="contenttabs">
                        <div class="ctab">
                            <div class="edbox_fila">
                                <label><?=__("Dailymotion video URL")?>:<em>http://www.dailymotion.com/video/my_video</em></label>
                                <input alt="<?=__("Dailymotion video URL")?>" class="edb_campo required edb_text pahtml" id="edb_w1" value="<?= $a->edb_w1 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("AutoPlay")?>:</label>
                                <select class="edb_campo required edb_text" id="edb_w2">
                                    <?=$this->_displayOptions(array(
                                        "0"=>"No",
                                        "1"=>"yes",
                                    ), $obj->edb_w2)?>
                                </select>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Foreground color")?>:</label>
                                <input alt="<?=__("Foreground color")?>" class="edb_campo required edb_text pasetcolor" id="edb_w3" value="<?= $a->edb_w3 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Background color")?>:</label>
                                <input alt="<?=__("Background color")?>" class="edb_campo required edb_text pasetcolor" id="edb_w4" value="<?= $a->edb_w4 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Highlight color")?>:</label>
                                <input alt="<?=__("Highlight color")?>" class="edb_campo required edb_text pasetcolor" id="edb_w5" value="<?= $a->edb_w5 ?>"/>
                            </div>
                        </div>
                        <?= $this->_extras($a) ?>
                    </div>
                    <div class="edbox_fila">
                        <input type="submit" id="edb_submit" value="<?=__("btnsave")?>"/>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
        saveProperty('<?= $marca ?>','<?= $id ?>');
        </script>
        <?php
    }

    /**
     * meetup
     */
    function p38($id,$help="") {
        $real = $this->_getCTL($id);
        $a = json_decode(urldecode($real));
        $marca = mktime() . "form";
        ?>
        <div id="edbox_bodyw1">
            <div id="edbox_content">
                <form id="<?= $marca ?>" method="post" action="#">
                    <div id="labeltabs">
                        <div>Widget</div>
                        <div>General</div><?=($help!=""?'<a target="_blank" href="'.$this->getURL(LANG."support/tutorials#".$help).'">Help</a>':'')?>
                    </div>
                    <div id="contenttabs">
                        <div class="ctab">
                            <div class="edbox_fila">
                                <label><?=__("Group URL")?>:</label>
                                <input alt="<?=__("Group URL")?>" class="edb_campo required edb_text" id="edb_w1" value="<?= $a->edb_w1 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Color")?> 1:</label>
                                <input alt="<?=__("Color")?> 1" class="edb_campo required edb_text pasetcolor" id="edb_w2" value="<?= $a->edb_w2 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Color")?> 2:</label>
                                <input alt="<?=__("Color")?> 2" class="edb_campo required edb_text pasetcolor" id="edb_w3" value="<?= $a->edb_w3 ?>"/>
                            </div>
                        </div>
                        <?= $this->_extras($a) ?>
                    </div>
                    <div class="edbox_fila">
                        <input type="submit" id="edb_submit" value="<?=__("btnsave")?>"/>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
        saveProperty('<?= $marca ?>','<?= $id ?>');
        </script>
        <?php
    }

    /**
     * zillow
     */
    function p39($id,$help="") {
        $real = $this->_getCTL($id);
        $a = json_decode(urldecode($real));
        $marca = mktime() . "form";
        ?>
        <div id="edbox_bodyw1">
            <div id="edbox_content">
                <form id="<?= $marca ?>" method="post" action="#">
                    <div id="labeltabs">
                        <div>Widget</div>
                        <div>General</div><?=($help!=""?'<a target="_blank" href="'.$this->getURL(LANG."support/tutorials#".$help).'">Help</a>':'')?>
                    </div>
                    <div id="contenttabs">
                        <div class="ctab">
                            <div class="edbox_fila">
                                <label><?=__("Zillow Username")?>:</label>
                                <input alt="<?=__("Zillow Username")?>" class="edb_campo required edb_text" id="edb_w1" value="<?= $a->edb_w1 ?>"/>
                            </div>
                            <?php/*
                            <div class="edbox_fila">
                                <label><?=__("Display")?>:</label>
                                <select alt="Display" class="edb_campo required edb_text" id="edb_w2">
                                    <?=$this->_displayOptions(array(
                                        "0"=>"Agent Reputation",
                                        "1"=>"Map My Listings",
                                    ), $a->edb_w2)?>
                                </select>
                            </div>
                             */?>
                        </div>
                        <?= $this->_extras($a) ?>
                    </div>
                    <div class="edbox_fila">
                        <input type="submit" id="edb_submit" value="<?=__("btnsave")?>"/>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
        saveProperty('<?= $marca ?>','<?= $id ?>');
        </script>
        <?php
    }
    
    /**
     * countdown
     */
    function p40($id,$help="") {
        $real = $this->_getCTL($id);
        $a = json_decode(urldecode($real));
        $marca = mktime() . "form";
        ?>
        <div id="edbox_bodyw1">
            <div id="edbox_content">
                <form id="<?= $marca ?>" method="post" action="#">
                    <div id="labeltabs">
                        <div>Widget</div>
                        <div>General</div><?=($help!=""?'<a target="_blank" href="'.$this->getURL(LANG."support/tutorials#".$help).'">Help</a>':'')?>
                    </div>
                    <div id="contenttabs">
                        <div class="ctab">
                            <div class="edbox_fila">
                                <label><?=__("End Date")?>:</label>
                                <input alt="<?=__("End Date")?>" class="edb_campo required edb_text" id="edb_w1" value="<?= $a->edb_w1 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("End Time")?></label>
                                <select alt="<?=__("End Time")?>" class="edb_campo required edb_text" id="edb_w4" style="width:60px;">
                                    <?php
                                    for($i=0;$i<=23;$i++){
                                        echo '<option value="'.$i.'" '.($i==$a->edb_w4?"selected":"").'>'.$i.'</option>';
                                    }
                                    ?>
                                </select>
                                <div style="padding: 0px 5px; float:left;font-weight: bold;font-size: 16px;">:</div>
                                <select alt="<?=__("End Time")?>" class="edb_campo required edb_text" id="edb_w5" style="width:60px;">
                                    <?php
                                    for($i=0;$i<=59;$i++){
                                        echo '<option value="'.$i.'" '.($i==$a->edb_w5?"selected":"").'>'.$i.'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Background Color")?>:</label>
                                <input alt="<?=__("Background Color")?>" class="edb_campo required edb_text pasetcolor" id="edb_w2" value="<?= $a->edb_w2 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Color")?>:</label>
                                <input alt="<?=__("Color")?>" class="edb_campo required edb_text pasetcolor" id="edb_w3" value="<?= $a->edb_w3 ?>"/>
                            </div>
                        </div>
                        <?= $this->_extras($a) ?>
                    </div>
                    <div class="edbox_fila">
                        <input type="submit" id="edb_submit" value="<?=__("btnsave")?>"/>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
            $("#edb_w1").datepicker({
                "dateFormat":"mm/dd/yy",
                "minDate":0
            });
            saveProperty('<?= $marca ?>','<?= $id ?>');
        </script>
        <?php
    }
    
    /**
     * ebay
     */
    function p41($id,$help="") {
        $real = $this->_getCTL($id);
        $a = json_decode(urldecode($real));
        $marca = mktime() . "form";
        ?>
        <div id="edbox_bodyw1">
            <div id="edbox_content">
                <form id="<?= $marca ?>" method="post" action="#">
                    <div id="labeltabs">
                        <div>Widget</div>
                        <div>General</div><?=($help!=""?'<a target="_blank" href="'.$this->getURL(LANG."support/tutorials#".$help).'">Help</a>':'')?>
                    </div>
                    <div id="contenttabs">
                        <div class="ctab">
                            <div class="edbox_fila">
                                <label><?=__("Ebay ID")?>:</label>
                                <input alt="<?=__("Ebay ID")?>" class="edb_campo required edb_text" id="edb_w1" value="<?= $a->edb_w1 ?>"/>
                            </div>
                        </div>
                        <?= $this->_extras($a) ?>
                    </div>
                    <div class="edbox_fila">
                        <input type="submit" id="edb_submit" value="<?=__("btnsave")?>"/>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
            saveProperty('<?= $marca ?>','<?= $id ?>');
        </script>
        <?php
    }
    
    /**
     * slideshare
     */
    function p42($id,$help="") {
        $real = $this->_getCTL($id);
        $a = json_decode(urldecode($real));
        $marca = mktime() . "form";
        ?>
        <div id="edbox_bodyw1">
            <div id="edbox_content">
                <form id="<?= $marca ?>" method="post" action="#">
                    <div id="labeltabs">
                        <div>Widget</div>
                        <div>General</div><?=($help!=""?'<a target="_blank" href="'.$this->getURL(LANG."support/tutorials#".$help).'">Help</a>':'')?>
                    </div>
                    <div id="contenttabs">
                        <div class="ctab">
                            <div class="edbox_fila">
                                <label><?=__("Slideshow URL")?>:</label>
                                <input alt="<?=__("Slideshow URL")?>" class="edb_campo required edb_text" id="edb_w1" value="<?= $a->edb_w1 ?>"/>
                            </div>
                        </div>
                        <?= $this->_extras($a) ?>
                    </div>
                    <div class="edbox_fila">
                        <input type="submit" id="edb_submit" value="<?=__("btnsave")?>"/>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
            saveProperty('<?= $marca ?>','<?= $id ?>');
        </script>
        <?php
    }
    
    /**
     * linkedin apply
     */
    function p43($id,$help="") {
        $real = $this->_getCTL($id);
        $a = json_decode(urldecode($real));
        $marca = mktime() . "form";
        ?>
        <div id="edbox_bodyw1">
            <div id="edbox_content">
                <form id="<?= $marca ?>" method="post" action="#">
                    <div id="labeltabs">
                        <div>Widget</div>
                        <div>General</div><?=($help!=""?'<a target="_blank" href="'.$this->getURL(LANG."support/tutorials#".$help).'">Help</a>':'')?>
                    </div>
                    <div id="contenttabs">
                        <div class="ctab">
                            <div class="edbox_fila">
                                <label><?=__("Company's Linkedin")?>:</label>
                                <input alt="<?=__("Company's Linkedin")?>" class="edb_campo required edb_text pahtml" id="edb_w1" value="<?= $a->edb_w1 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Recipient email")?>:</label>
                                <input alt="<?=__("Recipient email")?>" class="edb_campo required edb_text" id="edb_w2" value="<?= $a->edb_w2 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Job title")?>:</label>
                                <input alt="<?=__("Job title")?>" class="edb_campo required edb_text" id="edb_w3" value="<?= $a->edb_w3 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Job location")?>:</label>
                                <input alt="<?=__("Job location")?>" class="edb_campo required edb_text" id="edb_w4" value="<?= $a->edb_w4 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Company logo")?>:</label>
                                <input alt="<?=__("Company logo")?>" class="edb_campo required edb_text edb_pafilem pahtml" id="edb_w5" value="<?= $a->edb_w5 ?>"/>
                                <a href="#edb_w5" id="btn_fm1" title="Attach a picture from your computer" class="edb_icopafile"></a>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Theme color")?>:</label>
                                <input alt="<?=__("Theme color")?>" class="edb_campo required edb_text pasetcolor" id="edb_w6" value="<?= $a->edb_w6 ?>"/>
                            </div>
                        </div>
                        <?= $this->_extras($a) ?>
                    </div>
                    <div class="edbox_fila">
                        <input type="submit" id="edb_submit" value="<?=__("btnsave")?>"/>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
            fmanager("#btn_fm1","jpg,gif,png");
            saveProperty('<?= $marca ?>','<?= $id ?>');
        </script>
        <?php
    }
    
    /**
     * linkedin user profile
     */
    function p44($id,$help="") {
        $real = $this->_getCTL($id);
        $a = json_decode(urldecode($real));
        $marca = mktime() . "form";
        ?>
        <div id="edbox_bodyw1">
            <div id="edbox_content">
                <form id="<?= $marca ?>" method="post" action="#">
                    <div id="labeltabs">
                        <div>Widget</div>
                        <div>General</div><?=($help!=""?'<a target="_blank" href="'.$this->getURL(LANG."support/tutorials#".$help).'">Help</a>':'')?>
                    </div>
                    <div id="contenttabs">
                        <div class="ctab">
                            <div class="edbox_fila">
                                <label><?=__("Linkedin User's profile")?>:</label>
                                <input alt="<?=__("Linkedin User's profile")?>" class="edb_campo required edb_text pahtml" id="edb_w1" value="<?= $a->edb_w1 ?>"/>
                            </div>
                        </div>
                        <?= $this->_extras($a) ?>
                    </div>
                    <div class="edbox_fila">
                        <input type="submit" id="edb_submit" value="<?=__("btnsave")?>"/>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
            fmanager("#btn_fm1","jpg,gif,png");
            saveProperty('<?= $marca ?>','<?= $id ?>');
        </script>
        <?php
    }
    
    /**
     * linkedin company profile
     */
    function p45($id,$help="") {
        $real = $this->_getCTL($id);
        $a = json_decode(urldecode($real));
        $marca = mktime() . "form";
        ?>
        <div id="edbox_bodyw1">
            <div id="edbox_content">
                <form id="<?= $marca ?>" method="post" action="#">
                    <div id="labeltabs">
                        <div>Widget</div>
                        <div>General</div><?=($help!=""?'<a target="_blank" href="'.$this->getURL(LANG."support/tutorials#".$help).'">Help</a>':'')?>
                    </div>
                    <div id="contenttabs">
                        <div class="ctab">
                            <div class="edbox_fila">
                                <label><?=__("Linkedin Company's profile")?>:</label>
                                <input alt="<?=__("Linkedin Company's profile")?>" class="edb_campo required edb_text pahtml" id="edb_w1" value="<?= $a->edb_w1 ?>"/>
                            </div>
                        </div>
                        <?= $this->_extras($a) ?>
                    </div>
                    <div class="edbox_fila">
                        <input type="submit" id="edb_submit" value="<?=__("btnsave")?>"/>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
            saveProperty('<?= $marca ?>','<?= $id ?>');
        </script>
        <?php
    }
    
    /**
     * product
     */
    function p46($id,$help="") {
        $real = $this->_getCTL($id);
        $a = json_decode(urldecode($real));
        $marca = mktime() . "form";
        ?>
        <div id="edbox_bodyw1">
            <div id="edbox_content">
                <form id="<?= $marca ?>" method="post" action="#">
                    <div id="labeltabs">
                        <div>Widget</div>
                        <div>General</div><?=($help!=""?'<a target="_blank" href="'.$this->getURL(LANG."support/tutorials#".$help).'">Help</a>':'')?>
                    </div>
                    <div id="contenttabs">
                        <div class="ctab">
                            <div class="edbox_fila">
                                <label><?=__("Product Name")?>:</label>
                                <input alt="<?=__("Product Name")?>" class="edb_campo required edb_text" id="edb_w1" value="<?= $a->edb_w1 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Product Image")?>:</label>
                                <input alt="<?=__("Product Image")?>" class="edb_campo required edb_text pahtml edb_pafilem" id="edb_w2" value="<?= $a->edb_w2 ?>"/>
                                <a href="#edb_w2" id="btn_fm1" title="Attach a picture from your computer" class="edb_icopafile"></a>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Price")?>:</label>
                                <input alt="<?=__("Price")?>" class="edb_campo required edb_text" id="edb_w3" value="<?= $a->edb_w3 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Product URL")?>:</label>
                                <input alt="<?=__("Product URL")?>" class="edb_campo required edb_text pahtml" id="edb_w4" value="<?= $a->edb_w4 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Title color")?>:</label>
                                <input alt="<?=__("Title color")?>" class="edb_campo required edb_text pasetcolor" id="edb_w5" value="<?= $a->edb_w5 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Price color")?>:</label>
                                <input alt="<?=__("Price color")?>" class="edb_campo required edb_text pasetcolor" id="edb_w7" value="<?= $a->edb_w7 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Background button")?>:</label>
                                <input alt="<?=__("Background button")?>" class="edb_campo required edb_text pasetcolor" id="edb_w8" value="<?= $a->edb_w8 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Button's Font color")?>:</label>
                                <input alt="<?=__("Button's Font color")?>" class="edb_campo required edb_text pasetcolor" id="edb_w6" value="<?= $a->edb_w6 ?>"/>
                            </div>
                        </div>
                        <?= $this->_extras($a) ?>
                    </div>
                    <div class="edbox_fila">
                        <input type="submit" id="edb_submit" value="<?=__("btnsave")?>"/>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
            fmanager("#btn_fm1","jpg,gif,png");
            saveProperty('<?= $marca ?>','<?= $id ?>');
        </script>
        <?php
    }

    /**
     * mail chimp
     */
    function p47($id,$help=""){
        $real = $this->_getCTL($id);
        $a = json_decode(urldecode($real));
        $marca = mktime() . "form";
        ?>
        <div id="edbox_bodyw1">
            <div id="edbox_content">
                <form id="<?= $marca ?>" method="post" action="#">
                    <div id="labeltabs">
                        <div>Widget</div>
                        <div>General</div><?=($help!=""?'<a target="_blank" href="'.$this->getURL(LANG."support/tutorials#".$help).'">Help</a>':'')?>
                    </div>
                    <div id="contenttabs">
                        <div class="ctab">
                            <div class="edbox_fila">
                                <label><?=__("Title")?>:</label>
                                <input alt="<?=__("Title")?>" class="edb_campo required edb_text" id="edb_w1" value="<?= $a->edb_w1 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Subscription text")?>:</label>
                                <input alt="<?=__("Subscription text")?>" class="edb_campo required edb_text" id="edb_w2" value="<?= $a->edb_w2 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("List ID")?>:</label>
                                <input alt="<?=__("Campain ID")?>" class="edb_campo required edb_text" id="edb_w3" value="<?= $a->edb_w3 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("API ID")?>:</label>
                                <input alt="<?=__("API ID")?>" class="edb_campo required edb_text" id="edb_w4" value="<?= $a->edb_w4 ?>"/>
                            </div>
                        </div>
                        <?= $this->_extras($a) ?>
                    </div>
                    <div class="edbox_fila">
                        <input type="submit" id="edb_submit" value="<?=__("btnsave")?>"/>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
            saveProperty('<?= $marca ?>','<?= $id ?>');
        </script>
        <?php
    }

    /**
     * grupon, solo para USA
     */
    function p48($id,$help=""){
        $real = $this->_getCTL($id);
        $a = json_decode(urldecode($real));
        $marca = mktime() . "form";
        ?>
        <div id="edbox_bodyw1">
            <div id="edbox_content">
                <form id="<?= $marca ?>" method="post" action="#">
                    <div id="labeltabs">
                        <div>Widget</div>
                        <div>General</div><?=($help!=""?'<a target="_blank" href="'.$this->getURL(LANG."support/tutorials#".$help).'">Help</a>':'')?>
                    </div>
                    <div id="contenttabs">
                        <div class="ctab">
                            <div class="edbox_fila">
                                <label><?=__("Grupon URL")?>:</label>
                                <input alt="<?=__("Grupon URL")?>" class="edb_campo required edb_text pahtml" id="edb_w1" value="<?= $a->edb_w1 ?>"/>
                            </div>
                        </div>
                        <?= $this->_extras($a) ?>
                    </div>
                    <div class="edbox_fila">
                        <input type="submit" id="edb_submit" value="<?=__("btnsave")?>"/>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
            saveProperty('<?= $marca ?>','<?= $id ?>');
        </script>
        <?php
    }

    /**
     * contest concurso competition
     */
    function p49($id,$help=""){
        $real = $this->_getCTL($id);
        $a = json_decode(urldecode($real));
        $marca = mktime() . "form";
        ?>
        <div id="edbox_bodyw1">
            <div id="edbox_content">
                <form id="<?= $marca ?>" method="post" action="#">
                    <div id="labeltabs">
                        <div>Widget</div>
                        <div>General</div><?=($help!=""?'<a target="_blank" href="'.$this->getURL(LANG."support/tutorials#".$help).'">Help</a>':'')?>
                    </div>
                    <div id="contenttabs">
                        <div class="ctab">
                            <div class="edbox_fila">
                                <label><?=__("Competition name")?>:</label>
                                <input alt="<?=__("Competition name")?>" class="edb_campo required edb_text" id="edb_w1" value="<?= $a->edb_w1 ?>"/>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Competition type")?>:</label>
                                <select alt="<?=__("Competition type")?>" class="edb_campo required edb_text" id="edb_w2">
                                    <?=$this->_displayOptions(array(
                                        "Image"=>"Image",
                                        "Video"=>"Video",
                                    ), $obj->edb_w2)?>
                                </select>
                            </div>
                            <div class="edbox_fila">
                                <label><?=__("Competition status")?>:</label>
                                <select alt="<?=__("Competition status")?>" class="edb_campo required edb_text" id="edb_w3">
                                    <?=$this->_displayOptions(array(
                                        "1"=>"Active",
                                        "0"=>"Inactive",
                                    ), $obj->edb_w3)?>
                                </select>
                            </div>
                        </div>
                        <?= $this->_extras($a) ?>
                    </div>
                    <div class="edbox_fila">
                        <input type="submit" id="edb_submit" value="<?=__("btnsave")?>"/>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
            saveProperty('<?= $marca ?>','<?= $id ?>');
        </script>
        <?php
    }
    
    function settings($id) {
        $db = $this->dbInstance();
        $sql = "select settings from #_tab where uid='" . $_SESSION["fbconexion"]["id"] . "' and id=" . intval($id);
        if ($db->loadObjectList($sql) > 0) {
            $settings = $db->loadResult($sql);
            $a = json_decode(urldecode($settings));
            $marca = mktime();
            ?>
            <div id="edbox_bodyw1">
                <div id="edbox_content">
                    <form id="<?= $marca ?>" method="post" action="#">
                        <canvas class="edbox_fila edbox_fila3 nopaie" id="edb_w1d" width="130" height="140">

                        </canvas>
                        <div style="float:left;">
                        <div class="edbox_fila edbox_fila2 noie8">
                            <label><?=__("lblbackcolor")?> 1:</label>
                            <input alt="" class="edb_campo edb_text pasetcolor" id="edb_w1a" value="<?= $a->edb_w1a ?>"/>
                        </div>
                        <div class="edbox_fila edbox_fila2 nopaie">
                            <label><?=__("lblbackcolor")?> 2:</label>
                            <input alt="" class="edb_campo edb_text pasetcolor" id="edb_w1b" value="<?= $a->edb_w1b ?>"/>
                        </div>
                        <div class="edbox_fila edbox_fila2 nopaie">
                            <label><?=__("lblgradient")?>:</label>
                            <select alt="" class="edb_campo edb_text" id="edb_w1c">
                                <option value="Lineal" <?= ($a->edb_w1c == 'Lineal' ? 'selected' : '') ?>>Lineal</option>                             
                                <option value="Radial" <?= ($a->edb_w1c == 'Radial' ? 'selected' : '') ?>>Radial</option>                             
                                <!--<option value="Rectangle" <?= ($a->edb_w1c == 'Rectangle' ? 'selected' : '') ?>>Rectangle</option>                             
                                <option value="Cone" <?= ($a->edb_w1c == 'Cone' ? 'selected' : '') ?>>Cone</option>                             
                                <option value="Contour" <?= ($a->edb_w1c == 'Contour' ? 'selected' : '') ?>>Contour</option>                             
                                <option value="Satin" <?= ($a->edb_w1c == 'Satin' ? 'selected' : '') ?>>Satin</option>                             
                                <option value="Starbust" <?= ($a->edb_w1c == 'Starbust' ? 'selected' : '') ?>>Starbust</option>                             
                                <option value="Folds" <?= ($a->edb_w1c == 'Folds' ? 'selected' : '') ?>>Folds</option>                             
                                <option value="Elipse" <?= ($a->edb_w1c == 'Elipse' ? 'selected' : '') ?>>Elipse</option>                             
                                <option value="Bars" <?= ($a->edb_w1c == 'Bars' ? 'selected' : '') ?>>Bars</option>                             
                                <option value="Riples" <?= ($a->edb_w1c == 'Riples' ? 'selected' : '') ?>>Riples</option>                             
                                <option value="Waves" <?= ($a->edb_w1c == 'Waves' ? 'selected' : '') ?>>Waves</option>-->
                            </select>
                        </div>
                        </div>
                            <div class="edbox_fila">
                            <label><?=__("lblbackimg")?>:</label>
                            <input alt="" class="edb_campo edb_text edb_pafilem pahtml" id="edb_w2" value="<?= $a->edb_w2 ?>"/>
                            <a href="#edb_w2" id="btn_fm2" title="Attach a picture from your computer" class="edb_icopafile"></a>
                        </div>
                        <div class="edbox_fila">
                            <label><?=__("lblbackalign")?>:</label>
                            <select alt="" class="edb_campo edb_text" id="edb_w3">
                                <option value="none" <?= ($a->edb_w3 == 'none' || !$a->edb_w3 ? 'selected' : '') ?>><?=__("txtnone")?></option>
                                <option value="left top" <?= ($a->edb_w3 == 'left top' ? 'selected' : '') ?>><?=__("txtlefttop")?></option>
                                <option value="left center" <?= ($a->edb_w3 == 'left center' ? 'selected' : '') ?>><?=__("txtleftcenter")?></option>
                                <option value="left bottom" <?= ($a->edb_w3 == 'left bottom' ? 'selected' : '') ?>><?=__("txtleftbottom")?></option>
                                <option value="right top" <?= ($a->edb_w3 == 'right top' ? 'selected' : '') ?>><?=__("txtrighttop")?></option>
                                <option value="right center" <?= ($a->edb_w3 == 'right center' ? 'selected' : '') ?>><?=__("txtrightcenter")?></option>
                                <option value="right bottom" <?= ($a->edb_w3 == 'right bottom' ? 'selected' : '') ?>><?=__("txtrightbottom")?></option>
                                <option value="center top" <?= ($a->edb_w3 == 'center top' ? 'selected' : '') ?>><?=__("txtcentertop")?></option>
                                <option value="center center" <?= ($a->edb_w3 == 'center center' ? 'selected' : '') ?>><?=__("txtcentercenter")?></option>
                                <option value="center bottom" <?= ($a->edb_w3 == 'center bottom' ? 'selected' : '') ?>><?=__("txtcenterbottom")?></option>                             
                            </select>
                        </div>
                        <div class="edbox_fila">
                            <label><?=__("lblbackrepeat")?>:</label>
                            <select alt="" class="edb_campo edb_text" id="edb_w4">
                                <option value="repeat <?= ($a->edb_w4 == 'repeat' ? 'selected' : '') ?>">repeat</option>
                                <option value="repeat-x" <?= ($a->edb_w4 == 'repeat-x' ? 'selected' : '') ?>>repeat-x</option>
                                <option value="repeat-y" <?= ($a->edb_w4 == 'repeat-y' ? 'selected' : '') ?>>repeat-y</option>
                                <option value="no-repeat" <?= ($a->edb_w4 == 'no-repeat' ? 'selected' : '') ?>>no-repeat</option>                       
                            </select>
                        </div>
                        <div class="edbox_fila">
                            <label><?=__("lblpageheight")?>:</label>
                            <input alt="" class="edb_campo edb_text" id="edb_w7" value="<?= $a->edb_w7 ?>"/>
                        </div>
                        <div class="edbox_fila">
                            <label>Google Analytics:&nbsp;<em>(ex: UA-22314845-1)</em></label>
                            <input alt="" class="edb_campo edb_text" id="edb_w5" value="<?= $a->edb_w5 ?>"/>
                        </div>
                        <div class="edbox_fila">
                            <label><?=__("Non Fans")?>:</label>
                            <input alt="" class="edb_campo edb_text edb_pafilem pahtml" id="edb_w6" value="<?= $a->edb_w6 ?>"/>
                            <a href="#edb_w6" id="btn_fm6" title="Attach a picture from your computer" class="edb_icopafile"></a>
                        </div>
                        <div class="edbox_fila">
                            <input type="submit" id="edb_submit" value="<?=__("btnsave")?>"/>
                        </div>
                    </form>
                </div>
            </div>
            <script type="text/javascript">
            fmanager("#btn_fm2","jpg,png,gif");
            fmanager("#btn_fm6","jpg,png,gif");
            if($.browser.msie)
                $(".nopaie").hide();
            if(parseInt($.browser.version)<=8 && $.browser.msie)
                $(".noie8").hide();
            cambiar_color=function(){
                if($("#edb_w1a").val()!=""){
                    $("#edb_w1d").gradient({
                        type:$("#edb_w1c").val().toLowerCase(),
                        width:130,
                        height:140,
                        colors:($("#edb_w1b").val()==""?[
                            $("#edb_w1a").val()
                        ]:[
                            $("#edb_w1a").val(),
                            $("#edb_w1b").val()
                        ])
                    })
                }
                else{
                    $("#edb_w1a").val("#ffffff");
                }
            }
            cambiar_color();
            $("#edb_w1c").change(cambiar_color);
            $('.pasetcolor').ColorPicker({
                onSubmit: function(hsb, hex, rgb, el) {
                    $(el).val("#"+hex);
                    $(el).ColorPickerHide();
                    cambiar_color();
                },
                onBeforeShow: function () {
                    $(this).ColorPickerSetColor(this.value);
                }
            })/*.focus(function(){
                    $(this).ColorPickerShow();
                });*/
            $(".pahtml").change(function(){
                ph=$(this).val().split("http://").join("");
                $(this).val(ph);
            })
            $(".pahtml").change();
            $("#<?= $marca ?>").formValidator({
                eol:"\n",
                onValidated:function(msg){
                    if(msg)
                        alert(msg)
                    else{
                        cad="";
                        $(".edb_campo").each(function(){
                            if($(this).hasClass("pahtml") && $(this).val()!="")
                                $(this).val("http://"+$(this).val());
                            cad+="&"+$(this).attr("id")+"="+encodeURIComponent($(this).val())
                        });
                        miurl="/fbsetform/fbsetsettings/<?= $id ?>";
                        $.ajax({
                            url:miurl,
                            data:"token=0"+cad,
                            type:"POST",
                            success:function(data){
                                //alert(data);
                                $("#dialogo").dialog("close");
                                window.location.reload();
                            }
                        });
                        return false;
                    }
                }
            });
                                                                                                                                                                                                                                                                            
            </script>
            <?php
        }
    }

    function clonar($id) {
        $db = $this->dbInstance();
        $sql = "select #_tab.*,#_aplicacion.nombre as nombreapp from #_tab inner join #_aplicacion on #_tab.idapp=#_aplicacion.id where #_tab.uid='" . $_SESSION["fbconexion"]["uid"] . "' order by idpagina asc";
        $tabs = $db->loadObjectList($sql);
        $tb = array();
        foreach ($tabs as $t) {
            $tb[] = $t->idpagina;
        }
        $fql = "select page_id,name from page where page_id in (" . implode(",", $tb) . ")";
        $pags = $this->fb->fqlQuery($fql);
        $marca = "frm" . mktime();
        ?>
        <div id="edbox_bodyw1">
            <div id="edbox_content">
                <form id="<?= $marca ?>" method="post" action="#">
                    <div class="edbox_fila">
                        <label><?=__("Select page")?>:</label>
                        <span>
                            <select alt="<?=__("Select Page")?>" class="edb_campo required edb_text" id="edb_w1">
                                <?php
                                if (count($pags))
                                    foreach ($pags as $p) {
                                        echo '<option value="' . $p["page_id"] . '">' . $p["name"] . '</option>' . "\n";
                                    }
                                ?>
                            </select>
                        </span>
                    </div>
                    <div class="edbox_fila">
                        <label><?=__("Select Tab")?></label>
                        <span>
                            <select alt="<?=__("Select Tab")?>" class="edb_campo required edb_text" id="edb_w2">

                            </select>
                        </span>
                    </div>
                    <div class="edbox_fila">
                        <input type="submit" id="edb_submit" value="<?=__("btnsave")?>"/>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
        info=<?= json_encode($tabs) ?>;
        $("#edb_w1").change(function(){
            todo=this;
            selectado='<select alt="<?=__("Select Tab")?>" class="edb_campo required edb_text" id="edb_w2">';
            for(i=0;i<info.length;i++){
                //alert(info[i]["idpagina"]+" - "+$(todo).val()+ " = "+(info[i]["idpagina"]==$(todo).val()));
                if(info[i]["idpagina"]==$(todo).val() && info[i]["id"]!="<?= $id ?>"){
                    selectado+='<option value="'+info[i]["id"]+'">'+info[i]["nombreapp"]+'</option>';
                }
            }
            selectado+='</select>';
            $("#edb_w2").parent().html(selectado);
        });
        $(".pahtml").change(function(){
            ph=$(this).val().split("http://").join("");
            $(this).val(ph);
        })
        $(".pahtml").change();
        $("#<?= $marca ?>").formValidator({
            eol:"\n",
            onValidated:function(msg){
                if(msg)
                    alert(msg)
                else{
                    cad="";
                    $(".edb_campo").each(function(){
                        if($(this).hasClass("pahtml") && $(this).val()!="")
                            $(this).val("http://"+$(this).val());
                        cad+="&"+$(this).attr("id")+"="+encodeURIComponent($(this).val())
                    });
                    miurl="/fbsetform/fbsetclone/<?= $id ?>";
                    $.ajax({
                        url:miurl,
                        data:"token=0"+cad,
                        type:"POST",
                        success:function(data){
                            $("#dialogo").dialog("close");
                            window.location.href=data;
                        }
                    });
                    return false;
                }
            }
        });
        </script>
        <?php
    }

}
?>
