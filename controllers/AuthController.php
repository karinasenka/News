<?php

namespace app\controllers;

use app\models\LoginForm;
use app\models\SignupForm;
use app\models\User;
use Yii;
use yii\web\Controller;

class AuthController extends Controller
{
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return Yii::$app->user->identity->isAdmin()
                ? $this->redirect(['/admin/post/index'])
                : $this->redirect(['/post/index']);
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            if (Yii::$app->user->identity->isAdmin()) {
                return $this->redirect(['/admin/post/index']);
            }

            return $this->redirect(['/post/index']);
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
/**
 * Logout action.
 *
 * @return \yii\web\Response
 */
public function actionLogout()
{
    Yii::$app->user->logout();
    return $this->redirect(['auth/login']);
}


    public function actionSignup()
    {
        $model = new SignupForm();

        if(Yii::$app->request->isPost)
        {
            $model->load(Yii::$app->request->post());
            if($model->signup())
            {
                return $this->redirect(['auth/login']);
            }
        }

        return $this->render('signup', ['model'=>$model]);
    }

    public function actionTest()
    {
        $user = User::findOne(1);

        Yii::$app->user->logout();

        if(Yii::$app->user->isGuest)
        {
            echo 'Користувач у гостьовому режимі.';
        }
        else
        {
            echo 'Користувач авторизований!';
        }
    }
}