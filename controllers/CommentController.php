<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use app\models\Comment;
use app\models\Post;

class CommentController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['create'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionCreate()
    {
        $model = new Comment();

        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = (int)Yii::$app->user->id;

            $post = Post::find()
                ->where(['id' => $model->post_id, 'published' => 1])
                ->one();

            if (!$post) {
                throw new NotFoundHttpException('Статтю не знайдено.');
            }

            if ($model->parent_id !== null && (int)$model->parent_id > 0) {
                $parent = Comment::findOne(['id' => $model->parent_id, 'post_id' => $model->post_id]);
                if (!$parent) {
                    $model->parent_id = null;
                }
            } else {
                $model->parent_id = null;
            }

            if ($model->save()) {
                return $this->redirect(['post/view', 'id' => $model->post_id, '#' => 'comments']);
            }
        }

        return $this->goBack();
    }
}
