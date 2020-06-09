<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\DateHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Holiday */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row holiday-form">
        <?php $form = ActiveForm::begin(['class' => 'form-horizontal']); ?>
        <div class="col-lg-6">
              <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
              <?= $form->field($model, 'strtotime')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-lg-12">
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Back', Yii::$app->request->referrer, ['class' => 'btn btn-default']); ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        Metis.formGeneral();
    });
</script>
