<?php

/** @var yii\web\View $this */
/** @var app\models\User $user_profile */
/** @var app\models\Publication[] $publications */
/** @var app\models\forms\CommentForm $model */
/** @var bool $isSubscription */
/** @var string $tab */

use app\assets\ProfileAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$user = $this->context->user;
$this->title = Yii::$app->name . ' | Профиль';

ProfileAsset::register($this);

?>
<div class="container">
    <section class="main-info">
        <div class="profile__wrapper">
            <img src="/uploads/avatars/<?= Html::encode($user_profile->chanel_avatar_path) ?>" class="profile__avatar" alt="Фото канала">
            <div class="main-info__wrapper">
                <h2 class="sidebar__title"><?= Html::encode($user_profile->chanel_name) ?></h2>
                <div class="static static--likes">Общее количество лайков: <span><?= count($user_profile->likes) ?></span></div>
                <div class="static static--subscribers">Количество подписчиков: <span><?= count($user_profile->subscribers) ?></span></div>
                <div class="static static--videos">Количество видео: <span><?= count($publications) ?></span></div>
            </div>
        </div>
        <div class="button__wrapper">
            <a href="<?= Url::to(['user/profile', 'userId' => $user_profile->id, 'tab' => 'subscriber']) ?>" class="profile__button subscribers">Подписчики</a>
            <a href="<?= Url::to(['user/profile', 'userId' => $user_profile->id, 'tab' => 'video']) ?>" class="profile__button videos">Видео</a>

            <?php if ($user_profile->id === $user->id) : ?>
                <a class="profile__button" href="<?= Url::to(['site/upload']) ?>">Загрузка</a>
            <?php else : ?>
                <a href="<?= Url::to(['subscription/toggle', 'userId' => $user_profile->id]) ?>" class="profile__button"><?= $isSubscription ? 'Вы подписаны' : 'Подписаться' ?></a>
            <?php endif; ?>

            <!-- Ссылка на новую страницу -->
            <a href="<?= Url::to(['user/profile', 'userId' => $user_profile->id, 'tab' => 'comment']) ?>" class="profile__button">Сообщество</a>
        </div>
    </section>

    <?php if (isset($tab)) : ?>

        <div class="video__wrapper">

            <?php if ($tab === 'video') : ?>
                <h2 class="comment__title">Видео</h2>
                <?php foreach ($publications as $publication) : ?>
                    <a href="<?= Url::to(['site/view', 'postId' => $publication->id]) ?>" class="video__item">
                        <div class="video__image">
                            <img class="preview" src="/uploads/previews/<?= Html::encode($publication->preview_path) ?>" alt="Превью видео" style="width: 464px; height: 162px; object-fit: cover; object-position: center;">
                        </div>
                        <p class="video__name"><?= Html::encode($publication->title) ?></p>
                        <p class="video__chanel"><?= Html::encode($publication->user->chanel_name) ?></p>
                        <p>Категория: <?= Html::encode($publication->category->name) ?></p>

                        <div class="video__likes-counter">
                            <svg viewBox="0 0 131 131" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M31.2141 130.499L31.2807 55.3521L77.2725 2.33404C78.0964 1.44732 79.3867 0.965547 81.0163 0.723189C82.644 0.481109 84.5212 0.489334 86.4436 0.508853L86.4486 0.00887909L86.4436 0.508854C88.2425 0.527038 89.4437 1.13604 90.2428 2.10805C91.059 3.10087 91.5054 4.53275 91.6512 6.27764C91.9432 9.77142 91.0126 14.2806 89.846 18.2817L89.8432 18.2914L89.8407 18.3012L80.1982 57.159L80.0442 57.7797L80.6837 57.7794L117.237 57.761C117.237 57.761 117.237 57.761 117.237 57.761C122.281 57.761 125.945 59.4168 128.119 62.1683C130.296 64.9229 131.053 68.8684 130.087 73.5965C130.087 73.5973 130.087 73.598 130.087 73.5987L120.535 118.535L120.535 118.536C119.769 122.19 118.833 125.156 117.182 127.212C115.561 129.229 113.209 130.42 109.459 130.42H109.459L31.2141 130.499Z" />
                                <path d="M0.536243 130.435L0.500247 57.7783L30.2937 57.7129L30.2103 130.495L0.536243 130.435Z" />
                            </svg>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
            <?php if ($tab === 'subscriber') : ?>
                <h2 class="comment__title">Подписчики</h2>
                <?php foreach ($user_profile->subscribers as $subscriber) : ?>
                    <?php

                    $userId = $subscriber->subscriber_id;
                    $isSubscription = array_filter($user->subscriptions, function ($subscription) use ($userId) {
                        return $subscription->user_id === $userId;
                    });

                    ?>

                    <a href="<?= Url::to(['user/profile', 'userId' => $subscriber->subscriber_id, 'tab' => 'video']) ?>" class="subscriber" style="margin-top: 30px;">
                        <img class="subscriber__img" src="/uploads/avatars/<?= Html::encode($subscriber->subscriber->chanel_avatar_path) ?>" alt="Фото подписчика">
                        <p class="subscriber__name">Имя подписчика: <?= Html::encode($subscriber->subscriber->chanel_name) ?></p>

                        <?php if ($subscriber->subscriber_id !== $user->id) : ?>
                            <a href="<?= Url::to(['subscription/toggle', 'userId' => $subscriber->subscriber->id]) ?>"><?= $isSubscription ? 'Вы подписаны' : 'Подписаться' ?></a>
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
            <?php
            $link = mysqli_connect("localhost", "root", "", "wt-video-hosting");
            if ($tab === 'comment') : ?>
                <section class="comment">

                    <?php if ($user_profile->id === $user->id) : ?>
                        <h2 class="comment__title">Сообщество</h2>
                        <form action="" class="form-post">
                            <textarea name='text' placeholder="Введите текст поста"></textarea>
                            <input type="text" class="hidden" value='<?= $user -> id ?>'>
                            <button class="profile__button add-post">Отправить</button>
                        </form>
                        <script>
                            let btn = document.querySelector('.profile__button.add-post');
                            let form = document.querySelector('.form-post');
                            btn.addEventListener('click', async () => {
                                let data = new FormData(form);
                                const url = 'http://localhost/sendPost.php';
                                try {
                                    const response = await fetch(url, {
                                        method: 'POST', // или 'PUT'
                                        body: JSON.stringify(data), // данные могут быть 'строкой' или {объектом}!
                                        headers: {
                                            'Content-Type': 'application/json'
                                        }
                                    });
                                    const json = await response.json();
                                    console.log('Успех:', JSON.stringify(json));
                                } catch (error) {
                                    console.error('Ошибка:', error);
                                }
                            });
                        </script>
                    <?php endif; ?>
                    <?php ?>
                    <div class="comment__wrapper">
                        <?php
                        $arrayPost = mysqli_query($link, "SELECT * FROM `community` WHERE `user_id` = $user->id");
                        while ($post = mysqli_fetch_array($arrayPost)) : ?>
                            <div class="comment__item">
                                <div class="comment__info">
                                    <span class="comment__author-name">Автор:</span>
                                    <span class="comment__date">Дата: <?= Html::encode($post['created_at']) ?></span>
                                </div>
                                <p class="comment__text"><?= Html::encode($post['text']) ?></p>
                            </div>
                        <?php endwhile; ?>
                    </div>
                    <?php
                    // 
                    ?>
                <?php endif; ?>
        </div>
        </section>
    <?php endif; ?>

</div>