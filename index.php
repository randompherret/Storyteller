<?php
use \src\Config\IniConfig;
use \src\Config\JsonConfig;
use \src\Platform\SlackPlatform;
use \src\Command\Director;


#$tempFile = fopen("temp.json","w");
spl_autoload_register();

$config = new IniConfig("config.ini");
$headers = getallheaders();
$request = file_get_contents("php://input");
if (isset($headers['X-Slack-Request-Timestamp'], $headers['X-Slack-Signature'])){
    $platform = new SlackPlatform($headers,$request,$config->getSetting('slack','slack_secret'),$config->getSetting('slack','slack_hook'));
}
$jsonConfig = new JsonConfig($platform->getId());
$ruleSet = "src\\RuleSet\\{$jsonConfig->getSetting('book','ruleSet')}Rules";
$ruleSet = new $ruleSet();
$director = new Director();
$director->getCommands($ruleSet);
$director->getCommands($jsonConfig);
$commands = $platform->getCommands($request);
foreach ($commands as $toDo){
    $toDo = ltrim($toDo);
    if (strlen($toDo) == 0){
        break;
    }
    $command = explode(" ", $toDo,2);
    $command = array_pad($command, 2, null);
    $command[0] = strtolower($command[0]);
    $director->notify($command[0],$command[1]);
}
#foreach($headers as $name => $line){
$platform->sendMessages($director->messages);
    #fwrite($tempFile,"$name = $line\n");
#}
#$event = json_decode($request, TRUE);
#fwrite($tempFile,"\n");
#fwrite($tempFile,date('D, d M Y H:i:s'));
#fwrite($tempFile,"\n");
#fwrite($tempFile,json_encode($event, JSON_PRETTY_PRINT));
#fclose($tempFile);