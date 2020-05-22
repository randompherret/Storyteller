<?php

namespace src\Config;

interface ConfigInterface {
    public function getSetting(string $section,string $setting): string;
    #public function getEvent(): EmojiInterface;
    #public function sendMessage(): bool;
    #public function getQueue(): array;
    #public function addQueue(): bool;
}