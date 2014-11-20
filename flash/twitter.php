<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <title>Twitter</title>
    </head>
    <body>
        <script src="http://widgets.twimg.com/j/2/widget.js"></script>
        <script>
            new TWTR.Widget({
                version: 2,
                type: 'search',
                search: '<?=$_GET["query"]?>',
                interval: 6000,
                title: '<?=$_GET["title"]?>',
                subject: '<?=$_GET["subtitle"]?>',
                width: <?=$_GET["w"]?>,
                height: <?=$_GET["h"]?>,
                theme: {
                    shell: {
                        background: '<?=$_GET["bgcolor1"]?>',
                        color: '<?=$_GET["ltcolor"]?>'
                    },
                    tweets: {
                        background: '<?=$_GET["bgcolor2"]?>',
                        color: '<?=$_GET["ltcolor"]?>',
                        links: '<?=$_GET["lkcolor"]?>'
                    }
                },
                features: {
                    scrollbar: false,
                    loop: true,
                    live: true,
                    hashtags: true,
                    timestamp: true,
                    avatars: true,
                    toptweets: true,
                    behavior: 'default'
                }
            }).render().start();
        </script>
    </body>
</html>
