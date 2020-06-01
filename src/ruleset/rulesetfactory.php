<?php

namespace src\Ruleset;
use \src\Dice\Roller;

abstract class rulesetFactory {
    private $commands;
    public function __construct() {
        $this->commands = array();
    }    
}