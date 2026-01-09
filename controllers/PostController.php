<?php

namespace app\controllers;

use yii\web\Controller;

use yii\data\Pagination;

use app\models\Post;
use yii\web\NotFoundHttpException;

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

        $posts = $query->orderBy(['created_at' => SORT_DESC])

            ->offset($pagination->offset)

            ->limit($pagination->limit)

            ->all();

        return $this->render('index', [

            'posts' => $posts,

            'pagination' => $pagination,

        ]);

    }
    public function actionView($id)
    {
        $post = Post::find()
            ->where(['id' => (int)$id, 'published' => 1])
            ->with('category')
            ->one();

        if ($post === null) {
            throw new NotFoundHttpException('Статтю не знайдено або вона не опублікована');
        }

        return $this->render('view', [
            'post' => $post,
        ]);
    }

}