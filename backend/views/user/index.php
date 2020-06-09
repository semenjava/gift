<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\User;
use backend\search\UserSearch;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$userStatus = User::getStatusAttribute();

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <header>
                <div class="icons"><i class="fa fa-table"></i></div>
                <h5><?= Html::encode($this->title) ?></h5>
                <div class="toolbar">
                <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
                </div>
            </header>
            <div class="user-index">
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
                        'username',
//                        'auth_key',
//                        'password_hash',
//                        'password_reset_token',
                        'email:email',
                        [
                            'encodeLabel' => false,
                            'label' => '<div class="column-label-grid">' . Yii::t('app', 'Status') . '</div>',
                            'attribute' => 'status',
                            'format' => 'raw',
                            'contentOptions' => ['style' => 'width:130px;'],
                            'content' => function($data) use ($userStatus) {
                                return $userStatus[$data->status];
                            },
                            'filter' => Html::dropDownList('UserSearch[status]', 'status', UserSearch::dropDownListStatus(), ['class' => 'form-control chzn-select', 'tabindex' => '2',])
                        ],
                        //'created_at',
                        //'updated_at',
                        ['class' => 'yii\grid\ActionColumn', 'contentOptions' => ['style' => 'width:70px;']],
                    ],
                ]);
                ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
