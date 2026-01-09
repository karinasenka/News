<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->registerCssFile('@web/css/it_post.css');
?>

<h1 class="page-title">ІТ-Новини</h1>

<div class="posts-grid">
<?php foreach ($posts as $post): ?>
    <div class="post-card">
        <?php if (!empty($post->image)): ?>
            <img
                src="<?= Yii::getAlias('@web/' . $post->image) ?>"
                alt="<?= Html::encode($post->title) ?>"
                style="width:100%; max-height:220px; object-fit:cover; border-radius:8px; margin-bottom:12px;"
            >
        <?php endif; ?>
        <h2 class="post-title">
            <?= Html::a(
                Html::encode($post->title),
                ['post/view', 'id' => $post->id],
                ['style' => 'color:#fff; text-decoration:none;']
            ) ?>
        </h2>

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
