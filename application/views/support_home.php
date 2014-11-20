<div id="bannerprinsup">
    <div class="wrappersup">
        <div id="banpsup">
        <img src="<?=$this->getURL("images/banner01sup.png")?>"/>
        </div>
    </div>
</div>
<div class="wrappersup">
    <div id="banfaqs">
        <div class="titlesblocksup">FAQs</div>
        <div class="etiquetasup" style="background:url(../images/labelexamples.png) repeat-x;"><strong>FAQs</strong><br/><?=__("findandshare")?>.</div>
        <img src="<?=$this->getURL("images/bg_faq.png")?>" alt=""/>
    </div>
    <div id="banexamples">
        <div class="titlesblocksup"><?=__("titexamples")?></div>
        <div class="etiquetasup" style="background:url(../images/labelexamples.png) repeat-x;"><strong><?=__("textourtemplates")?></strong><br/><?=__("textwithourplatform")?>.</div>
        <img src="<?=$this->getURL("images/bg_templates.png")?>" alt=""/>
    </div>
    <div id="bantutorials">
        <div class="titlesblocksup"><?=__("titvideotutorials")?></div>
        <div class="etiquetasup" style="background:url(../images/labeltutorials.png) repeat-x;"><strong><?=__("textlearnquickly")?></strong><br/><?=__("texthowtobuildfanpage")?></div>
        <img src="<?=$this->getURL("images/bg_tutorials.png")?>" alt=""/>
    </div>
</div>
<script type="text/javascript">
    $("#banpsup").cycle();
    $("#banexamples").click(function(){
        window.location.href="<?=$this->getURL(LANG."support/examples")?>";
    })
    $("#bantutorials").click(function(){
        window.location.href="<?=$this->getURL(LANG."support/tutorials")?>";
    })
    $("#banfaqs").click(function(){
        window.location.href="<?=$this->getURL(LANG."support/faqs")?>";
    })
</script>