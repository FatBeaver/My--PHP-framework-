<?php

namespace vendor\core;

class Registry
{
    protected static $objectContainer = [];

    protected static $instance;

    protected function __construct()
    {
        $config = require_once ROOT . '/config/config.php';
        foreach ($config['components'] as $name => $object) {
            self::$objectContainer[$name] = new $object;
        }
    }

    public static function instance()
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function __get($name)
    {
        if (is_object(self::$objectContainer[$name])) {
            return self::$objectContainer[$name];
        }
        return null;
    }

    public function __set($name, $object)
    {
        if (!isset(self::$objectContainer[$name])) {
            self::$objectContainer[$name] = new $object;
        }
    }
}