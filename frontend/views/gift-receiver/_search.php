<?php

use yii\widgets\ActiveForm;
use frontend\models\GiftReceiverSearch;

/* @var $this yii\web\View */
/* @var $model frontend\models\GiftReceiverSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="container">
	<?php $form = ActiveForm::begin([
		'id' => 'gift_receiver__search',
		'action' => ['index'],
		'method' => 'get',
		'options' => [
			'data-pjax' => 1
		],
	]); ?>
	<div class="row">
		<!-- <div class="col-md-6 col-xs-12">
			<?php /*echo $form->field($model, 'nextBirthdayInDay')->dropDownList([
				7 => Yii::t('app', 'Will have a birthday in 7 days'),
				30 => Yii::t('app', 'Will have a birthday in 30 days')
			], ['prompt' => Yii::t('app', 'Will have a birthday in ...')])->label(false)*/ ?>
		</div> -->
		<div class="col-md-6 col-xs-12">
			<?= $form->field($model, 'all', [
				'template' => '<div class="input-group">{input}<span class="input-group-btn"><button class="btn btn-success" type="submit" name="button"><i class="fas fa-search"></i></button></span></div>'
			]) ?>
		</div>
	</div>

	<?php ActiveForm::end(); ?>
</div>
<?php
$this->registerJs('
$("document").ready(function(){
	$("#giftreceiversearch-nextbirthdayinday").on("change", function() {
		$("#gift_receiver__search").submit();
	});

	$("#gift_receiver__search").on("submit", function() {
			$.pjax.reload({
				url: "' . Yii::$app->urlManager->createUrl(['gift-receiver']) . '",
				container: "#gift_receiver__pjax",
				data: $(this).serialize(),
			});
			return false;
	});
});
');
?>
