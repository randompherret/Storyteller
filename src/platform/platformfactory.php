<?php

namespace src\Platform;

abstract class platformFactory {
    protected $connector;
    protected $emoji;
    private $headers;
    private $request;

    abstract public function sendMessage(string $text): bool;
    abstract public function getCommands(string $request): array;
}