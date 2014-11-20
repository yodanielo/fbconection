<div id="cuadromapaweb">
    <h1 class="titleotros"><?= __("titwebmap") ?></h1>
    <div class="cuadrootros" id="bodywebmap">
        <ul>
            <li><a href="<?=$this->getURL(LANG."")?>"><strong><?=__("tithome")?></strong><br/><span><?=$this->getURL(LANG."")?></span></a></li>
            <li><a href="<?=$this->getURL(LANG."plans")?>"><strong><?=__("titplans")?></strong><br/><span><?=$this->getURL(LANG."plans")?></span></a></li>
            <li><a href="<?=$this->getURL(LANG."about_us")?>"><strong><?=__("titabout")?></strong><br/><span><?=$this->getURL(LANG."about_us")?></span></a></li>
            <li><a href="<?=$this->getURL(LANG."plans")?>"><strong><?=__("titplans")?></strong><br/><span><?=$this->getURL(LANG."plans")?></span></a></li>
            <li><a href="<?=$this->getURL(LANG."support")?>"><strong><?=__("Support")?></strong><br/><span><?=$this->getURL(LANG."support")?></span></a>
                <ul>
                    <li><a href="<?=$this->getURL(LANG."support/")?>"><strong><?=__("Support")?></strong><br/><span><?=$this->getURL(LANG."support")?></span></a>
                    <li><a href="<?=$this->getURL(LANG."support/faqs")?>"><strong>FAQs</strong><br/><span><?=$this->getURL(LANG."support/faqs")?></span></a>
                    <li><a href="<?=$this->getURL(LANG."support/examples")?>"><strong><?=__("Examples")?></strong><br/><span><?=$this->getURL(LANG."support/examples")?></span></a>
                    <li><a href="<?=$this->getURL(LANG."support/tutorials")?>"><strong><?=__("tittutorials")?></strong><br/><span><?=$this->getURL(LANG."support/tutorials")?></span></a>
                </ul>
            </li>
            <li><a href="<?=$this->getURL(LANG."terms_of_service")?>"><strong><?=__("tittermsofservice")?></strong><br/><span><?=$this->getURL(LANG."terms_of_service")?></span></a></li>
            <li><a href="<?=$this->getURL(LANG."privacy_policy")?>"><strong><?=__("titprivacypolicy")?></strong><br/><span><?=$this->getURL(LANG."privacy_policy")?></span></a></li>
            <li><a href="<?=$this->getURL(LANG."partnerships")?>"><strong><?=__("titpartnerships")?></strong><br/><span><?=$this->getURL(LANG."partnerships")?></span></a></li>
            <li><a href="<?=$this->getURL(LANG.(LANG=="es/"?"contactanos":"contact_us"))?>"><strong><?=__("titcontactus")?></strong><br/><span><?=$this->getURL(LANG.(LANG=="es/"?"contactanos":"contact_us"))?></span></a></li>
        </ul>
    </div>
</div>