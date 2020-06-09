<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Category;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row product-form">
    <div class="col-lg-12">
        <div class="col-lg-6">
            <?php $form = ActiveForm::begin(['class' => 'form-horizontal']); ?>

                    <?= $form->field($model, 'id_category')->dropDownList(ArrayHelper::map(Category::find()->where(['is_active' => 1])->all(), 'id', 'name'), ['class' => 'form-control chzn-select', 'tabindex' => '2', 'prompt' => 'Select a category...'])->label('Category'); // ?>
    

                    <?= $form->field($model, 'name')->textInput(['id' => 'name']) ?>
         


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
    </div>    
    
    <?php ActiveForm::end(); ?>

</div>
