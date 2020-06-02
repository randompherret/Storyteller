<?php

namespace src\Platform;

abstract class platformFactory {
    protected $connector;
    protected $messages;

    abstract public function getCommands(string $request): array;
    abstract public function queueMessage(string $request): bool;
    abstract public function sendMessages(): bool;
}