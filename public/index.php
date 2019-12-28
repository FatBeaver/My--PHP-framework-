<?php

use \epframe\core\Router;

$queryString = $_SERVER['QUERY_STRING'];

define('WWW', __DIR__);
define('CORE', dirname(__DIR__) . '/vendor/epframe/core');
define('ROOT', dirname(__DIR__));
define('APP', dirname(__DIR__) . '/app');
define('LAYOUT', 'default');
define('CACHE', dirname(__DIR__) . '/tmp/cache');
define('LIBS', dirname(__DIR__) . '/vendor/epframe/libs');
define("DEBUG", 1);

require_once __DIR__ . '/../vendor/autoload.php';

new \epframe\core\base\App();

Router::add('^posts-new/(?P<action>[a-z-]+)/(?P<alias>[a-z-]+)$', ['controller' => 'posts-new']);
Router::add('^posts-new/(?P<alias>[a-z-]+)$', ['controller' => 'posts-new', 'action' => 'index']);

// ========== DEFAULT ROUTE ==========
Router::add('^$', ['controller' => 'main', 'action' => 'index']);
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');

Router::dispatch($queryString);