<?php

namespace epframe\core;

use Debug;
use Exception;

class Router 
{
    protected static $routes = [];

    protected static $route = [];

    public static function add($regExp, $route = null)
    {
        self::$routes[$regExp] = $route;
    }

    public static function getRoutes()
    {
        return self::$routes;
    }

    public static function getRoute()
    {
        return self::$route;
    }

    public static function matchRoute($queryString)
    {
        foreach(self::$routes as $pattern => $route)
        {
            if (preg_match("#$pattern#i", $queryString, $matches)) {
                foreach ($matches as $key => $value) {
                    if (is_string($key)) {
                        $route[$key] = $value;
                    }
                }
                if (!isset($route['action'])) {
                    $route['action'] = 'index';
                }
                self::$route = $route;
                return true; 
            }
        }
        return false;
    }

    public static function dispatch($queryString)
    {   
        $queryString = self::removeQueryString($queryString);

        if (self::matchRoute($queryString)) {
            $controllerClass = 'app\\controllers\\' 
            . self::upperCamelCase(self::$route['controller']) . 'Controller';
            $actionController = 'action' . self::upperCamelCase(self::$route['action']);

            if (class_exists($controllerClass)) {
                if (method_exists($controllerClass, $actionController)) {
                    $controllerObject = new $controllerClass(
                        self::$route,
                        self::upperCamelCase(self::$route['controller']), 
                        self::$route['action']
                    );
                    $controllerObject->$actionController();
                    $controllerObject->getView();
                } else {
                    throw new Exception("Method $actionController non 
                    exists in controller $controllerClass", 404);
                }
            } else {
                throw new Exception("Method $actionController non 
                exists in controller $controllerClass", 404);
            }
        } else {
            throw new Exception("Non-correct query-string", 404);
        }
    }

    protected static function upperCamelCase($string)
    {
        $string = str_replace('-', ' ', $string);
        $string = ucwords($string);
        $string = str_replace(' ', '', $string);
        return $string;
    }

    protected static function removeQueryString($queryString)
    {   
        if ($queryString) {
            $params = explode('&', $queryString, 2);
            if (false === strpos($params[0], '=')) {
                return rtrim($params[0], '/');
            } else {
                return '';
            }
        }
        return $queryString;
    }
}