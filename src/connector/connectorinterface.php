<?php

namespace src\Connector;

interface ConnectorInterface {
    public function Validate(): bool;
    #public function getEvent(): EmojiInterface;
    public function sendMessage(string $channel, string $text): bool;
    #public function getQueue(): array;
    #public function addQueue(): bool;
}