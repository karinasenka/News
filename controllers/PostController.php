<?php

namespace app\controllers;

use yii\web\Controller;

use yii\data\Pagination;

use app\models\Post;

class PostController extends Controller

{
    public function actionIndex()

    {
        $query = Post::find()
            ->where(['published' => 1])
            ->with('category');


        $pagination = new Pagination([

            'defaultPageSize' => 3,

            'totalCount' => $query->count(),

        ]);

        $posts = $query->orderBy('title')

            ->offset($pagination->offset)

            ->limit($pagination->limit)

            ->all();

        return $this->render('index', [

            'posts' => $posts,

            'pagination' => $pagination,

        ]);

    }

}