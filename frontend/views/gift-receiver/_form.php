<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\widgets\MaskedInput;
use common\models\Gender;
use common\models\GiftReceiver;
use common\models\Country;
use common\models\Relation;
use common\helpers\DateHelper;
use common\helpers\Address;

/* @var $this yii\web\View */
/* @var $model common\models\GiftReceiver */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="gift-receiver-form">
	<?php $form = ActiveForm::begin(); ?>
	<fieldset>
		<legend><?php echo Yii::t('app', 'Years') ?></legend>
		<div class="row">
			<div class="col-lg-3 col-md-4 col-xs-12">
				<?= $form->field($model, 'last_name')->textInput(['autocomplete' => 'nope', 'maxlength' => true]) ?>
				<?= $form->field($model, 'email')->textInput(['autocomplete' => 'nope','maxlength' => true]) ?>
			</div>
			<div class="col-lg-3 col-md-4 col-xs-12">
				<?= $form->field($model, 'first_name')->textInput(['autocomplete' => 'nope', 'maxlength' => true]) ?>
				<?= $form->field($model, 'phone')->widget(MaskedInput::className(), [
					'mask' => '+9(999) 999-99-99',
					'options' => [
						'class' => 'form-control placeholder-style',
						'autocomplete' => 'nope',
					],
					'clientOptions' => [
						'greedy' => false,
						'clearIncomplete' => true
					]
				]); ?>
			</div>
			<div class="col-lg-2 col-md-4 col-xs-12">
				<?= $form->field($model, 'gender')->dropDownList(Gender::getList(), ['prompt' => '...']) ?>
				<?= $form->field($model, 'id_relation')->dropDownList(ArrayHelper::map(Relation::find()->all(), 'id', 'name'), ['prompt' => Yii::t('app', '...')]);  ?>
			</div>

			<div class="col-md-4 col-xs-12">
				<?php echo $form->field($model, 'describe')->textarea(['rows' => 5]) ?>
			</div>

		</div>
	</fieldset>
	<fieldset>
		<legend><?php echo Yii::t('app', 'Years') ?></legend>
		<div class="row">
			<?php if ($model->is_approximate_age) {
				$model->approximateAge = $model->birthday_year;
				$model->birthday_year = null;
			} ?>
			<div class="col-lg-3 col-md-6 col-xs-12">
				<?php $years = range(1903, date('Y')); ?>
				<?php echo $form->field($model, 'birthday_year')
					->dropDownList(array_combine($years, $years), ['prompt' => Yii::t('app', 'Select year ...')])
					->label(Yii::t('app', 'You can choose the year ...'));  ?>
			</div>
			<div class="col-lg-3 col-md-6 col-xs-12">
				<?php echo $form->field($model, 'approximateAge')
					->dropDownList(GiftReceiver::getApproximateAgeRange(), ['prompt' => Yii::t('app', '...')])
					->label(Yii::t('app', '... or Approximate age'));  ?>
			</div>

			<div class="col-lg-3 col-md-6 col-xs-12">
				<?php echo $form->field($model, 'birthday_month')
					->dropDownList(DateHelper::getMonthList(), ['prompt' => Yii::t('app', 'Select month ...')]); ?>
			</div>
			<div class="col-lg-3 col-md-6 col-xs-12">
				<?php echo $form->field($model, 'birthday_day')
					->dropDownList([], ['disabled' => true, 'prompt' => Yii::t('app', 'Select day ...')]);  ?>
			</div>
		</div>
	</fieldset>

	<fieldset>
		<legend><?php echo Yii::t('app', 'Address') ?></legend>

		<div class="row">
			<div class="col-lg-3 col-md-6 col-xs-12">
				<?php echo $form->field($model, 'address_type')
					->dropDownList(Address::getAddressTypes(), ['prompt' => Yii::t('app', 'Select')]);  ?>
			</div>
			<div class="col-lg-3 col-md-6 col-xs-12">
				<?php echo $form->field($model, 'id_country')
					->dropDownList(ArrayHelper::map(Country::find()->all(), 'id', 'name'), ['prompt' => Yii::t('app', 'Select')])
					->label(Yii::t('app', 'Country'));  ?>
			</div>
			<div class="col-lg-3 col-md-6 col-xs-12">
				<?php echo $form->field($model, 'zip')->textInput(['autocomplete' => 'nope','maxlength' => true]);  ?>
			</div>
			<div class="col-lg-3 col-md-6 col-xs-12">
				<?php echo $form->field($model, 'custom_state')->textInput(['autocomplete' => 'nope','maxlength' => true]);  ?>
			</div>
			<div class="col-lg-3 col-md-6 col-xs-12">
				<?php echo $form->field($model, 'city')->textInput(['autocomplete' => 'nope','maxlength' => true]);  ?>
			</div>
			<div class="col-lg-3 col-md-6 col-xs-12">
				<?php echo $form->field($model, 'address1')->textInput(['autocomplete' => 'nope','maxlength' => true]);  ?>
			</div>
			<div class="col-lg-3 col-md-6 col-xs-12">
				<?php echo $form->field($model, 'address2')->textInput(['autocomplete' => 'nope','maxlength' => true]);  ?>
			</div>
		</div>
	</fieldset>

	<div class="form-group">
		<?php echo Html::a('<i class="fas fa-chevron-left"></i> Back', Yii::$app->request->referrer, [
			'class' => 'btn btn-info'
		]); ?>
		<?= Html::submitButton(Yii::t('app', '<i class="fas fa-save"></i> Save'), ['class' => 'btn btn-success']) ?>

		<div class="pull-right">
			<?php echo Html::a('<i class="fas fa-trash-alt"></i>', ['delete', 'id' => $model->id], [
				'class' => 'btn btn-danger',
				'data' => [
					'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
					'method' => 'post',
				],
			]) ?>
		</div>
	</div>
	<?php ActiveForm::end(); ?>
</div>

<?php $this->registerJs(
	"var dates = new Dates(); dates.initDayByMonth($('#giftreceiver-birthday_month'), $('#giftreceiver-birthday_day'), {$model->birthday_day})",
	\yii\web\View::POS_END
); ?>
<?php $this->registerJs(
	'$("#giftreceiver-birthday_year").change(()=>{$("#giftreceiver-approximateage").val("")})
	 $("#giftreceiver-approximateage").change(()=>{$("#giftreceiver-birthday_year").val("")})',
	\yii\web\View::POS_READY
); ?>

<?php // TODO: replace this ?>
<?php $this->registerJs(
	'var countriesWithState = JSON.parse("' . json_encode(Address::getCountryWithState()) . '");

	var hasCurrentCountryState = countriesWithState.indexOf(parseInt($("select[id$=\'-id_country\']").val())) !== -1;
	$(".field-giftreceiver-custom_state").css({
		visibility : (hasCurrentCountryState ? "hidden" : "visible")
	})

	$("select[id$=\'-id_country\']").change(function() {
		var hasCurrentCountryState = countriesWithState.indexOf(parseInt($(this).val())) !== -1;
		$(".field-giftreceiver-custom_state").css({
			visibility : (hasCurrentCountryState ? "hidden" : "visible")
		})
	})',
	\yii\web\View::POS_READY
); ?>
