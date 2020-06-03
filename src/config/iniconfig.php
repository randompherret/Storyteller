<?php

namespace src\Config;

use \src\Config\ConfigInterface;

class IniConfig implements ConfigInterface{
    private $slackSecret;
    private $slackHook;
    private $config;

    public function __construct($file) {
        if (!file_exists($file)) {
            die("Config file $file: not found.");
        }
        $this->config = parse_ini_file($file, true);
    }
    public function getSetting(string $section,string $setting): string{
        return $this->config[$section][$setting];
    }
}