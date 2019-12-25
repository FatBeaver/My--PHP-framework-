<?php

namespace vendor\core;

use R;

class Db
{
    protected $pdo;

    protected static $instance;

    public static $countSql = 0;

    public static $queries = [];

    protected function __construct()
    {
        $config = require ROOT . '/config/config.php';
        require_once LIBS . '/rb-mysql.php';
        R::setup($config['db']['dsn'], $config['db']['user'], $config['db']['passw']);
        R::freeze(true);
    }

    public static function instance()
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }
}