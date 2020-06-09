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
    
    public function getPage(string $pageNumber): string {
        return $this->pages[$pageNumber];
    }
    
    public function getRuleset(): string {
        return $this->ruleSet;
    }
}