<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Dates */

$this->title = 'Update Dates: ' . $dates->id;
$this->params['breadcrumbs'][] = ['label' => 'Dates', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $dates->id, 'url' => ['view', 'id' => $dates->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div id="add-input">
    <div class="product-view" id="view">
        
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?= Html::encode($this->title) ?></h4>
            </div>

            <?= $this->render('_form', [
                'dates' => $dates,
                'gift' => $gift,
            ]) ?>
            
        </div>
    </div>
</div> 
