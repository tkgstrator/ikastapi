<?php
require "vendor/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;


session_start();
$CONSUMER_KEY = "";
$CONSUMER_KEY_SECRET = "";

switch (true) {
    case ($_SERVER["HTTP_HOST"] === "localhost:8080"):
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->load();
        $CONSUMER_KEY = $_ENV["CONSUMER_KEY"];
        $CONSUMER_KEY_SECRET = $_ENV["CONSUMER_KEY_SECRET"];
        define("CALLBACK_URL", "http://localhost:8080/callback.php");
        break;
    default:
        $CONSUMER_KEY = getenv("CONSUMER_KEY");
        $CONSUMER_KEY_SECRET = getenv("CONSUMER_KEY_SECRET");
        define("CALLBACK_URL", "https://ikastagram.herokuapp.com/callback.php");
        break;
}
$connection = new TwitterOAuth($CONSUMER_KEY, $CONSUMER_KEY_SECRET);
$request = $connection->oauth("oauth/request_token", array("oauth_callback" => CALLBACK_URL));

$_SESSION["oauth_token"] = $request["oauth_token"];
$_SESSION["oauth_token_secret"] = $request["oauth_token_secret"];

$url = $connection->url("oauth/authorize", array("oauth_token" => $request["oauth_token"]));
header("Location: " . $url);
