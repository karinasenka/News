<?php
use yii\helpers\Html;

$this->title = "Підтвердження";
?>

<style>
    .confirm-box {
        width: 400px;
        margin: 40px auto;
        background: #ffffff;
        padding: 25px 30px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        font-family: Arial;
    }
    h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #2c3e50;
    }
    ul {
        list-style: none;
        padding: 0;
        font-size: 16px;
    }
    li {
        margin-bottom: 10px;
    }
    .btn-black {
        background: #000000;
        color: #ffffff;
        padding: 10px 18px;
        border-radius: 6px;
        text-decoration: none;
        display: inline-block;
    }
    .btn-black:hover {
        background: #333333;
    }
</style>

<div class="confirm-box">
    <h2>Введені дані</h2>

    <ul>
        <li><b>Ім’я:</b> <?= Html::encode($model->name) ?></li>
        <li><b>Email:</b> <?= Html::encode($model->email) ?></li>
    </ul>

    <p style="text-align:center; margin-top:20px;">
        <?= Html::a('Повернутися назад', ['site/entry'], ['class' => 'btn-black']) ?>
    </p>
</div>
