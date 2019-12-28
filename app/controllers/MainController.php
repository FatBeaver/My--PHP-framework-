<?php

namespace app\controllers;

use R;
use epframe\core\base\App;
use epframe\core\base\Controller;
use app\models\Main;

class MainController extends Controller 
{
    public function actionIndex()
    {
        $model = new Main();

        $allPosts = App::$app->cache->get('posts');
        if (!$allPosts) {
            $allPosts = R::findAll('posts');
            App::$app->cache->set('posts', $allPosts);
        } 
        \epframe\core\base\View::setMeta("INDEX", "Hello", "World");
        $this->setData(['allPosts' => $allPosts]);
    }

    public function actionTest()
    {   
        $model = new Main();

        $id = $_POST['id'];
        $post = R::findOne('posts', $id);
        echo $post;
        exit();
    }
}