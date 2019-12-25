<?php

namespace vendor\core\base;

class View 
{
    public $route = [];

    public $view;

    public $layout;

    public $scripts = [];

    public static $meta = [];

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
                $content = $this->getScripts($content);
                $scripts = [];
                if(!empty($this->scripts[0])) {
                    $scripts = $this->scripts[0];
                }
                require_once $fileLayout;
            } else {
                echo 'Не найден файл шаблона ' . $fileLayout;
            }
        }
    }

    protected function getScripts($content)
    {
        $pattern = "#<script.*?>.*?</script>#si";
        preg_match_all($pattern, $content, $this->scripts);
        if (!empty($this->scripts)) {
            $content = preg_replace($pattern, '', $content);
        }
        return $content;
    }

    public function loadView($view, $vars = [])
    {
        extract($vars);
        require_once APP . "/views/{$this->route['controller']}/{$view}.php";
    }
    
    public static function getMeta()
    {
        echo "<title>" . self::$meta['title'] . "</title>";
        echo '<meta name="description" content="' . self::$meta['desc'] . '">';
        echo '<meta name="keywords" content="' . self::$meta['keywords'] . '">';
    }

    public static function setMeta($title = '', $desc = '', $keywords = '')
    {
        self::$meta['title'] = $title;
        self::$meta['desc'] = $desc;
        self::$meta['keywords'] = $keywords;
    }
}