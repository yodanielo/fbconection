<div id="cuadrodirectory">
    <h1 class="titleotros">
        <?= __("Links Directory") ?>
    </h1>
    <div class="cuadrootros" id="bodydirectory">
        <?php
        if (count($params["res"]) > 0) {
            foreach ($params["res"] as $r) {
                ?>
                <a href="<?= $r->url ?>">
                    <strong><?= $r->title ?></strong><br/>
                    <span><?= $r->url ?></span>
                </a><br/><br/>
                <?php
            }
        }
        ?>
        &nbsp;
    </div>
        <?php
        if ($params["numpags"] > 1) {
            echo '<div id="dirpaginacion">';
            if ($params["pag"] > 1) {
                echo '<a id="dirfizq" href="' . $this->getURL(LANG . "linksDirectory/" . ($params["pag"]-1)) . '">' . __("Prev Page") . '</a>';
            }
            for($i=1;$i<=$params["numpags"];$i++){
                echo '<a class="'.($i==$params["pag"]?'active':'').'" href="'.$this->getURL(LANG."linksDirectory/".$i).'">'.$i.'</a>';
            }
            if ($params["pag"] < $params["numpags"]) {
                echo '<a id="dirfizq" href="' . $this->getURL(LANG . "linksDirectory/" . ($params["pag"]+1)) . '">' . __("Next Page") . '</a>';
            }
            echo '</div>';
        }
        ?>
</div>