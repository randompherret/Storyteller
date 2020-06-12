<?php

namespace src\Ruleset;
use \src\Dice\Roller;
use \src\Command\Observer;

abstract class rulesetFactory extends observer {
    private $roller;
    protected $character;
    protected $inventory;
    
    public function __construct() {
        parent::__construct();
        $this->roller = new roller();
        $this->commands["roll"] = array(
            "command" => "rollDice",
            "hint" => "roll - use format 1d6+2 and get random numbers!",
        );
        $this->character = false;
        $this->inventory = false;
    }

    public function getCharacter() {
        return $this->character;
    }

    public function getInventory() {
        return $this->inventory;
    }
    
    public function hasCharacter() {
        return $this->character != false;
    }

    public function hasInventory() {
        return $this->inventory != false;
    }

    public function setInventory($inventory): void {
        $this->inventory->loadContents($inventory);
    }

    public function rollDice(string $dice): void {
        $this->director->messages[] = "rolled {$this->roller->roll($dice)}";
    }
}