<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\search\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <header>
                <div class="icons"><i class="fa fa-table"></i></div>
                <h5><?= Html::encode($this->title) ?></h5>
                <div class="toolbar">
                    <?= Html::a('Create Category', ['create'], ['class' => 'btn btn-success']) ?>
                </div>
            </header>
            <div class="category-index">
                <?php Pjax::begin(); ?>
                <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>
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
                        'name',
                        [
                            'encodeLabel' => false,
                            'label' => '<div class="column-label-grid">' . Yii::t('app', 'Active') . '</div>',
                            'attribute' => 'is_active',
                            'format' => 'raw',
                            'contentOptions' => ['style' => 'width:100px;'],
                            'content' => function($data) {
                                return ($data->is_active > 0) ? 'Yes' : 'No';
                            },
                            'filter' => Html::dropDownList('CategorySearch[is_active]', 'is_active', Yii::$app->params['active_input'], ['class' => 'form-control chzn-select', 'tabindex' => '2'])
                        ],
                        ['class' => 'yii\grid\ActionColumn', 'contentOptions' => ['id' => 'action_column', 'style' => 'width:70px;']],
                    ],
                ]);
                ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>            
