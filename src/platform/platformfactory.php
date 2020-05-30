<?php

namespace src\Platform;

abstract class PlatformFactory {
    protected $connector;
    protected $emoji;
    private $headers;
    private $request;

    abstract public function getConnector(): PlatformConnector;
    #abstract public function getEmoji(): EmojiInterface;
    #abstract public function makePoll(): string;
    abstract public function sendMessage(string $text): bool;
    #abstract public function makePage(): string;
    #abstract public function getEvent(): BookEvent;
}