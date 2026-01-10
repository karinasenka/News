<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);

$isGuest = Yii::$app->user->isGuest;
$isAdmin = !$isGuest && method_exists(Yii::$app->user->identity, 'isAdmin') && Yii::$app->user->identity->isAdmin();

$tag = Yii::$app->request->get('PostSearch')['tags'] ?? '';
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100 site-body <?= Yii::$app->controller->id . '-' . Yii::$app->controller->action->id ?>">

<?php $this->beginBody() ?>

<header id="header">
    <?php
    NavBar::begin([
        'brandLabel' => false,
        'options' => ['class' => 'navbar navbar-expand-lg navbar-dark fixed-top app-navbar'],
        'containerOptions' => ['class' => 'container-fluid px-4'],
    ]);

    echo Html::a('<span class="brand-mark">IT News</span>', ['/post/index'], [
        'class' => 'navbar-brand',
        'encode' => false,
    ]);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav me-3'],
        'items' => array_values(array_filter([
            ['label' => 'Новини', 'url' => ['/post/index']],
            $isAdmin ? ['label' => 'Адмін-панель', 'url' => ['/admin/post/index']] : null,
        ])),
    ]);
    echo '<div class="d-flex align-items-center ms-auto gap-2">';

    echo Html::beginForm(['/post/index'], 'get', ['class' => 'header-search d-none d-md-flex']);
    echo Html::input('text', 'PostSearch[tags]', $tag, [
        'class' => 'form-control form-control-sm header-search-input',
        'placeholder' => 'Пошук по мітках…',
        'autocomplete' => 'off',
    ]);
    echo Html::submitButton('Пошук', ['class' => 'header-search-btn']);
    echo Html::endForm();

    if ($isGuest) {
        echo Html::a('Увійти', ['/auth/login'], ['class' => 'btn btn-sm btn-outline-light header-auth-btn']);
    } else {
        echo Html::beginForm(['/auth/logout'], 'post', ['class' => 'd-inline']);
        echo Html::submitButton('Вийти', ['class' => 'btn btn-sm btn-outline-light header-auth-btn']);
        echo Html::endForm();
    }

    echo '</div>';

    NavBar::end();
    ?>
</header>

<main id="main" class="flex-shrink-0" role="main">
    <div class="container">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
