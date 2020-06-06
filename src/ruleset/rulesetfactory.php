<?php

namespace src\Ruleset;
use \src\Dice\Roller;
use \src\Command\Observer;

abstract class rulesetFactory extends observer {
    private $roller;
    
    public function __construct() {
        parent::__construct();
        $this->roller = new roller();
        $this->commands["roll"] = array(
            "command" => "rollDice",
            "hint" => "roll - use format 1d6+2 and get random numbers!",
        );
    }

    public function rollDice(string $dice): string {
        return "rolled {$this->roller->roll($dice)}";
    }
}