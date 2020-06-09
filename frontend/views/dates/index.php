<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\DatesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Dates for receiving gifts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
	<div class="sub_menu">
		<h1 class="sub_menu__h1"><?php echo Yii::t('app', 'Dates for receiving gifts for ') ?>
			<?php echo Html::a($giftReceiver->getName(), ['gift-receiver/update', 'id' => $giftReceiver->id]) ?>
		</h1>
		<div class="sub_menu__buttons">
			<a title="<?php echo Yii::t('app', 'Create Gift Receiver') ?>" class="btn-icon btn-icon-circle-success fa-layers" href="<?php echo Url::to(['dates/create', 'idGiftReceiver' => $giftReceiver->id]) ?>">
				<i class="fas fa-circle"></i>
				<i class="fas fa-inverse fa-gift" data-fa-transform="shrink-6"></i>
				<i class="fas fa-circle" data-fa-transform="shrink-9 down-5"></i>
				<i class="fas fa-inverse fa-plus-circle" data-fa-transform="shrink-10 down-5"></i>
			</a>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<i class="fas fa-<?php echo \common\models\Gender::getFAIcon($giftReceiver->gender) ?> fa-fw"></i>
			<span>
				<?php if ($giftReceiver->is_approximate_age ): ?>
					<?php echo Yii::t('app', 'About {year} years', [
						'year' => $giftReceiver->getAgeRange()
					]); ?>
				<?php else: ?>
					<?php echo $giftReceiver->getAge(); ?>
				<?php endif; ?>
			</span>
			<a class="" href="mailto:<?= $giftReceiver->email; ?>"><i class="fas fa-at fa-lg fa-fw"></i> <?= $giftReceiver->email; ?></a>
			<a class="" href="tel:<?= $giftReceiver->phone; ?>"><i class="fas fa-phone fa-lg fa-fw"></i> <?= $giftReceiver->phone; ?></a>
			<p><?php echo $giftReceiver->describe ?></p>
		</div>
	</div>

</div>

<div class="container">
<?php Pjax::begin(['id' => 'dates__pjax']); ?>

<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'id' => 'dates',
		// 'filterModel' => $searchModel,
		'layout' => "{items}\n{pager}",
		'tableOptions' => [
			'class' => 'table'
		],
		'columns' => [
				[
					'attribute' => 'date',
					'content' => function($data) {
							return '&nbsp;' . DateTime::createFromFormat('!m', $data->date_m)->format('M') . ' ' . $data->date_d;
					},
				],
				[
					'attribute' => 'title',
					'content' => function($data) {
							return $data->holiday ? $data->holiday->name : $data->custom_holiday;
					},
				],
				[
					'attribute' => 'from',
					'headerOptions' => ['class' => 'text-right'],
					'contentOptions' => ['class' => 'text-right'],
					'content' => function($data) {
							return Yii::$app->formatter->asCurrency($data->gift->from);
					},
				],
				[
					'attribute' => 'to',
					'headerOptions' => ['class' => 'text-right'],
					'contentOptions' => ['class' => 'text-right'],
					'content' => function($data) {
							return Yii::$app->formatter->asCurrency($data->gift->to);
					},
				],
				[
					'attribute' => 'tags',
					'content' => function($data) {
							return $data->gift ? implode(', ', \yii\helpers\ArrayHelper::getColumn($data->gift->tags, 'name')) : null;
					},
				],
				[
					'format' => 'raw',
					'contentOptions' => ['class' => 'text-center', 'style' => 'width:60px;'],
					'content' =>  function($data) {
						return Html::a('<i class="fas fa-pen-fancy"></i>', ['dates/update', 'id' => $data->id], [
							'class' => 'btn-icon btn-icon-success btn-icon-sm'
						]);
					}
				],
		],
]); ?>
<?php Pjax::end(); ?>
</div>
