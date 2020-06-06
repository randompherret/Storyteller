<?php

namespace src\Ruleset;
use \src\Dice\Roller;

abstract class rulesetFactory {
    private $commands;
    private $roller;
    
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

    public function checkCommand(string $command): bool {
        return array_key_exists($command,$this->commands);
    }

    public function getCommands(): array {
        return $this->commands;
    }

    public function rollDice(string $dice): string {
        return "rolled {$this->roller->roll($dice)}";
    }
    
    public function runCommand($observer, $event, $data): void {
        $method = $this->commands[$event]["command"];
        $observer->messages[] = $this->$method($data);
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