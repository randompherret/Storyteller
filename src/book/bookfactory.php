<?php

namespace src\book;
use \src\Command\Observer;

abstract class BookFactory extends observer {
    protected $pages;
    protected $ruleSet;
    
    public function __construct() {
        parent::__construct();
        $this->commands["page"] = array(
            "command" => "getPage",
            "hint" => "page - go to a particular page. Example: page 1",
        );
    }
    
    public function getPage(string $pageNumber): void {
        if (isset($this->pages[$pageNumber])){
            $this->director->messages[] = $this->pages[$pageNumber];
            $this->director->notify("setSetting", array(
                "section" => "book",
                "setting" => "page",
                "value" => $pageNumber,
            ));
        } else {
            $this->director->messages[] = "Could not find page $pageNumber";
        }
    }
    
    public function getRuleset(): string {
        return $this->ruleSet;
    }
}