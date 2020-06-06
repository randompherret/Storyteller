<?php

namespace src\Command;

abstract class observer {
    protected $commands;   

    public function __construct() {
        $this->commands = array();
        $this->commands["help"] = array(
            "command" => "getHelp",
            "hint" => "",
        );
    }

    public function checkCommand(string $command): bool {
        return array_key_exists($command,$this->commands);
    }

    public function getCommands(): array {
        return $this->commands;
    }
    
    public function runCommand($observer, $event, $data): void {
        $method = $this->commands[$event]["command"];
        $observer->messages[] = $this->$method($data);
    }

    public function getHelp(): string {
        ksort($this->commands);
        $message = implode("\n",array_column($this->commands, 'hint'));
        return $message;
    }
}