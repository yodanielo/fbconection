<div id="cuadroquery">
    <form action="<?= $this->getURL(LANG."support/faqs") ?>" method="get" id="frmsearchfaq">
        <label><?=__("txtfindanyquestion")?></label>
        <input type="text" id="txtqueryfaq" name="query" value="<?= $_GET["query"] ?>" />
        <input type="submit" id="subquery" value="" />
    </form>
</div>
<img src="<?= $this->getURL("images/img_support.jpg") ?>" />