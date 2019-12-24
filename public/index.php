<?php

use vendor\core\Router;
use vendor\core\Registry;

$queryString = $_SERVER['QUERY_STRING'];

require_once '../vendor/libs/Debug.php';

define('WWW', __DIR__);
define('CORE', dirname(__DIR__) . '/vendor/core');
define('ROOT', dirname(__DIR__));
define('APP', dirname(__DIR__) . '/app');
define('LAYOUT', 'default');
define('LIBS', dirname(__DIR__) . '/vendor/libs');

spl_autoload_register(function($class) {
    $file = ROOT . '/' . str_replace('\\', '/', $class) . '.php';
    if (is_file($file)) {
        require_once $file;
    }
});

$GC = Registry::instance();

Router::add('^posts-new/(?P<action>[a-z-]+)/(?P<alias>[a-z-]+)$', ['controller' => 'posts-new']);
Router::add('^posts-new/(?P<alias>[a-z-]+)$', ['controller' => 'posts-new', 'action' => 'index']);

// ========== DEFAULT ROUTE ==========
Router::add('^$', ['controller' => 'main', 'action' => 'index']);
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');

Router::dispatch($queryString);