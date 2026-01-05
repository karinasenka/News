<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Вхід';
?>

<div class="row justify-content-center">
    <div class="col-12 col-md-6 col-lg-5">

        <div class="card shadow-sm mt-4">
            <div class="card-body p-4">

                <h3 class="card-title mb-3 text-center"><?= Html::encode($this->title) ?></h3>

                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->errorSummary($model, ['class' => 'alert alert-danger']) ?>

                <?= $form->field($model, 'email')
                    ->textInput([
                        'autofocus' => true,
                        'placeholder' => 'name@example.com'
                    ])
                    ->label('Електронна пошта') ?>

                <?= $form->field($model, 'password')
                    ->passwordInput([
                        'placeholder' => 'Введіть пароль'
                    ])
                    ->label('Пароль') ?>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <?= $form->field($model, 'rememberMe')
                        ->checkbox()
                        ->label('Запамʼятати мене') ?>
                </div>

                <div class="d-grid gap-2">
                    <?= Html::submitButton('Увійти', ['class' => 'btn btn-dark btn-lg']) ?>
                </div>

                <?php ActiveForm::end(); ?>

                <hr class="my-4">

                <p class="mb-0 text-center">
                    Немає облікового запису?
                    <?= Html::a('Зареєструватися', ['auth/signup']) ?>
                </p>

            </div>
        </div>

    </div>
</div>
