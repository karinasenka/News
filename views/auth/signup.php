<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Реєстрація';
?>

<div class="row justify-content-center">
    <div class="col-12 col-md-7 col-lg-6">

        <div class="card shadow-sm mt-4">
            <div class="card-body p-4">

                <h3 class="card-title mb-3 text-center"><?= Html::encode($this->title) ?></h3>

                <?php $form = ActiveForm::begin(['id' => 'signup-form']); ?>

                <?= $form->errorSummary($model, ['class' => 'alert alert-danger']) ?>

                <?= $form->field($model, 'name')
                    ->textInput([
                        'autofocus' => true,
                        'placeholder' => "Ваше ім'я"
                    ])
                    ->label("Ім'я") ?>

                <?= $form->field($model, 'email')
                    ->textInput([
                        'placeholder' => 'name@example.com'
                    ])
                    ->label('Електронна пошта') ?>

                <?= $form->field($model, 'password')
                    ->passwordInput([
                        'placeholder' => 'Мінімум 6 символів'
                    ])
                    ->label('Пароль') ?>

                <div class="d-grid gap-2">
                    <?= Html::submitButton('Зареєструватися', ['class' => 'btn btn-dark btn-lg']) ?>
                </div>

                <?php ActiveForm::end(); ?>

                <hr class="my-4">

                <p class="mb-0 text-center">
                    Вже маєте обліковий запис?
                    <?= Html::a('Увійти', ['auth/login']) ?>
                </p>

            </div>
        </div>

    </div>
</div>
