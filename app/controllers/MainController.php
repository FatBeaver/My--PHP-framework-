<?php

namespace app\controllers;

use R;
use vendor\core\base\Controller;
use app\models\Main;

class MainController extends Controller 
{
    public function actionIndex()
    {
        $model = new Main();
        $allPosts = R::findAll('posts');

        $this->setData(['allPosts' => $allPosts]);
    }

    public function actionAdd()
    {
        
    }
}