<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use common\models\Holiday;
use common\helpers\DateHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\search\GiftSearchHoliday */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Holidays';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
	<div class="col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table"></i></div>
				<h5><?= Html::encode($this->title) ?></h5>
				<div class="toolbar"><?= Html::a('Create Holiday', ['create'], ['class' => 'btn btn-success']) ?></div>
			</header>

			<div class="holiday-index">
			<?php Pjax::begin(); ?>
				<?= GridView::widget([
					'pager' => [
						'lastPageLabel' => '>>',
						'firstPageLabel' => '<<',
						'nextPageLabel' => '>',
						'prevPageLabel' => '<',
					],
					'dataProvider' => $dataProvider,
					'filterModel' => $searchModel,
					'columns' => [
						[
							'encodeLabel' => false,
							'label' => '<div class="column-label-grid">' . Yii::t('app', 'ID') . '</div>',
							'attribute' => 'id',
							'format' => 'raw',
							'contentOptions' => ['style' => 'width:50px;'],
						],
						'name',
						'strtotime',
						[
							'label' => 'strtotime()',
							'content' => function($data) {
								return $data->strtotime ? date('Y-m-d', strtotime($data->strtotime)) : null;
							},
						],
						['class' => 'yii\grid\ActionColumn',
						'contentOptions' => ['id' => 'action_column', 'style' => 'width:55px;'],
						'template' => '{update} {delete}',
						'visibleButtons' => [
							'update' => function ($model, $key, $index) {
								return !$model->is_birthday;
							},
							'delete' => function ($model, $key, $index) {
								return !$model->is_birthday;
							},
						],
					],
				],
			]);
			?>
			<?php Pjax::end(); ?>
		</div>
	</div>
</div>
</div>
