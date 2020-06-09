<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Gift */
/* @var $form yii\widgets\ActiveForm */


?>
<?php $form = ActiveForm::begin(['class' => 'form-horizontal']); ?>
<div id="add-input">
    <div class="modal-body">
        <div id="input-content">
            <?= $form->field($model, 'hidden')->hiddenInput(['name' => 'id_dates', 'id' => 'id_dates', 'value' => $id_dates])->label(false); ?>
            <input type="hidden" name="id_gift_receiver" value="<?=$rec?>">

<!--            <div class="form-group">
                <div class="col-lg-12">
                    <?= $form->field($model, 'id_category')->dropDownList($category, ['class' => 'form-control chzn-select', 'tabindex' => '2', 'prompt' => 'Select a category...']) ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-12">
                    <?= $form->field($model, 'id_product')->dropDownList($products, ['class' => 'form-control chzn-select',  'tabindex' => 4, 'prompt' => 'Select a product...']); //'multiple' => true,?>
                </div>
            </div>        -->
                <div class="col-lg-6">
                    <?= $form->field($model, 'from')->textInput(['id' => 'from']) ?>
                </div>
                <div class="col-lg-6">
                    <?= $form->field($model, 'to')->textInput(['id' => 'to']) ?>
                </div>

                <div class="col-lg-12">
                    <?= $form->field($model, 'describe')->textarea(['maxlength' => true]) ?>
                </div>
        </div>
    </div>
    <div class="modal-footer">
        <div class="col-lg-12" >
            <div class="float-left">
                <?=Html::a('save', 'javascript:void(0);', ['data-id' => $model->id, 'onclick' => 'inputSave(this)', 'class' => 'btn btn-success'])?>
            </div>
            <div>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
