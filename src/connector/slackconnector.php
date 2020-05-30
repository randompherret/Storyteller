<?php

namespace src\Connector;

use \src\Connector\ConnectorInterface;

class SlackConnector implements ConnectorInterface{
    private $queue;
    private $valid;
    private $hook;

    public function __construct(array $headers, string $request, string $secret, string $hook){
        $requestSignature = $headers['X-Slack-Signature'];
        $requestVersion = explode("=", $requestSignature)[0];
        $timestamp = $headers['X-Slack-Request-Timestamp'];
        $token = json_decode($request, TRUE)['token'];
        $timediff = time() - $timestamp;
        if (abs($timediff) >= 60){
            $this->valid = false;
        }
        $eventHash = hash_hmac('sha256', "$requestVersion:$timestamp:$request", $secret);
        if(!hash_equals($requestSignature, "$requestVersion=$eventHash")){
            $this->valid = false;
        }
        if (isset($request['challenge'])){
            echo $request['challenge'];
        }
        $this->hook = $hook;
        $this->valid = true;
    }
    public function Validate(): bool{
        return $this->valid;
    }
    #public function getEvent(): EmojiInterface;
    #public function sendMessage(): boolean;
    #public function getQueue(): array;
    #public function addQueue(): boolean;
}