<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GiftReceiver */

$this->title = Yii::t('app', 'Сhange the {name}', [
	'name' => $model->getName(),
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Gift Receivers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="container">
	<div class="sub_menu">
		<h1 class="sub_menu__h1"><?= Html::encode($this->title) ?></h1>
		<div class="sub_menu__buttons">
			<a class="gift_receiver__add_date btn-icon btn-icon-circle-success fa-layers" href="<?php echo Yii::$app->urlManager->createUrl(['dates/index', 'idGiftReceiver' => $model->id]) ?>">
				<i class="fas fa-circle"></i>
				<i class="fas fa-inverse fa-gift" data-fa-transform="shrink-6"></i>
			</a>
		</div>
	</div>

	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>
