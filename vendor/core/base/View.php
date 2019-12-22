<?php

namespace vendor\core\base;

class View 
{
    public $route = [];

    public $view;

    public $layout;

    public function __construct($route, $layout = '', $view = '')
    {
        $this->route = $route;
        if ($layout === false) {
            $this->layout = false;
        } else {
            $this->layout = $layout ?: LAYOUT;   
        }
        $this->view = $view;
    }

    public function render($vars)
    {
        if (is_array($vars)) {
            extract($vars);
        } else {
            echo "Ошибка.Данные передаваемые в вид не являются массивом.";
        }

        $fileView = APP . "/views/{$this->route['controller']}/{$this->view}.php";
        ob_start();
        if (is_file($fileView)) {
            require_once $fileView;
        } else {
            echo 'Не найден файл вида ' . $fileView;
        }
        $content = ob_get_clean();

        if ($this->layout !== false) {
            $fileLayout = APP . "/views/layouts/{$this->layout}.php";
            if (is_file($fileLayout)) {
                require_once $fileLayout;
            } else {
                echo 'Не найден файл шаблона ' . $fileLayout;
            }
        }
    }
}