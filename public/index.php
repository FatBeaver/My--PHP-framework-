<?php

use vendor\core\Router;


$queryString = $_SERVER['QUERY_STRING'];

require_once '../vendor/libs/Debug.php';

define('WWW', __DIR__);
define('CORE', dirname(__DIR__) . '/vendor/core');
define('ROOT', dirname(__DIR__));
define('APP', dirname(__DIR__) . '/app');

spl_autoload_register(function($class) {
    $file = ROOT . '/' . str_replace('\\', '/', $class) . '.php';
    if (is_file($file)) {
        require_once $file;
    }
});

Router::add('^posts-new/(?P<action>[a-z-]+)/(?P<alias>[a-z-]+)$', ['controller' => 'posts-new']);
Router::add('^posts-new/(?P<alias>[a-z-]+)$', ['controller' => 'posts-new', 'action' => 'index']);

// ========== DEFAULT ROUTE ==========
Router::add('^$', ['controller' => 'Main', 'action' => 'index']);
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');

Debug::print(Router::getRoutes());

Router::dispatch($queryString);