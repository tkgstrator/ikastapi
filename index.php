<?php
require "vendor/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;
 
session_start();
define("TWITTER_API_KEY", "htk6P4lNwXg1v6XUiQa0VsaJm");
define("TWITTER_API_SECRET", "TDOPciJ9WkM5SSxS2kSOfHSLdaQYyGkeH0D61OVgvq2YwFJF31");
define("CALLBACK_URL", "ikastagram://");
 
$connection = new TwitterOAuth(TWITTER_API_KEY, TWITTER_API_SECRET);
$request = $connection->oauth("oauth/request_token", array("oauth_callback" => CALLBACK_URL));
  
$_SESSION["oauth_token"] = $request["oauth_token"];
$_SESSION["oauth_token_secret"] = $request["oauth_token_secret"];
  
$url = $connection->url("oauth/authorize", array("oauth_token" => $request["oauth_token"]));
header("Location: ".$url);
exit;
?>