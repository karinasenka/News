<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->registerCssFile('@web/css/it_post.css');
?>

<h1 class="page-title">ІТ-Новини</h1>

<div class="posts-grid">
<?php foreach ($posts as $post): ?>
    <div class="post-card">
        <h2 class="post-title"><?= Html::encode($post->title) ?></h2>

        <div class="post-meta">
            <span class="badge badge-accent">
                Категорія: <?= Html::encode($post->category->name ?? 'No category') ?>
            </span>
        </div>

        <p class="post-text">
            <?= Html::encode($post->text) ?>
        </p>

        <p class="post-date">
            Опубліковано: <?= Html::encode($post->created_at) ?>
        </p>
    </div>
<?php endforeach; ?>
</div>

<div class="pagination">
    <?= LinkPager::widget(['pagination' => $pagination]) ?>
</div>
