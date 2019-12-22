<?php

namespace vendor\core;

use Debug;

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
            $controllerClass = 'app\\controllers\\' . self::upperCamelCase(self::$route['controller']);
            $actionController = 'action' . self::upperCamelCase(self::$route['action']);

            if (class_exists($controllerClass)) {
                if (method_exists($controllerClass, $actionController)) {
                    $controllerObject = new $controllerClass(
                        self::upperCamelCase(self::$route['controller']), 
                        self::$route['action']
                    );
                    $controllerObject->$actionController();
                } else {
                    echo "Method $actionController non exists in controller $controllerClass";
                }
            } else {
                echo 'Controller ' . $controllerClass . ' non exists';
            }
        } else {
            http_response_code(404);
            echo 'Страница не найденна';
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