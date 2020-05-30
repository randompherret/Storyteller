<?php

namespace src\Platform;
use \src\Platform\PlatformFactory;
use \src\Connector\SlackConnector;

class slackPlatform extends PlatformFactory {
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
        #$this->emoji = new SlackEmoji();
    }
    #public function getEmoji(): EmojiInterface;
    #public function makePoll(): string;
    public function sendMessage(string $text): bool{
        return $this->connector->sendMessage($this->channel,":book: $text");
    }
    #public function makePage(): string;
    #public function getEvent(): BookEvent;
}