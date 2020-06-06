<?php

namespace src\Config;

use \src\Config\ConfigInterface;

class JsonConfig implements ConfigInterface{
    private $config;

    public function __construct($file) {
        $fileName = "saves" . DIRECTORY_SEPARATOR . $file . ".json";
        if (!file_exists($file)) {
            $template = array(
                "room" => array(
                    "id" => $file,
                ),
            );
            $jsonData = json_encode($template, JSON_PRETTY_PRINT);
            file_put_contents($fileName, $jsonData);
        } 
        $this->config = json_decode(file_get_contents($fileName), true);
    }
    public function getSetting(string $section,string $setting): string{
        if (isset($this->config[$section]) && isset($this->config[$section][$setting])){
            return $this->config[$section][$setting];
        } else {
            return "";
        }
    }
    public function setSetting(string $section,string $setting, string $value): bool{
        $this->config[$section][$setting] = $value;
        $jsonData = json_encode($this->config, JSON_PRETTY_PRINT);
        return file_put_contents($fileName, $jsonData);
    }
}