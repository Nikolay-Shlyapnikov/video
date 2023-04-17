<?php

/** @var yii\web\View $this */
/** @var app\models\forms\LoginForm $model */

use app\assets\LoginAsset;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\Alert;

$this->title = Yii::$app->name . ' | Вход';

LoginAsset::register($this);

?>
<?= Alert::widget() ?>
<div class="container">
    <?php $form = ActiveForm::begin([
        'action' => Url::to(['user/login']),
        'options' => [
            'class' => 'form',
            'novalidate' => true,
            'autocomplete' => 'off',
        ],
        'fieldConfig' => [
            'options' => ['class' => 'mb-3'],
        ],
    ]); ?>
    
        <?= $form->field($model, 'login')->textInput() ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
    
        <?= Html::submitButton('Отправить') ?>
    
    <?php ActiveForm::end(); ?>
</div>
