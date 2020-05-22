<?php
use \src\Config\IniConfig;
use \src\Platform\SlackPlatform;

$tempFile = fopen("temp.json","w");
spl_autoload_register();

$config = new IniConfig("config.ini");
$headers = getallheaders();
$request = file_get_contents("php://input");
$event = json_decode($request, TRUE);
if (isset($headers['X-Slack-Request-Timestamp'], $headers['X-Slack-Signature'])){
    $platform = new SlackPlatform($headers,$request,$config->getSetting('slack','slack_secret'));
}

foreach($headers as $name => $line){
    fwrite($tempFile,"$name = $line\n");
}
fwrite($tempFile,"\n");
fwrite($tempFile,date('D, d M Y H:i:s'));
fwrite($tempFile,"\n");
fwrite($tempFile,json_encode($event, JSON_PRETTY_PRINT));
fclose($tempFile);