<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <script type="text/javascript" src="http://www.fbconexion.com/onlineco/js/jquery-1.4.4.min.js"></script> 
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
        <style type="text/css">
            *{
                padding: 0px;
                margin:0px;
                font-family: Arial;
                font-size: 12px;
                text-decoration: none;
                /*color:#000;*/
            }
            #mapa{
                float:left;
                width:100%;
                height:100%;
                position:absolute;
            }
        </style>
    </head>
    <body>
        <div id="mapa"></div>
        <script type="text/javascript">
            var geocoder;
            var map;
            function initialize() {
                geocoder = new google.maps.Geocoder();
                codeAddress();
                var latlng = new google.maps.LatLng(-34.397, 150.644);
                var myOptions = {
                    zoom: <?=$_GET["z"]?>,
                    center: latlng,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                }
                map = new google.maps.Map(document.getElementById("mapa"), myOptions);
            }

            function codeAddress() {
                var address = "<?=utf8_encode($_GET["q"])?>";
                geocoder.geocode( { 'address': address}, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        map.setCenter(results[0].geometry.location);
                        var marker = new google.maps.Marker({
                            map: map, 
                            position: results[0].geometry.location
                        });
                        //markerOptions = { icon:blueIcon };
                    } else {
                        //alert("Geocode was not successful for the following reason: " + status);
                    }
                });
            }
            initialize();

        </script>
    </body>
</html>
