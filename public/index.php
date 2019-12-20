<?php

$queryString = $_SERVER['QUERY_STRING'];

require_once '../vendor/core/Router.php';
require_once '../vendor/libs/Debug.php';
require_once '../app/controllers/Main.php';
require_once '../app/controllers/Posts.php';
require_once '../app/controllers/PostsNew.php';

Router::add('^$', ['controller' => 'Main', 'action' => 'index']);
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');

Debug::print(Router::getRoutes());

Router::dispatch($queryString);

Debug::print(Router::getRoute());