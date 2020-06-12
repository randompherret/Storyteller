<?php

namespace src\RuleSet;
use src\Ruleset\RuleSetFactory;
use src\Character\BasicCharacter;
use src\Inventory\BasicInventory;

class basicRules extends RuleSetFactory {
    
    public function __construct() {
        parent::__construct();
        $this->character = new BasicCharacter;
        $this->inventory = new BasicInventory;
    }


}