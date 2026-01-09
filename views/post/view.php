<?php
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use app\models\Comment;

$this->registerCssFile('@web/css/it_post.css');
$this->title = $post->title;

$url = Yii::$app->request->absoluteUrl;
$title = $post->title;

$commentModel = new Comment();
$commentModel->post_id = $post->id;
?>

<h1 class="page-title" style="text-align:center;">
    <?= Html::encode($post->title) ?>
</h1>

<div class="post-card" style="max-width: 900px; margin: 0 auto;">

    <?php if (!empty($post->image)): ?>
        <img
            src="<?= Yii::getAlias('@web/' . $post->image) ?>"
            alt="<?= Html::encode($post->title) ?>"
            style="width:100%; max-height:360px; object-fit:cover; border-radius:12px; margin-bottom:14px;"
        >
    <?php endif; ?>

    <div class="post-meta" style="margin-bottom: 12px;">
        <span class="badge">
            Категорія: <?= Html::encode($post->category->name ?? '—') ?>
        </span>

        <span style="margin-left:10px; font-size:12px; color:#cbd5e1;">
            Дата: <?= Html::encode($post->created_at) ?>
        </span>
    </div>

    <div class="post-text" style="white-space: pre-line;">
        <?= Html::encode($post->text) ?>
    </div>

    <hr style="border-color: rgba(255,255,255,0.15); margin: 16px 0;">

    <div class="post-actions">
    <div class="share-box">
        <button class="share-main-btn"
            onclick="navigator.clipboard.writeText('<?= $url ?>');
                    this.innerText='✔ Скопійовано';
                    setTimeout(()=>this.innerText='Поділитися',2000)">
            🔗 Поділитися
        </button>

        <div class="share-icons">
            <a href="https://t.me/share/url?url=<?= urlencode($url) ?>&text=<?= urlencode($title) ?>"
            target="_blank" title="Telegram" class="tg">
                <svg viewBox="0 0 24 24"><path d="M9.04 15.58l-.39 5.52c.56 0 .8-.24 1.1-.53l2.64-2.52 5.47 4.01c1 .55 1.72.26 1.98-.92l3.6-16.88c.34-1.56-.57-2.18-1.55-1.8L1.5 9.64c-1.52.6-1.5 1.45-.26 1.83l4.6 1.43L18.5 5.3c.6-.4 1.15-.18.7.22"/></svg>
            </a>

            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($url) ?>"
            target="_blank" title="Facebook" class="fb">
                <svg viewBox="0 0 24 24"><path d="M22 12a10 10 0 10-11.6 9.9v-7H7.7V12h2.7V9.8c0-2.7 1.6-4.2 4-4.2 1.2 0 2.4.2 2.4.2v2.6h-1.3c-1.3 0-1.7.8-1.7 1.6V12h2.9l-.5 2.9h-2.4v7A10 10 0 0022 12"/></svg>
            </a>

            <a href="https://twitter.com/intent/tweet?url=<?= urlencode($url) ?>&text=<?= urlencode($title) ?>"
            target="_blank" title="X (Twitter)" class="tw">
                <svg viewBox="0 0 24 24"><path d="M18.3 2H21l-6.4 7.3L22 22h-6.9l-5-6.6L4.7 22H2l6.9-7.9L2 2h7l4.6 6L18.3 2z"/></svg>
            </a>
        </div>
    </div>

</div>

<div class="post-card" style="max-width:900px; margin: 18px auto 0;">
    <h3 style="text-align:center; margin-bottom: 12px;">Коментарі</h3>

    <?php if (Yii::$app->user->isGuest): ?>
        <div style="background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.15); padding:12px; border-radius:12px;">
            Щоб залишити коментар, потрібно
            <?= Html::a('увійти', ['auth/login'], ['style' => 'color:#38bdf8; text-decoration:underline;']) ?>.
        </div>
    <?php else: ?>
        <div style="background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.15); padding:12px; border-radius:12px; margin-bottom:14px;">
            <?php $form = ActiveForm::begin([
                'action' => ['comment/create'],
                'method' => 'post',
            ]); ?>

            <?= $form->field($commentModel, 'post_id')->hiddenInput()->label(false) ?>
            <?= $form->field($commentModel, 'parent_id')->hiddenInput(['value' => null])->label(false) ?>

            <?= $form->field($commentModel, 'text')->textarea([
                'rows' => 3,
                'placeholder' => 'Напишіть коментар...'
            ])->label(false) ?>

            <?= Html::submitButton('Опублікувати', ['class' => 'btn btn-light']) ?>

            <?php ActiveForm::end(); ?>
        </div>
    <?php endif; ?>

    <?php
    $comments = $post->comments ?? [];
    ?>

    <?php if (empty($comments)): ?>
        <p style="text-align:center; color:#cbd5e1; margin:0;">Поки що коментарів немає.</p>
    <?php endif; ?>

    <?php foreach ($comments as $c): ?>
        <div style="border:1px solid rgba(255,255,255,0.15); border-radius:12px; padding:12px; margin-bottom:12px; background:rgba(0,0,0,0.10);">

            <div style="display:flex; justify-content:space-between; gap:10px;">
                <strong><?= Html::encode($c->user->name ?? 'Користувач') ?></strong>
                <small style="color:#cbd5e1;">
                    <?= Html::encode($c->created_at) ?>
                </small>
            </div>

            <div style="margin-top:8px; white-space:pre-line;">
                <?= Html::encode($c->text) ?>
            </div>

            <?php if (!Yii::$app->user->isGuest): ?>
                <?php
                $reply = new Comment();
                $reply->post_id = $post->id;
                $reply->parent_id = $c->id;
                ?>

                <div style="margin-top:10px;">
                    <?php $form = ActiveForm::begin([
                        'action' => ['comment/create'],
                        'method' => 'post',
                    ]); ?>

                    <?= $form->field($reply, 'post_id')->hiddenInput()->label(false) ?>
                    <?= $form->field($reply, 'parent_id')->hiddenInput()->label(false) ?>

                    <?= $form->field($reply, 'text')->textarea([
                        'rows' => 2,
                        'placeholder' => 'Відповісти...'
                    ])->label(false) ?>

                    <?= Html::submitButton('Відповісти', ['class' => 'btn btn-outline-light btn-sm']) ?>

                    <?php ActiveForm::end(); ?>
                </div>
            <?php endif; ?>

            <?php $replies = $c->replies ?? []; ?>
            <?php foreach ($replies as $r): ?>
                <div style="margin-top:10px; margin-left:18px; border-left:2px solid rgba(56,189,248,0.5); padding-left:12px;">
                    <div style="display:flex; justify-content:space-between; gap:10px;">
                        <strong><?= Html::encode($r->user->name ?? 'Користувач') ?></strong>
                        <small style="color:#cbd5e1;"><?= Html::encode($r->created_at) ?></small>
                    </div>

                    <div style="margin-top:6px; white-space:pre-line;">
                        <?= Html::encode($r->text) ?>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    <?php endforeach; ?>
</div>
