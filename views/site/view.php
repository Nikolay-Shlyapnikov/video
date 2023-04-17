<?php

/** @var yii\web\View $this */
/** @var app\models\Category[] $categories */
/** @var app\models\forms\CommentForm $model */
/** @var app\models\Publication $publication */
/** @var bool $isLike */
/** @var bool $isSubscription */

use app\assets\ViewAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$user = $this->context->user;

ViewAsset::register($this);

?>
<div class="container main-page__container">
    <?= $this->render('/_partials/sidebar', ['categories' => $categories]) ?>

    <section class="video">
        <div class="video__wrapper">
            <video class="video__item" src="/uploads/videos/<?= Html::encode($publication->video_path) ?>" controls></video>
            <p class="video__name"> <?= Html::encode($publication->title) ?></p>
            <p class="video__author">Канал: <?= Html::encode($publication->user->chanel_name) ?></p>
            <p><?= Html::encode($publication->category->name) ?></p>
            <p class="video__description">Описание: <?= Html::encode($publication->desc) ?></p>

            <?php if (isset($user) && $publication->user->id !== $user->id): ?>
                <a href="<?= Url::to(['subscription/toggle', 'userId' => $publication->user->id]) ?>"><?= $isSubscription ? 'Вы подписаны' : 'Подписаться' ?></a>
            <?php elseif (!isset($user)): ?>
                <a href="<?= Url::to(['subscription/toggle', 'userId' => $publication->user->id]) ?>">Подписаться</a>
            <?php endif; ?>

            <div class="video__likes-counter<?= $isLike ? ' active' : '' ?>">
                <span>Просмотры: <?= Html::encode($publication->view_count) ?></span>
                <span>Количество лайков: <?= count($publication->likes) ?></span>
                <a  href="<?= Url::to(['like/toggle', 'postId' => $publication->id]) ?>">
                    <svg viewBox="0 0 131 131" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M31.2141 130.499L31.2807 55.3521L77.2725 2.33404C78.0964 1.44732 79.3867 0.965547 81.0163 0.723189C82.644 0.481109 84.5212 0.489334 86.4436 0.508853L86.4486 0.00887909L86.4436 0.508854C88.2425 0.527038 89.4437 1.13604 90.2428 2.10805C91.059 3.10087 91.5054 4.53275 91.6512 6.27764C91.9432 9.77142 91.0126 14.2806 89.846 18.2817L89.8432 18.2914L89.8407 18.3012L80.1982 57.159L80.0442 57.7797L80.6837 57.7794L117.237 57.761C117.237 57.761 117.237 57.761 117.237 57.761C122.281 57.761 125.945 59.4168 128.119 62.1683C130.296 64.9229 131.053 68.8684 130.087 73.5965C130.087 73.5973 130.087 73.598 130.087 73.5987L120.535 118.535L120.535 118.536C119.769 122.19 118.833 125.156 117.182 127.212C115.561 129.229 113.209 130.42 109.459 130.42H109.459L31.2141 130.499Z"/>
                        <path d="M0.536243 130.435L0.500247 57.7783L30.2937 57.7129L30.2103 130.495L0.536243 130.435Z"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <section class="comment">
        <h2 class="comment__title">Комментарии</h2>
        <div class="container">

            <?php if (!Yii::$app->user->isGuest): ?>
                <?php $form = ActiveForm::begin([
                    'action' => Url::to(['site/view', 'postId' => $publication->id]),
                    'options' => [
                        'class' => 'form',
                        'novalidate' => true,
                        'autocomplete' => 'off',
                    ],
                    'fieldConfig' => [
                        'options' => ['class' => 'mb-3'],
                    ],
                ]); ?>

                <?= $form->field($model, 'text', ['template' => '{input}'])->textarea() ?>
                <?= $form->field($model, 'user_id', ['template' => '{input}'])->input('hidden', ['value' => $user->id]) ?>
                <?= $form->field($model, 'publication_id', ['template' => '{input}'])->input('hidden', ['value' => $publication->id]) ?>

                <?= Html::submitButton('Отправить') ?>

                <?php ActiveForm::end(); ?>
            <?php endif; ?>

        </div>

        <?php if ($publication->comments): ?>
            <div class="comment__wrapper">

                <?php foreach ($publication->comments as $comment): ?>
                    <div class="comment__item">
                        <div class="comment__info">
                            <img class="comment__author-image" src="/uploads/avatars/<?= Html::encode($comment->user->chanel_avatar_path) ?>" alt="Аватар автора">
                            <span class="comment__author-name">Автор: <?= Html::encode($comment->user->chanel_name) ?></span>
                            <span class="comment__date">Дата: <?= Html::encode($comment->created_at) ?></span>
                        </div>
                        <p class="comment__text"><?= Html::encode($comment->text) ?></p>
                        <a href="<?= Url::to(['comment/remove', 'commentId' => $comment->id]) ?>">удалить</a>
                    </div>
                <?php endforeach; ?>

            </div>
        <?php endif; ?>

    </section>
</div>
