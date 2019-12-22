<?php

namespace vendor\core\base;

abstract class Controller
{
    public $class;

    public $action;

    public function __construct($class, $action)
    {   
        $this->class = $class;
        $this->action = $action;
        //include_once APP . "/views/{$this->class}/{$this->action}.php";
    }
} 