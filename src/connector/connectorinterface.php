<?php

namespace src\Connector;

interface ConnectorInterface {
    public function Validate(): bool;
    public function sendMessage(string $channel, string $text): bool;
}