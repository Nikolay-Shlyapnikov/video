<?php

/** @var yii\web\View $this */
/** @var app\models\Category[] $categories */

use yii\helpers\Html;
use yii\helpers\Url;

$category = Yii::$app->request->get('category');
$filter = Yii::$app->request->get('filter');
$subscrubers = Yii::$app->request->get('subscriber');
$user = $this->context->user;

?>
<section class="sidebar">

    <h2 class="sidebar__title">Категории</h2>
    <ul class="sidebar__list">
        <li class="sidebar__item<?= !$category ? ' active' : '' ?>">
            <a href="<?= Url::to(['site/index', 'filter' => $filter]) ?>">Все</a>
        </li>

        <?php foreach ($categories as $category_item) : ?>
            <li class="sidebar__item<?= intval($category) === $category_item->id ? ' active' : '' ?>">
                <a href="<?= Url::to(['site/index', 'category' => $category_item->id, 'filter' => $filter]) ?>"><?= Html::encode($category_item->name) ?></a>
            </li>

        <?php endforeach; ?>
      
    </ul>

    <h3>Сортировка</h3>
    <ul class="sidebar__list">
        <li class="sidebar__item <?= !$filter ? ' active' : '' ?>">
            <a href="<?= Url::to(['site/index', 'category' => $category]) ?>">Без фильтров</a>
        </li>
        <li class="sidebar__item <?= $filter === 'likes' ? ' active' : '' ?>">
            <a href="<?= Url::to(['site/index', 'category' => $category, 'filter' => 'likes']) ?>">По лайкам</a>
        </li>
        <li class="sidebar__item <?= $filter === 'new' ? ' active' : '' ?>">
            <a href="<?= Url::to(['site/index', 'category' => $category, 'filter' => 'new']) ?>">Сначала новые</a>
        </li>
        <li class="sidebar__item <?= $filter === 'old' ? ' active' : '' ?>">
            <a href="<?= Url::to(['site/index', 'category' => $category, 'filter' => 'old']) ?>">Сначала старые</a>
        </li>
    </ul>
   
    <?php
    if($user){
        echo '<h3>Подписки</h3> 
                <ul class="sidebar__list">';
        $link = mysqli_connect("localhost", "root", "", "wt-video-hosting");
        $arraySubscribtion = mysqli_query($link, "SELECT `user_id` FROM `subscription` WHERE `subscriber_id` = $user->id");
        while ($subscribtion_id = mysqli_fetch_array($arraySubscribtion)) {
            $id = $subscribtion_id['user_id'];
            $chanel_name;
            $chanel_name_arr = mysqli_query($link, "SELECT `chanel_name` FROM `user` WHERE `id` = $id");
            while ($subscribtion_name = mysqli_fetch_array($chanel_name_arr)) {
                $chanel_name = $subscribtion_name['chanel_name'];
            }
            echo '<li class="sidebar__item">
                      <a href="profile/' . $id  . '">' .  $chanel_name . '</a>
                  </li>';
        }
        echo '</ul>';
    }
    ?>
</section>