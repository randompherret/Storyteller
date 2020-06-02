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
foreach ($commands as $toDo){
    $toDo = ltrim($toDo);
    if (strlen($toDo) == 0){
        break;
    }
    $command = explode(" ", $toDo,2);
    $command = array_pad($command, 2, null);
    $command[0] = strtolower($command[0]);
    if(!$ruleSet->checkCommand($command[0])){
        $platform->queueMessage("Sorry, I didn't understand $toDo");
        break;    
    }
    $function = $ruleSet->getCommand($command[0]);
    $platform->queueMessage($ruleSet->$function($command[1]));
}
$platform->sendMessages();

#foreach($headers as $name => $line){
    #fwrite($tempFile,"$name = $line\n");
#}
#$event = json_decode($request, TRUE);
#fwrite($tempFile,"\n");
#fwrite($tempFile,date('D, d M Y H:i:s'));
#fwrite($tempFile,"\n");
#fwrite($tempFile,json_encode($event, JSON_PRETTY_PRINT));
#fclose($tempFile);