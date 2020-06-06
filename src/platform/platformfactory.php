<?php

namespace src\Platform;

abstract class platformFactory {
    protected $connector;

    abstract public function getCommands(string $request): array;
    abstract public function getId(): string;
    abstract public function sendMessages(array $messages): bool;
}