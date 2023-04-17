<?php

/** @var yii\web\View $this */
/** @var array $categories */
/** @var app\models\forms\UploadForm $model */

use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use app\Assets\UploadAsset;

$user = $this->context->user;
$this->title = Yii::$app->name . ' | Загрузка видео';

UploadAsset::register($this);

?>
<?php $form = ActiveForm::begin([
    'action' => Url::to(['site/upload']),
    'options' => [
        'novalidate' => true,
        'autocomplete' => 'off'
    ],
    'fieldConfig' => [
        'options' => ['class' => 'mb-3'],
    ],
]); ?>

    <?= $form->field($model, 'title')->textInput() ?>
    <?= $form->field($model, 'desc')->textInput() ?>
    <?= $form->field($model, 'video')->fileInput() ?>
    <?= $form->field($model, 'preview')->fileInput() ?>
    <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map($categories, 'id', 'name')) ?>
    <?= $form->field($model, 'user_id', ['template' => '{input}'])->input('hidden', ['value' => $user->id]) ?>

    <?= Html::submitButton('Отправить') ?>

<?php ActiveForm::end(); ?>
