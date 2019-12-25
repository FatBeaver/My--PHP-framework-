<?php

namespace vendor\core\base;

abstract class Controller
{
    public $route;

    public $viewDir;

    public $viewFile;

    public $layout;

    public $vars = [];

    public function __construct($route, $class, $action)
    {   
        $this->route = $route;
        $this->viewDir = $class;
        $this->viewFile = $action;
    }

    public function getView()
    {
        $viewObject = new View($this->route, $this->layout, $this->viewFile);
        $viewObject->render($this->vars);
    }

    public function setData($vars)
    {
        $this->vars = $vars;
    }

    public function isAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
            $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }
} 