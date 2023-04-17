<?php

/** @var yii\web\View $this */
/** @var app\models\Category[] $categories */
/** @var app\models\Publication[] $publications */

use app\assets\IndexAsset;
use yii\helpers\Url;
use yii\helpers\Html;

IndexAsset::register($this);
?>
<div class="container main-page__container">
    <?=  $this->render('/_partials/sidebar', ['categories' => $categories]) ?>
    
    <section>
   
        <h2 class="video__title">Видео</h2>
        <div class="video__wrapper">

            <?php foreach ($publications as $publication): ?>
                <a href="<?= Url::to(['site/view', 'postId' => $publication->id]) ?>" class="video__item">
                    <div class="video__image">
                        <img src="/uploads/previews/<?= Html::encode($publication->preview_path) ?>" alt="Превью видео" class="preview">
                    </div>
                    <p class="video__name"><?= Html::encode($publication->title) ?></p>
                    <p class="video__chanel"> Название канала: <?= Html::encode($publication->user->chanel_name) ?></p>
                    <p class="video__category">  <?= Html::encode($publication->category->name) ?></p>

                    <div class="video__likes-counter">
                        <span>likes: <?= count($publication->likes) ?></span>

                    </div>
                </a>
            <?php endforeach; ?>

        </div>
    </section>
</div>
