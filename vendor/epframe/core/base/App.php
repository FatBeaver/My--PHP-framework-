<?php

namespace epframe\core\base;

use epframe\core\Registry;

class App 
{
    public static $app;

    public function __construct()
    {
        self::$app = Registry::instance();
        new ErrorHandler();
    }
}