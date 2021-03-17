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
        break;
    default:
        $CONSUMER_KEY = getenv("CONSUMER_KEY");
        $CONSUMER_KEY_SECRET = getenv("CONSUMER_KEY_SECRET");
        break;
}
$request_token = [];
$request_token['oauth_token'] = $_SESSION['oauth_token'];
$request_token['oauth_token_secret'] = $_SESSION['oauth_token_secret'];
$connection = new TwitterOAuth($CONSUMER_KEY, $CONSUMER_KEY_SECRET, $request_token['oauth_token'], $request_token['oauth_token_secret']);
$access_token = $connection->oauth("oauth/access_token", ["oauth_verifier" => $_REQUEST['oauth_verifier']]);
$url = "ikastagram://" . http_build_query($access_token);
header("Location: " . $url);
