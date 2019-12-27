<?php

namespace vendor\core\base;

class ErrorHandler 
{
    public function __construct()
    {
        if (DEBUG) {
            error_reporting(-1);
        } else {
            error_reporting(0);
        }
        set_error_handler([$this, 'errorHandler']);
        ob_start();
        register_shutdown_function([$this, 'fatalErrorHandler']);
        set_exception_handler([$this, 'exceptionHandler']);
    }

    public function errorHandler($errno, $errstr, $errfile, $errline)
    {   
        $this->errorLog($errno, $errstr, $errfile, $errline);
        $this->displayError($errno, $errstr, $errfile, $errline);
        return true;
    }

    public function fatalErrorHandler()
    {
        $error = error_get_last();
        if (!empty($error) && $error['type'] & (E_ERROR | E_PARSE | E_COMPILE_ERROR | 
        E_CORE_ERROR)) {
            ob_end_clean();
            $this->errorLog($error['type'], $error['message'], $error['file'], $error['line']);
            $this->displayError($error['type'], $error['message'], $error['file'], $error['line']);
        } else {
            ob_end_flush();
        }
    }

    public function exceptionHandler($e)
    {   
        $this->errorLog('Исключение', $e->getMessage(), $e->getFile(), $e->getLine(), $e->getCode());

        $this->displayError('Исключение', $e->getMessage(), $e->getFile(), $e->getLine(), 
        $e->getCode());
    }


    protected function errorLog($errno, $errstr, $errfile, $errline) 
    {
        error_log("[" . date('d-m-Y H:i:s') . "];
        Текст ошибки: {$errstr};\nФайл ошибки: {$errfile};
        Строка ошибки: {$errline};
        //============================================//\n\n", 3, ROOT . '/tmp/err.log');
    }

    protected function displayError($errno, $errstr, $errfile, $errline, $response = 500)
    {
        http_response_code($response);
        if ($response == 404) {
            require_once WWW . '/errors/404.php';
            exit();
        }
        if (DEBUG) {
            require_once WWW . '/errors/dev.php';
        } else {
            require_once WWW . '/errors/dev.php';
        }
        exit();
    }
}