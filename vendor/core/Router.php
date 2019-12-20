<?php

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
        if (self::matchRoute($queryString)) {
            $controllerClass = self::upperCamelCase(self::$route['controller']);
            $actionController = 'action' . self::upperCamelCase(self::$route['action']);
            if (class_exists($controllerClass)) {
                if (method_exists($controllerClass, $actionController)) {
                    $controllerObject = new $controllerClass;
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
}