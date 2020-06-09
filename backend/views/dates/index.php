<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\search\DatesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dates';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dates-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>

    <p>
        <?= Html::a('Create Dates', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_gift_receiver',
            [
                'encodeLabel' => false,
                'label' => '<div class="column-label-grid">' . Yii::t('app', 'Month Day Year') . '</div>',
                'attribute' => 'mem_date',
                'format' => 'raw',
                'content' => function($data) {
                    $y = !empty($data->date_y)?'.'.$data->date_y:'';
                    $mem_date = $data->date_m.'.'.$data->date_d.$y;
                    return $mem_date;
                },
            ],
            'id_holiday',
            'custom_holiday',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
