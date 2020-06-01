<?php

namespace src\Ruleset;
use \src\Dice\Roller;

abstract class rulesetFactory {
    private $commands;
    
    public function __construct() {
        $this->commands = array();
        $this->roller = new roller();
        $this->commands["roll"] = array(
            "command" => "rollDice",
            "hint" => "use format 1d6+2 and get random numbers!",
        );
        $this->commands["help"] = array(
            "command" => "getHelp",
            "hint" => "Show this help.",
        );
    }    
    public function rollDice(string $dice): string {
        return "rolled {$this->roller->roll($dice)}";
    }
    public function getHelp(): string {
        $message = "Here are the commands you can run:\n";
        ksort($this->commands);
        foreach ($this->commands as $name => $command) {
            $message .= "$name: {$command["hint"]}\n";
        }
        $message .= "Multiple commands can be sent at once using ; to separate them.\n";
        return $message;
    }
}