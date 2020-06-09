<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Gift */

$this->title = 'Update Gift: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Gifts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div id="add-input">
    <div class="gift-update">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?= Html::encode($this->title) ?></h4>
            </div>

            <?=
            $this->render('_form', [
                'model' => $model,
                'category' =>$category,
                'products' => $products,
                'id_dates' => $id_dates,
                'rec' => $rec
            ])
            ?>
        </div>
    </div>
</div>
