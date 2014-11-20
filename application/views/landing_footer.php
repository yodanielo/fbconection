    </div><!--fin de wrapper-->
    <script type="text/javascript">
        window.fbAsyncInit = function() {
            FB.init({
                appId: '225578674172065',
                status: true, 
                cookie: true,
                xfbml: true,
                //channelUrl  : 'http://www.fbconexion.com/channel.html',
                oauth : true
            });
            function updateButton(response) {
                $(".btnloginfb").click(function(){
                    //if (response.status == 'connected')
                    FB.logout(function(response){});
                    FB.login(function(response) {
                        if (response.status === 'connected') {
                            $.ajax({
                                url:"<?=$this->getURL("doSession")?>",
                                success:function(data){
                                    if(data.indexOf("ok")>-1){
                                        window.location.href="<?=$this->getURL(LANG."fbconexion")?>";
                                    }
                                }
                            })
                        }
                    },{
                            "scope":"manage_pages,user_likes,offline_access,publish_stream,email"
                        });
                    return false;
                })
            }

            // run it once with the current status and also whenever the status changes
            FB.getLoginStatus(updateButton);
            //FB.Event.subscribe('auth.statusChange', updateButton);
        };
        (function() {
            var e = document.createElement('script'); 
            e.async = true;
            e.src = document.location.protocol +
                '//connect.facebook.net/en_US/all.js';
            document.getElementById('fb-root').appendChild(e);
        }());
    </script>
</body>
</html>