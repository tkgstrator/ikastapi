<?php
require "vendor/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;
 
define("CALLBACK_URL", "ikastagram://");
 
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$connection = new TwitterOAuth($_ENV["CONSUMER_KEY"], $_ENV["CONSUMER_KEY_SECRET"]);
$request = $connection->oauth("oauth/request_token", array("oauth_callback" => CALLBACK_URL));
  
$_SESSION["oauth_token"] = $request["oauth_token"];
$_SESSION["oauth_token_secret"] = $request["oauth_token_secret"];
  
$url = $connection->url("oauth/authorize", array("oauth_token" => $request["oauth_token"]));
header("Location: ".$url);
?>