<?php

/** @var yii\web\View $this */
/** @var app\models\forms\SignupForm $model */

use app\assets\LoginAsset;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::$app->name . ' | Регистрация';
LoginAsset::register($this);

?>
<section class="registration">
    <div class="container">

        <?php $form = ActiveForm::begin([
            'action' => Url::to(['user/signup']),
            'options' => [
                'class' => 'form',
                'novalidate' => true,
                'autocomplete' => 'off'
            ],
            'fieldConfig' => [
                'options' => ['class' => 'mb-3'],
            ],
        ]); ?>

            <?= $form->field($model, 'login')->textInput() ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'password_repeat')->passwordInput() ?>
            <?= $form->field($model, 'chanel_name')->textInput() ?>
            <?= $form->field($model, 'chanel_avatar')->fileInput() ?>
            <?= $form->field($model, 'age')->input('number', ['min' => 14, 'max' => 100]) ?>

            <?= Html::submitButton('Отправить') ?>

        <?php ActiveForm::end(); ?>
    
    </div>
</section>

<script>

    const inputElement = document.querySelector('#signupform-avatar');
    const labelElement = document.querySelector('[for=signupform-avatar]');
    labelElement.style.color = '#000';

    inputElement.addEventListener('change', () => {
        if (inputElement.files.length) {
            labelElement.textContent = inputElement.files[0].name;
        }
    });

</script>
