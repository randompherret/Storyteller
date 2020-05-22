<?php

namespace src\Connector;

interface ConnectorInterface {
    public function Validate(): bool;
    #public function getEvent(): EmojiInterface;
    #public function sendMessage(): bool;
    #public function getQueue(): array;
    #public function addQueue(): bool;
}