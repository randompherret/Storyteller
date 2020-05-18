<?php
require_once 'logic/config.php';
require_once 'logic/functions.php';
require_once 'logic/slack.php';
$tempFile = fopen("temp.json","w");
$headers = getallheaders();
$request = file_get_contents("php://input");
$event = json_decode($request, TRUE);

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
    if (isset($event['challenge'])){
        echo $event['challenge'];
    }
} else {
    die("Not slack");
}

fwrite($tempFile,"\n");
fwrite($tempFile,date('D, d M Y H:i:s'));
fwrite($tempFile,"\n");
fwrite($tempFile,json_encode($event, JSON_PRETTY_PRINT));
fclose($tempFile);
?>