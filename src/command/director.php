<?php

namespace src\Command;


class Director implements \SplSubject {

    public $observers;
    public $messages;

    public function __construct() {
        $this->observers = array(
            "*" => array(),
        );
        $this->messages = array();
    }

    private function initEventGroup(string $event = "*"): void {
        if (!isset($this->observers[$event])) {
            $this->observers[$event] = array();
        }
    }

    public function getCommands($class): void {
        $commands = $class->getCommands();
        foreach($commands as $name => $command) {
            $this->attach($class,$name);
        }
    }

    private function getEventObservers(string $event = "*"): array {
        $this->initEventGroup($event);

        return $this->observers[$event];
    }

    public function attach($observer, string $event = "*"): void {
        $this->initEventGroup($event);
        if ($event != "*") {
            $this->observers["*"][] = $observer;    
        }
        $this->observers[$event][] = $observer;
    }

    public function detach(\SplObserver $observer, string $event = "*"): void {
        foreach ($this->getEventObservers($event) as $key => $s) {
            if ($s === $observer) {
                unset($this->observers[$event][$key]);
            }
        }
    }

    public function notify(string $event = "*", $data = null): void {
        $observers = $this->getEventObservers($event);
        if(count($observers)){
            foreach ($observers as $observer) {
                $observer->runCommand($this, $event, $data);
            }
        } else {
            $this->messages[] = "Sorry I didn't understand $event";
        }
    }
}