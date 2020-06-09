<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use common\models\Shipping;
use common\models\Dates;
use common\models\Holiday;
use common\models\Carrier;
use common\models\ShippingMethod;
use common\models\Gift;

/* @var $this yii\web\View */
/* @var $searchModel backend\search\ParcelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$shipping = ArrayHelper::map(Shipping::find()->all(), 'id', 'zip');
$dates = Dates::find();
$date_desk = ArrayHelper::map(Holiday::find()->all(), 'id', 'name');
$carrier = ArrayHelper::map(Carrier::find()->all(), 'id', 'name');
$shipping_method = ArrayHelper::map(ShippingMethod::find()->all(), 'id', 'name');

$this->title = 'Parcels';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <header>
                <div class="icons"><i class="fa fa-table"></i></div>
                <h5><?= Html::encode($this->title) ?></h5>
                <div class="toolbar">
                    <?php // echo Html::a('Create Parcel', ['create'], ['class' => 'btn btn-success'])  ?>
                </div>
            </header>
            <div class="parcel-index">
                <?php Pjax::begin(); ?>
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
                <?=
                GridView::widget([
                    'pager' => [
                        'lastPageLabel' => '>>',
                        'firstPageLabel' => '<<',
                        'nextPageLabel' => '>',
                        'prevPageLabel' => '<',
                    ],
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'options' => [
                        'class' => 'style-table',
                     ],
                    'columns' => [
//                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'encodeLabel' => false,
                            'label' => '<div class="column-label-grid">' . Yii::t('app', 'ID') . '</div>',
                            'attribute' => 'id',
                            'format' => 'raw',
                            'contentOptions' => ['style' => 'width:50px;'],
                        ],
                        [
                            'encodeLabel' => false,
                            'label' => '<div class="column-label-grid">' . Yii::t('app', 'Shipping') . '</div>',
                            'attribute' => 'id_shipping',
                            'format' => 'raw',
                            'content' => function($data) use ($shipping) {
                                return $shipping[$data->id_shipping];
                            },
                            'filter' => Html::dropDownList('ParcelSearch[id_shipping]', 'id_shipping', $shipping, ['class' => 'form-control chzn-select', 'tabindex' => '2', 'prompt' => 'Select a shipping...'])
                        ],
                        [
                            'encodeLabel' => false,
                            'label' => '<div class="column-label-grid">' . Yii::t('app', 'Dates') . '</div>',
                            'attribute' => 'id_dates',
                            'format' => 'raw',
                            'content' => function($data) use ($dates, $date_desk) {
                                $result = $dates->where(['id' => $data->id_dates])->one();
                                if(!empty($result->describe)) {
                                    return $result->describe;
                                } else {
                                    $date_desk[$result->id_holiday];
                                }
                            },
                            'filter' => Html::dropDownList('ParcelSearch[id_dates]', 'id_dates', $date_desk, ['class' => 'form-control chzn-select', 'tabindex' => '2', 'prompt' => 'Select a dates...'])
                        ],
                        [
                            'encodeLabel' => false,
                            'label' => '<div class="column-label-grid">' . Yii::t('app', 'Carrier') . '</div>',
                            'attribute' => 'id_carrier',
                            'format' => 'raw',
                            'content' => function($data) use ($carrier) {
                                return $carrier[$data->id_carrier];
                            },
                            'filter' => Html::dropDownList('ParcelSearch[id_carrier]', 'id_carrier', $carrier, ['class' => 'form-control chzn-select', 'tabindex' => '2', 'prompt' => 'Select a carrier...'])
                        ],
                        [
                            'encodeLabel' => false,
                            'label' => '<div class="column-label-grid">' . Yii::t('app', 'Shipping Method') . '</div>',
                            'attribute' => 'id_shipping_method',
                            'format' => 'raw',
                            'content' => function($data) use ($shipping_method) {
                                return $shipping_method[$data->id_shipping_method];
                            },
                            'filter' => Html::dropDownList('ParcelSearch[id_shipping_method]', 'id_shipping_method', $shipping_method, ['class' => 'form-control chzn-select', 'tabindex' => '2', 'prompt' => 'Select a shipping method...'])
                        ],
                        //'tracking_id',
                        'date_send',
                        'id_gift',
                        //'describe',
                        ['class' => 'yii\grid\ActionColumn', 'contentOptions' => ['style' => 'width:70px;']],
                    ],
                ]);
                ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
