<?php

namespace src\Platform;

abstract class PlatformFactory {
    protected $connector;
    protected $emoji;
    private $headers;
    private $request;

    #abstract public function getEmoji(): EmojiInterface;
    #abstract public function makePoll(): string;
    abstract public function sendMessage(string $text): bool;
    #abstract public function makePage(): string;
    abstract public function getCommands(string $request): array;
}