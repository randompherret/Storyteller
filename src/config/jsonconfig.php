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
        if (!file_exists($this->filename)) {
            $template = array(
                "room" => array(
                    "id" => $file,
                ),
                "book"=> array(
                    "name" => "jofm",
                ),
                "character" => array(
                
                ),
                "inventory" => array(

                ),
            );
            $jsonData = json_encode($template, JSON_PRETTY_PRINT);
            file_put_contents($this->filename, $jsonData);
        }
        $this->config = json_decode(file_get_contents($this->filename), true);
        $this->commands["set"] = array(
            "command" => "setCommand",
            "hint" => "set - Change various options",
        );
        $this->commands["save"] = array(
            "command" => "outputFile",
            "hint" => "",
        );
        $this->commands["saveInventory"] = array(
            "command" => "saveInventory",
            "hint" => "",
        );
    }

    public function getInventory(): array{
        if (isset($this->config["inventory"])){
            return $this->config["inventory"];
        } else {
            return array();
        }
    }

    public function getSetting(string $section,string $setting): string{
        if (isset($this->config[$section]) && isset($this->config[$section][$setting])){
            return $this->config[$section][$setting];
        } else {
            return "";
        }
    }

    public function outputFile(): bool {
        $jsonData = json_encode($this->config, JSON_PRETTY_PRINT);
        return file_put_contents($this->filename, $jsonData);
    }

    public function saveInventory($inventory): void {
        $this->config["inventory"] = $inventory;
    }

    public function setCommand(string $command): void {
        $command = explode(" ",$command);
        if (count($command) == 3) {
            if($this->setSetting($command[0],$command[1],$command[2])) {
                $this->director->messages[] =  "Saved";
            }else {
                $this->director->messages[] =  "Unable to save";
            }
        } else {
            $this->director->messages[] =  "Incorrect info for saving";
        }
    }

    public function setSetting(string $section,string $setting, string $value): bool{
        $this->config[$section][$setting] = $value;
        return $this->outputFile();
    }
}