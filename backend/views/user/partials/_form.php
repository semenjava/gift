<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row user-form">
    <div class="col-lg-12">
        <div class="col-lg-6">
            <?php $form = ActiveForm::begin(['class' => 'form-horizontal']); ?>

                    <?= $form->field($model, 'username')->textInput(['id' => 'username']) ?>
  
            <?php //echo $form->field($model, 'auth_key')->textInput(['id' => 'auth_key']) ?>

                    <?php echo $form->field($model, 'newPassword')->textInput(['id' => 'newPassword'])->label('Password') ?>
            
            
                    <?= $form->field($model, 'email')->input('email'); ?>
                
            
                    <?= $form->field($model, 'status')->dropDownList(User::getStatusAttribute()) ?>
                
        </div>
        <div class="col-lg-12">
            <div class="form-group">
                <div class="float-left">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
                </div>
                <div>
                    <?= Html::a('Back', Yii::$app->request->referrer, ['class' => 'btn btn-default']); ?>
                </div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
