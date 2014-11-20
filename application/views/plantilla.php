<div id="bgtemplates" >
    <ul>
        <?php
        foreach ($params["cats"] as $c) {
            echo '<li><a href="#cattpl' . $c->id . '">' . $c->ncat . '</a></li>';
        }
        ?>
    </ul>
</div>
<div id="conttemplates" class="flexcroll">
    <?php
    if (count($params["datos"]) > 0) {
        $anterior = 0;
        foreach ($params["datos"] as $k => $r) {
            if ($k == 0 || $anterior != $r->idcat) {
                echo '<div class="contplantillas" id="cattpl' . $r->idcat . '">';
            }
            $anterior = $r->idcat;
            ?>
            <div class="tplminiatura" id="tpl<?= $r->id ?>">
                <img src="<?= $this->getURL("images/templates/" . $r->imgpreview) ?>" alt=""/>
            </div>
            <?php
            if ($k == count($params["datos"]) - 1 || $anterior != $params["datos"][$k + 1]->idcat) {
                echo '</div><!--fin de bloque-->';
            }
        }
    }
    /* foreach($params["datos"] as $r){
      ?>
      <div class="tplminiatura" id="tpl<?=$r->id?>">
      <img src="<?=$this->getURL("images/templates/".$r->imgpreview)?>" alt=""/>
      </div>
      <?php
      } */
    ?>
    <div style="clear:both;position:relative; height:1px;">&nbsp;</div>
</div>
<script type="text/javascript">
    $("#bgtemplates li").click(function(){
        $("#conttemplates .contplantillas").hide();
        ct=$(this).find("a").attr("href");
        $("#conttemplates "+ct).show();
        $("#bgtemplates li.active").removeClass("active");
        $(this).addClass("active");
        return false;
    })
    updscrolltpl=function(){
        fleXenv.updateScrollBars();
        setTimeout(updscrolltpl, 200);
    }
    window.location.href="javascript:fleXenv.fleXcrollMain('conttemplates')";
    updscrolltpl();
    $("#bgtemplates li:first").click();
    $(".tplminiatura").click(function(){
        $.ajax({
            url:"<?= $this->getURL("/fbconexion/applyTemplate/") ?>"+id+"/"+$(this).attr("id").split("tpl").join(""),
            success:function(data){
                //alert(data);
                window.location.reload();
            }
        });
        return false;
    })
</script>