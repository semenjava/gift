<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Parcel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="parcel-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_shipping')->textInput() ?>

    <?= $form->field($model, 'id_dates')->textInput() ?>

    <?= $form->field($model, 'id_carrier')->textInput() ?>

    <?= $form->field($model, 'id_shipping_method')->textInput() ?>

    <?= $form->field($model, 'tracking_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_send')->textInput() ?>

    <?= $form->field($model, 'id_gift')->textInput() ?>

    <?= $form->field($model, 'describe')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
