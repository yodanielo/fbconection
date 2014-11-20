<?php
//
// From http://non-diligent.com/articles/yelp-apiv2-php-example/
//
// Enter the path that the oauth library is in relation to the php file
include 'lib/OAuth.php';
// For example, request business with id 'the-waterboy-sacramento'
$unsigned_url = "http://api.yelp.com/v2/business/" . $_GET["business"];

// For examaple, search for 'tacos' in 'sf'
//$unsigned_url = "http://api.yelp.com/v2/search?term=tacos&location=sf";
// Set your keys here
$consumer_key = "BjXbQ4xE7t4luYqvSvcfXA";
$consumer_secret = "suSIzi7mgAviUsJ463JSELy78MU";
$token = "Ev4QUZZnJHWDNXhIjAI3v6yJbv4Uhpah";
$token_secret = "kJtpVHrOQM9FjiY5tZ_u7TNU6ys";

// Token object built using the OAuth library
$token = new OAuthToken($token, $token_secret);

// Consumer object built using the OAuth library
$consumer = new OAuthConsumer($consumer_key, $consumer_secret);

// Yelp uses HMAC SHA1 encoding
$signature_method = new OAuthSignatureMethod_HMAC_SHA1();

// Build OAuth Request using the OAuth PHP library. Uses the consumer and token object created above.
$oauthrequest = OAuthRequest::from_consumer_and_token($consumer, $token, 'GET', $unsigned_url);

// Sign the request
$oauthrequest->sign_request($signature_method, $consumer, $token);

// Get the signed URL
$signed_url = $oauthrequest->to_url();

// Send Yelp API Call
$ch = curl_init($signed_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, 0);
$data = curl_exec($ch); // Yelp response
curl_close($ch);

// Handle Yelp response data
$r = json_decode($data);
//print_r($r);
// Print it for debugging
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <script type="text/javascript" src="http://www.fbconexion.com/onlineco/js/jquery-1.4.4.min.js"></script> 
        <style type="text/css">
            *{
                padding: 0px;
                margin:0px;
                font-family: Arial;
                font-size: 12px;
                text-decoration: none;
                /*color:#000;*/
            }
            #titlereviews{
                padding: 10px 0 7px;
                font-weight: bold;
                color: #C41200;
                border-top: 1px solid #C41200;
                margin-top: 10px;
            }
            #boxreviews{

            }
            .reviewitem{
                clear:both;
                margin-bottom: 10px;
            }
            .reviewitem .avatarbox img{
                float:left;
                width:44px;
                height:44px;
                margin-right: 10px;
                margin-top: 10px;
            }
            .reviewitem .avatarbox strong{
                color: #66C;
                font-size: 14px;
                margin-top: 10px;
            }
            .reviewstars{
                clear:both;
                padding: 10px 0px;
                line-height:20px;
            }
            .reviewdetail *{
                text-align: justify;
            }
            .reviewtitle{
                padding: 5px;
                font-size: 12px;
                background-color: #FFF0D1;
                color: #555;
                border-top:1px solid #CCCCCC;
            }
            #contreviews{
                padding:5px;
            }
        </style>
    </head>
    <body>
        <?php
        if ($r->error->id == "INTERNAL_ERROR") {
            echo "The business doesn't exists.";
        } else {
            ?>
        <div id="contreviews">
                <div id="titlereviews">Reviews about: <a target="_blank" href="<?=$r->url?>"><?=$r->name?></a></div>
                <div id="boxreviews">
                    <?php
                    if (count($r->reviews) > 0) {
                        foreach ($r->reviews as $rv) {
                            ?>
                            <div class="reviewitem">
                                <div class="reviewtitle">
                                    <strong><?= $rv->user->name ?>'s Review</strong>
                                </div>
                                <div class="avatarbox">
                                    <img src="<?= $rv->user->image_url ?>"/>
                                    <strong><?= $rv->user->name ?></strong>
                                </div>
                                <div class="reviewstars">
                                    <img src="<?= $rv->rating_image_url ?>"/> <?= gmdate("m/d/y", $rv->time_created) ?>
                                </div>
                                <div class="reviewdetail">
                                    <p><?= $rv->excerpt ?></p>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        <?php } ?>
    </body>
</html>