<?php

namespace app\controllers;

use vendor\core\base\Controller;

class PostsController extends Controller
{   

    public function actionIndex()
    {
        $name = 'JAjaada';
        $this->setData(['name' => $name]);
    }

    public function actionTest()
    {
        
    }
}