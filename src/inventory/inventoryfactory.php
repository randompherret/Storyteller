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
        $this->commands["checkbag"] = array(
            "command" => "checkBag",
            "hint" => "checkback - Check your inventory and get a listing",
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

    public function checkBag(): void {
        ksort($this->contents);
        $this->director->messages[] = "You check your bag and find: ";
        foreach ($this->contents as $item){
            $this->director->messages[] = "{$item["name"]}: {$item["count"]}";
        }
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
        if ($this->removeItem($things[0],$things[1])) {
            $this->director->messages[] = "After counting {$things[0]} there are {$this->countItem($things[0])}";
        } else {
            $this->director->messages[] = "unable to put down {$things[0]}";
        }
    }

    public function removeItem (string $item, int $count = 1): int {
        if (isset($this->contents[$item])) {
            if ($this->contents[$item]['count'] > $count){
                $this->contents[$item]['count'] -= $count;
            } elseif ($this->contents[$item]['count'] == $count){
                unset($this->contents[$item]);
            } else {
                return false; 
            }
            $this->director->notify("saveInventory",$this->contents);
            return true;
        }
        return false; 
    }
}