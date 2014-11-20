<?php
$settings = $this->params["settings"];
if ($settings->edb_w5 != "" && $settings->edb_w5) {
    ?>
    <script type="text/javascript">

        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', '<?=$settings->edb_w5?>']);
        _gaq.push(['_trackPageview']);

        (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();

    </script>
    <?php
}
?>
</div>
<div style="position:relative;font-size: 1px; clear:both;">&nbsp;</div>
</body>
</html>