<?php
require_once 'logic/config.php';
require_once 'logic/functions.php';
require_once 'logic/slack.php';
$request = file_get_contents("php://input");
$event = json_decode($request, TRUE);

if (isset($event['challenge'])){
    echo $event['challenge'];
}
?>