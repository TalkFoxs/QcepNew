<?php

class Vista{
    public $lang;
    
    public function __construct() {
        if (isset($_COOKIE["lang"])) {
            $this->lang = $_COOKIE["lang"];
        } else {
            $this->lang = "es";
        }
    }
}

