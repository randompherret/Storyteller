<?php
use \src\Config\IniConfig;
use \src\Platform\SlackPlatform;
use \src\RuleSet\basicRules;

#$tempFile = fopen("temp.json","w");
spl_autoload_register();

$config = new IniConfig("config.ini");
$headers = getallheaders();
$request = file_get_contents("php://input");
if (isset($headers['X-Slack-Request-Timestamp'], $headers['X-Slack-Signature'])){
    $platform = new SlackPlatform($headers,$request,$config->getSetting('slack','slack_secret'),$config->getSetting('slack','slack_hook'));
}

$ruleSet = new basicRules();
$commands = $platform->getCommands($request);
foreach ($commands as $command){
    $platform->sendMessage("got $command");
}

#foreach($headers as $name => $line){
    #fwrite($tempFile,"$name = $line\n");
#}
#$event = json_decode($request, TRUE);
#fwrite($tempFile,"\n");
#fwrite($tempFile,date('D, d M Y H:i:s'));
#fwrite($tempFile,"\n");
#fwrite($tempFile,json_encode($event, JSON_PRETTY_PRINT));
#fclose($tempFile);