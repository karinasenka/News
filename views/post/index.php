<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\Url;

$this->registerCssFile('@web/css/it_post.css');
?>

<?php
/** @var $categories app\models\Category[] */
/** @var $activeCategoryId int */
/** @var $tag string|null */
?>
<div class="news-page">
    <div class="categories-wrap">
        <div class="categories-bar">
            <a class="cat-btn <?= $activeCategoryId ? '' : 'active' ?>"
                href="<?= Url::to(['post/index', 'PostSearch' => ['tags' => $tag]]) ?>">
                Всі
            </a>

            <?php foreach ($categories as $cat): ?>
                <a class="cat-btn <?= ($activeCategoryId === (int)$cat->id) ? 'active' : '' ?>"
                    href="<?= Url::to(['post/index', 'category_id' => $cat->id, 'PostSearch' => ['tags' => $tag]]) ?>">
                    <?= Html::encode($cat->name) ?>
                </a>
            <?php endforeach; ?>
        </div>
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

        <?php if (!empty($post->tags)): ?>
            <div class="tags-row">
                <?php foreach (preg_split('/\s*,\s*/u', $post->tags, -1, PREG_SPLIT_NO_EMPTY) as $tag): ?>
                    <span class="tag-pill">
                        #<?= Html::encode($tag) ?>
                    </span>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

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
</div>
