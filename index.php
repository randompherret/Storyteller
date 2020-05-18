<?php
require_once 'logic/config.php';
require_once 'logic/functions.php';
require_once 'logic/slack.php';
$headers = getallheaders();
$request = file_get_contents("php://input");
$event = json_decode($request, TRUE);

if (isset($event['challenge'])){
    echo $event['challenge'];
if (isset($headers['X-Slack-Request-Timestamp'], $headers['X-Slack-Signature'])){
    $requestSignature = $headers['X-Slack-Signature'];
    $eventVersion = explode("=", $requestSignature)[0];
    $timestamp = $headers['X-Slack-Request-Timestamp'];
    $token = $event['token'];
    $timediff = time() - $timestamp;
    if (abs($timediff) >= 60){
        die("Message time incorrect)");
    }
    $eventHash = hash_hmac('sha256', "$eventVersion:$timestamp:$request", $config->slack_secret);
    if(!hash_equals($requestSignature, "$eventVersion=$eventHash")){
        die("No Spoofing");
    }
} else {
    die("Not slack");
}

?>