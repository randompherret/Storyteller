<?php

namespace src\Inventory;
use \src\Command\Observer;

abstract class InventoryFactory extends Observer {
    private $contents;
    
    public function __construct(){
        parent::__construct();
        $this->commands["pickup"] = array(
            "command" => "pickupItem",
            "hint" => "pickup - Pickup an item, optionally include a count. Example: pickup gold 5",
        );
        $this->commands["putdown"] = array(
            "command" => "putDownItem",
            "hint" => "putdown - Putdown an item, optionally include a count. Example: putdown gold 5",
        );
    }

    public function addItem (string $item, int $count = 1): void{
        if (isset($this->contents[$item])) {
            $this->contents[$item]['count'] += $count;
        } else {
            $this->contents[$item] = array(
                "name" => $item,
                'count' => $count,
            );
        }
        $this->director->notify("saveInventory",$this->contents);
    }

    public function countItem (string $item): int{
        if (isset($this->contents[$item])) {
            return $this->contents[$item]['count'];
        } else {
            return 0;
        }
    }

    public function loadContents($contents): void {
        $this->contents = $contents;
    }

    public function pickupItem(string $things): void {
        $things = explode(" ",$things);
        $things = array_pad($things, 2, 1);
        $this->addItem($things[0],$things[1]);
        $this->director->messages[] = "After counting {$things[0]} there are {$this->countItem($things[0])}";
    }

    public function putDownItem(string $things): void {
        $things = explode(" ",$things);
        $things = array_pad($things, 2, 1);
        $this->removeItem($things[0],$things[1]);
        $this->director->messages[] = "After counting {$things[0]} there are {$this->countItem($things[0])}";
    }

    public function removeItem (string $item, int $count = 1): void{
        if (isset($this->contents[$item])) {
            $this->contents[$item]['count'] -= $count;
            if ($this->contents[$item]['count'] <= 0){
                unset($this->contents[$item]);
            }
        }
        $this->director->notify("saveInventory",$this->contents);
    }
}