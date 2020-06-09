<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Relation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row relation-form">
    <div class="col-lg-12">
        <?php $form = ActiveForm::begin(['class' => 'form-horizontal']); ?>
        <div class="col-lg-6">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>             

                    <?= $form->field($model, 'is_active')->checkbox(['checked ' => true, 'class' => 'make-switch', 'data-size' => 'mini']) ?>
        </div>    
        
        <div class="col-lg-12">
            <div class="form-group">
                <div class="float-left">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
                </div>
                <div >
                    <?= Html::a('Back', Yii::$app->request->referrer, ['class' => 'btn btn-default']); ?>
                </div>
            </div>
        </div>    
        <?php ActiveForm::end(); ?>
    </div>    
</div>
