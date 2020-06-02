<?php

namespace src\Platform;

abstract class platformFactory {
    protected $connector;
    protected $emoji;
    private $headers;
    private $request;

    abstract public function getCommands(string $request): array;
    abstract public function sendMessage(string $text): bool;
}