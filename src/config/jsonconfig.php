<?php

namespace src\Config;

use \src\Config\ConfigInterface;
use \src\Command\Observer;

class JsonConfig extends Observer implements ConfigInterface{
    private $config;
    private $filename;

    public function __construct($file) {
        parent::__construct();
        $this->filename = "saves" . DIRECTORY_SEPARATOR . $file . ".json";
        if (!file_exists($file)) {
            $template = array(
                "room" => array(
                    "id" => $file,
                ),
                "book"=> array(
                    "name" => "jofm",
                ),
                "character" => array(
                ),
            );
            $jsonData = json_encode($template, JSON_PRETTY_PRINT);
            file_put_contents($this->filename, $jsonData);
        }
        $this->commands["set"] = array(
            "command" => "setCommand",
            "hint" => "set - Change various options",
        );
        $this->config = json_decode(file_get_contents($this->filename), true);
    }

    public function getSetting(string $section,string $setting): string{
        if (isset($this->config[$section]) && isset($this->config[$section][$setting])){
            return $this->config[$section][$setting];
        } else {
            return "";
        }
    }
    public function setCommand(string $command): string {
        $command = explode(" ",$command);
        if (count($command) == 3) {
            if($this->setSetting($command[0],$command[1],$command[2])) {
                return "Saved";
            }else {
                return "Unable to save";
            }
        } else {
            return "Incorrect info for saving";
        }
    }
    public function setSetting(string $section,string $setting, string $value): bool{
        $this->config[$section][$setting] = $value;
        $jsonData = json_encode($this->config, JSON_PRETTY_PRINT);
        return file_put_contents($this->filename, $jsonData);
    }
}