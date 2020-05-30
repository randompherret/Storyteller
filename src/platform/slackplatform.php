<?php

namespace src\Platform;
use \src\Platform\PlatformFactory;
use \src\Connector\SlackConnector;

class slackPlatform extends PlatformFactory {
    public function __construct(array $headers, string $request, string $secret, string $hook){
        $this->headers = $headers;
        $this->request = $request;
        $this->connector = new SlackConnector($headers,$request,$secret,$hook);
        if (!$this->connector->Validate()) {
            die ("not valid");  
        }
        $request = json_decode($request, TRUE);
        if ($request["event"]["subtype"] != "bot_message")
        $this->connector->sendMessage($request["event"]["channel"],$this->makeMessage($request["event"]["text"]));
        #$this->emoji = new SlackEmoji();
    }
    public function getConnector(): PlatformConnector {
        $this->connector;
    }
    #public function getEmoji(): EmojiInterface;
    #public function makePoll(): string;
    public function makeMessage(string $text): string{
        return $text;
    }
    #public function makePage(): string;
    #public function getEvent(): BookEvent;
}