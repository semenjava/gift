<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\GiftReceiver */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Gift Receivers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gift-receiver-view" id="view">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><?= Html::encode($this->title) ?></h4>
        </div>
        <div class="modal-body">
            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'last_name',
                    'first_name',
                    'email:email',
                    'phone',
                    'birthday',
                    'gender',
                    'id_user',
                    'is_active',
                ],
            ])
            ?>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
