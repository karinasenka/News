<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->registerCssFile('@web/css/it_post.css');

$this->title = 'Адміністрування новин';
$this->params['breadcrumbs'][] = $this->title;

$posts = $dataProvider->getModels();
$pagination = $dataProvider->getPagination();
?>

<h1 class="page-title"><?= Html::encode($this->title) ?></h1>

<div class="mb-3">
    <?= Html::a('➕ Додати новину', ['create'], ['class' => 'btn btn-dark']) ?>
</div>

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

        <h2 class="post-title"><?= Html::encode($post->title) ?></h2>

        <div class="post-meta">
            <span class="badge badge-accent">
                Категорія: <?= Html::encode($post->category->name ?? '—') ?>
            </span>

            <span class="badge badge-accent" style="margin-left:8px;">
                <?= ((int)$post->published === 1) ? 'Опубліковано' : 'Чернетка' ?>
            </span>
        </div>

        <p class="post-text">
            <?= Html::encode($post->text) ?>
        </p>

        <p class="post-date">
            Дата: <?= Html::encode($post->created_at) ?>
        </p>

        <div class="mt-3 d-flex gap-2">
            <?= Html::a('Переглянути', ['/post/view', 'id' => $post->id], [
                'class' => 'btn btn-light btn-sm'
            ]) ?>
            
            <?= Html::a('Редагувати', ['update', 'id' => $post->id], [
                'class' => 'btn btn-dark btn-sm'
            ]) ?>

            <?= Html::a('Видалити', ['delete', 'id' => $post->id], [
                'class' => 'btn btn-danger btn-sm',
                'data' => [
                    'confirm' => 'Ви точно хочете видалити новину?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>



    </div>
<?php endforeach; ?>
</div>

<div class="pagination">
    <?= LinkPager::widget(['pagination' => $pagination]) ?>
</div>
