<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Dates */

$this->title = Yii::t('app', 'Create Dates');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Dates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
	<div class="sub_menu">
		<h1 class="sub_menu__h1"><?= Html::encode($this->title) ?></h1>
	</div>
	<?= $this->render('_form', [
		'dates' => $dates,
		'gift' => $gift,
	]) ?>
</div>
