<?php

namespace src\Command;

abstract class observer {
    protected $commands;  
    protected $director;

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
    
    public function runCommand($director, $event, $data): void {
        $method = $this->commands[$event]["command"];
        $this->director = $director;
        $this->$method($data);
    }

    public function getHelp(): void {
        ksort($this->commands);
        $message = implode("\n",array_column($this->commands, 'hint'));
        $this->director->messages[] = $message;
    }
}