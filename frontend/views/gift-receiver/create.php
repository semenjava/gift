<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\GiftReceiver */

$this->title = Yii::t('app', 'Here\'s who will receive the gift');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Gift Receivers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
	<div class="sub_menu">
		<h1 class="sub_menu__h1"><?= Html::encode($this->title) ?></h1>
	</div>

	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>
