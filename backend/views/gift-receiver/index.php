<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use common\models\Gender;
use common\models\User;
use backend\helpers\RenderHelper;
use backend\search\GiftReceiverSearch;
use common\models\Relation;

/* @var $this yii\web\View */
/* @var $searchModel backend\search\GiftReceiverSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$user = User::find();

$this->title = 'Gift Receivers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <header>
                <div class="icons"><i class="fa fa-table"></i></div>
                <h5><?= Html::encode($this->title) ?></h5>
                <div class="toolbar">
                    <?= Html::a('Create Gift Receiver', ['create'], ['class' => 'btn btn-success']) ?>
                </div>
            </header>
            <div class="gift-receiver-index">
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
                        'last_name',
                        'first_name',
                        'email:email',
                        'phone',
                        'birthday',
                        [
                            'encodeLabel' => false,
                            'label' => '<div class="column-label-grid">' . Yii::t('app', 'Gender') . '</div>',
                            'attribute' => 'gender',
                            'format' => 'raw',
                            'contentOptions' => ['style' => 'width:120px;'],
                            'content' => function($data) {
                                return $data->getGenderLabel();
                            },
                            'filter' => Gender::getList()
                        ],
						[
                            'encodeLabel' => false,
                            'label' => '<div class="column-label-grid">' . Yii::t('app', 'Gender') . '</div>',
                            'attribute' => 'gender',
                            'format' => 'raw',
                            'contentOptions' => ['style' => 'width:120px;'],
                            'content' => function($data) {
                                return $data->getGenderLabel();
                            },
                            'filter' => ArrayHelper::map(Relation::find()->all(), 'id', 'name')
                        ],			
                        [
                            'encodeLabel' => false,
                            'label' => '<div class="column-label-grid">' . Yii::t('app', 'User ID') . '</div>',
                            'attribute' => 'id_user',
                            'format' => 'raw',
                            'contentOptions' => ['style' => 'width:120px;'],
                            'content' => function($data) use ($user) {
                                $result = $user->where(['id' => $data->id_user])->one();
                                return $result->username;
                            },
                            'filter' => ArrayHelper::map(User::find()->all(), 'id', 'username')

                        ],
                        [
//                            'encodeLabel' => false,
//                            'label' => '<div class="column-label-grid">' . Yii::t('app', 'Active') . '</div>',
                            'attribute' => 'is_active',
                            'format' => 'raw',
                            'contentOptions' => ['style' => 'width:100px;'],
                            'content' => function($data) {
                                return RenderHelper::renderYesNo($data->is_active);
                            },
                            'filter' => RenderHelper::getYesNoOptions(),
                        ],
						[
							'class'			 => 'backend\components\ExtActionColumn',
							'options'		 => ['style' => 'width:70px;'],
							'contentOptions' => ['style' => 'text-align:center;'],
							'filter'		 => '
								<a class="btn btn-default btn-sm" href="' . yii\helpers\Url::toRoute('gift-receiver/index') . '" title="Clear Filter">
									<span class="glyphicon glyphicon-remove"></span> ' . Yii::t('app', 'Filter') . '
								</a>',
						]
					]
                ]);
                ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
