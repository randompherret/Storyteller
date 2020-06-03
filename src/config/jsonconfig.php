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
        return $this->config[$section][$setting];
    }
}