<?php

namespace app\controllers;

use yii\web\Controller;

use yii\data\Pagination;
use app\models\Category;

use app\models\Post;
use yii\web\NotFoundHttpException;
use Yii;

class PostController extends Controller

{
    public function actionIndex()

    {
        $request = Yii::$app->request;

        $tag = $request->get('PostSearch')['tags'] ?? null;
        $categoryId = $request->get('category_id');

        $query = Post::find()
            ->where(['published' => 1])
            ->with('category');

        if (!empty($tag)) {
                $query->andWhere(['like', 'tags', $tag]);
        }
        if (!empty($categoryId)) {
        $query->andWhere(['category_id' => (int)$categoryId]);
        }
        $pagination = new Pagination([

            'defaultPageSize' => 3,

            'totalCount' => $query->count(),

        ]);

        $posts = $query->orderBy(['created_at' => SORT_DESC])

            ->offset($pagination->offset)

            ->limit($pagination->limit)

            ->all();
        $categories = Category::find()->orderBy(['name' => SORT_ASC])->all();

        return $this->render('index', [

            'posts' => $posts,
            'pagination' => $pagination,
            'tag' => $tag,
            'categories' => $categories,
            'activeCategoryId' => (int)$categoryId,
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