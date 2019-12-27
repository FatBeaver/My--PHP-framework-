<?php

use vendor\core\Router;

$queryString = $_SERVER['QUERY_STRING'];

define('WWW', __DIR__);
define('CORE', dirname(__DIR__) . '/vendor/core');
define('ROOT', dirname(__DIR__));
define('APP', dirname(__DIR__) . '/app');
define('LAYOUT', 'default');
define('CACHE', dirname(__DIR__) . '/tmp/cache');
define('LIBS', dirname(__DIR__) . '/vendor/libs');
define("DEBUG", 1);

spl_autoload_register(function($class) {
    $file = ROOT . '/' . str_replace('\\', '/', $class) . '.php';
    if (is_file($file)) {
        require_once $file;
    }
});

new \vendor\core\base\App();

Router::add('^posts-new/(?P<action>[a-z-]+)/(?P<alias>[a-z-]+)$', ['controller' => 'posts-new']);
Router::add('^posts-new/(?P<alias>[a-z-]+)$', ['controller' => 'posts-new', 'action' => 'index']);

// ========== DEFAULT ROUTE ==========
Router::add('^$', ['controller' => 'main', 'action' => 'index']);
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');

Router::dispatch($queryString);