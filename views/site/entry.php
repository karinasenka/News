<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = "Форма користувача";
?>

<style>
    body {
        background: #f5f7fa;
        font-family: Arial, sans-serif;
    }
    .form-container {
        width: 400px;
        margin: 40px auto;
        background: white;
        padding: 25px 30px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #2c3e50;
    }
    .btn-custom {
        width: 100%;
        background: #000000;
        color: white;
        border-radius: 6px;
        padding: 10px;
    }
    .btn-custom:hover {
        background: #333333;
    }
</style>

<div class="form-container">
    <h2>Заповніть форму</h2>

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name')->textInput(['placeholder' => 'Ваше імʼя']) ?>

        <?= $form->field($model, 'email')->textInput(['placeholder' => 'example@gmail.com']) ?>

        <div class="form-group">
            <?= Html::submitButton('Надіслати', ['class' => 'btn btn-custom']) ?>
        </div>

    <?php ActiveForm::end(); ?>
</div>
