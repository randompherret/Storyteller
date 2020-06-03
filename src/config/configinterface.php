<?php

namespace src\Config;

interface ConfigInterface {
    public function getSetting(string $section,string $setting): string;
}