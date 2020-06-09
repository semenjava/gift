<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\search\ParcelSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="parcel-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_shipping') ?>

    <?= $form->field($model, 'id_dates') ?>

    <?= $form->field($model, 'id_carrier') ?>

    <?= $form->field($model, 'id_shipping_method') ?>

    <?php // echo $form->field($model, 'tracking_id') ?>

    <?php // echo $form->field($model, 'date_send') ?>

    <?php // echo $form->field($model, 'id_gift') ?>

    <?php // echo $form->field($model, 'describe') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
