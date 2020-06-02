<?php

namespace src\Platform;
use \src\Platform\PlatformFactory;
use \src\Connector\SlackConnector;

class slackPlatform extends platformFactory {
    private $channel;

    public function __construct(array $headers, string $request, string $secret, string $hook){
        $this->headers = $headers;
        $this->request = $request;
        $this->connector = new SlackConnector($headers,$request,$secret,$hook);
        if (!$this->connector->Validate()) {
            die ("not valid");  
        }
        $request = json_decode($request, TRUE);
        $this->channel = $request["event"]["channel"];
    }
    public function getCommands(string $request): array{
        $request = json_decode($request, TRUE);
        $fullText = str_replace("<@{$request["authed_users"][0]}>","",$request["event"]["text"]);
        $commands = explode(";",$fullText);
        return $commands;
    }
    public function sendMessage(string $text): bool{
        return $this->connector->sendMessage($this->channel,":book: $text");
    }
}