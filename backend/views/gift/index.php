<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use backend\search\GiftSearch;
use common\models\Dates;
use common\models\Holiday;

if(!empty($date_id)) {
    $dates = Dates::find()->where(['id' => $date_id])->one();
    $dateDasc = ArrayHelper::map(Holiday::find()->all(), 'id', 'name');
}

/* @var $this yii\web\View */
/* @var $searchModel backend\search\GiftSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gifts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gift-index" id="input-info">
    <div class="col-lg-12">
        <div class="float-right p-xs">
            <?=Html::a('+', 'javascript:void(0);', ['onclick' => 'addInput(this);', 'data-id' => $date_id, 'data-rec' => $rec, 'data-href' => Url::toRoute('gift/create'), 'class' => 'btn btn-success']); ?>
        </div>
    </div>
    <div class="col-lg-12" >
    <?php Pjax::begin(['id'=>'addressOptions']); ?>
    <?php if(!empty($date_id)) :?>
    <span>Dates: <?=!empty($dateDasc[$dates->id_holiday])?$dateDasc[$dates->id_holiday]:$dates->custom_holiday?></span>
    <?php endif;?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'options' => [
//            'class' => 'style-table',
            'id' => 'table-gift'
        ],
        'columns' => [
//            'id_dates',
//            [
//                'encodeLabel' => false,
//                'label' => '<div class="column-label-grid">' . Yii::t('app', 'Category') . '</div>',
//                'attribute' => 'id_category',
//                'format' => 'raw',
//                'content' => function($data) use ($category) {
//                    return !empty($category[$data->id_category])?$category[$data->id_category]:null;
//                },
//                'filter' => Html::dropDownList('GiftSearch[id_category]', 'id_category', GiftSearch::dropDownListCategory(), ['class' => 'form-control chzn-select', 'tabindex' => '2'])
//            ],
//            [
//                'encodeLabel' => false,
//                'label' => '<div class="column-label-grid">' . Yii::t('app', 'Product') . '</div>',
//                'attribute' => 'id_product',
//                'format' => 'raw',
//                'contentOptions' => ['style' => 'width:120px;'],
//                'content' => function($data) use ($products) {
//                    return !empty($products[$data->id_product])?$products[$data->id_product]:null;
//                },
//                'filter' => Html::dropDownList('GiftSearch[id_product]', 'id_product', GiftSearch::dropDownListProducts(), ['class' => 'form-control chzn-select', 'tabindex' => '2'])
//            ],
            'from',
            'to',
//            'describe',

            [   'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'width:70px;'],
                'template' => '{update}{delete}',
                    'buttons' => [
                        'update' => function ($id, $model) use ($rec){
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', 'javascript:void(0);', ['data-href' => Url::toRoute('gift/update'), 'data-id' => $id, 'data-rec' => $rec, 'onclick' => 'inputUpdate(this)', 'class' => 'btn btn-xs'], [

                                ]);
                        },
                        'delete' => function ($id, $model) use ($rec){
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', 'javascript:void(0);', ['data-href' => Url::toRoute('gift/delete').'?id='.$id.'&rec='.$rec, 'data-id' => $id, 'data-rec' => $rec, 'onclick' => 'inputDelete(this)',
                                    'class' => 'btn btn-xs',
                                    'data-confirm' => 'Are you sure you want to delete this item?',
                                    'data-method' => 'post'
                                ]);
                        }
                    ],
                    'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action === 'update') {
                            $url = $model->id;
                            return $url;
                        }
                        if ($action === 'delete') {
                            $id = $model->id;
                            $url = Url::toRoute('dates/delete').'?id='.$model->id;
                            return $id;
                        }
                    }

            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
    </div>
</div>
