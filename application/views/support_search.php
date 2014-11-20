<?php
$nodes = $params["des"];
$usuarios = $params["usuarios"];
?>
<div class="wrappersup">
    <div id="faqdettabs" style="margin-top: 20px;">
        <a class="btnbackfaq" href="javascript:history.back();">&lt; <?=__("txtback")?></a>
        <div id="barralooking" style="margin-top: 0px;"><?=__("txtlookingfor")?>: <?= $_GET["query"] ?></div>
        <?php
        if (count($nodes) > 0) {
            foreach ($nodes as $nd) {
                ?>
                <div class="itempregunta">
                    <a class="faqavatar" target="_blank" href="<?= ($nd->destacada==1?$this->getURL(""):$usuarios["x" . $nd->idusuario]["profile_url"]) ?>">
                        <img src="<?= ($nd->destacada==1?$this->getURL("images/img_avatar-faq.png"):$usuarios["x" . $nd->idusuario]["pic_square"]) ?>"/>
                    </a>
                    <div class="picopregunta"></div>
                    <div class="faqsetpregunta">
                        <div class="faqcuadropregunta"><?= $nd->pregunta ?></div>
                        <a class="faqgoanswers" href="<?= $this->getURL("support/faqs/" . $nd->id) ?>"><?=__("txtviewanswers")?></a>
                    </div>
                </div>
                <?php
            }
        }
        else{
            echo '<div id="nohayresults">'.__("txtnoquestionstoshow").'</div>';
        }
        ?>
    </div>
    <div id="faqcol2"><?= $this->loadView("support_sidebar.php") ?></div>
</div>