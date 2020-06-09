<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\widgets\MaskedInput;
use yii\jui\DatePicker;
use yii\helpers\ArrayHelper;
use common\models\Gender;
use common\models\GiftReceiver;
use common\models\User;
use common\models\Country;
use common\helpers\DateHelper;
use common\helpers\Address;
use kartik\select2\Select2;
use common\models\Relation;

/* @var $this yii\web\View */
/* @var $model backend\models\GiftReceiver */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row col-lg-12">
    <?php $form = ActiveForm::begin(['class' => 'form-horizontal']); ?>
    <div class="col-lg-6">
                <?= $form->field($model, 'last_name')->textInput(['id' => 'last_name']) ?>
        
                <?= $form->field($model, 'first_name')->textInput(['id' => 'first_name']) ?>
        
                <?= $form->field($model, 'email')->input('email') ?>

                <?=
                $form->field($model, 'phone')->widget(MaskedInput::className(), [
                    'mask' => '+9(999) 999-99-99',
                    'options' => [
                        'class' => 'form-control placeholder-style',
                        'id' => 'phone',
                        'placeholder' => ('Phone')
                    ],
                    'clientOptions' => [
                        'greedy' => false,
                        'clearIncomplete' => true
                    ]
                ]);
                ?>

    </div>
    <div class="col-lg-6">
		
        <div class="col-lg-3 col-md-6 col-xs-12">
			<?php echo $form->field($model, 'birthday_month')
				->dropDownList(DateHelper::getMonthList(), ['prompt' => Yii::t('app', 'Select month ...')]);  ?>
		</div>
		<div class="col-lg-3 col-md-6 col-xs-12">
			<?php echo $form->field($model, 'birthday_day')
				->dropDownList([], ['disabled' => true, 'prompt' => Yii::t('app', 'Select day ...')]);  ?>
		</div>

		<?php if ($model->is_approximate_age) {
			$model->approximateAge = $model->birthday_year;
			$model->birthday_year = null;
		} ?>
		<div class="col-lg-3 col-md-6 col-xs-12">
			<?php $years = range(1903, date('Y')); ?>
			<?php echo $form->field($model, 'birthday_year')
				->dropDownList(array_combine($years, $years), ['prompt' => Yii::t('app', 'Select year ...')])
				->label(Yii::t('app', 'Choose the year'));  ?>
		</div>

		<div class="col-lg-3 col-md-6 col-xs-12">
			<?php echo $form->field($model, 'approximateAge')
				->dropDownList(GiftReceiver::getApproximateAgeRange(), ['prompt' => Yii::t('app', '...')])
				->label(Yii::t('app', 'Approximate'));  ?>
		</div>
		
            <div class="col-lg-12">
                <?= $form->field($model, 'gender')->dropDownList(Gender::getList(), ['prompt' => 'Select a gender...']) ?>
				<?= $form->field($model, 'id_relation')->dropDownList(ArrayHelper::map(Relation::find()->all(), 'id', 'name'), ['prompt' => Yii::t('app', '...')]);  ?>
            </div>
            <div class="col-lg-12">
                <?php // $form->field($model, 'id_user')->dropDownList(ArrayHelper::map(User::find()->all(), 'id', 'username'), ['class' => 'form-control chzn-select', 'tabindex' => '2', 'prompt' => 'Select a user...'])->label('User') ?>
				<?php echo $form->field($model, 'id_user')->widget(Select2::classname(), [
					'data' => ArrayHelper::map(User::find()->all(), 'id', 'username'),
					'options' => ['class' => 'form-control chzn-select', 'tabindex' => '2', 'placeholder' => 'Select a user ...'],
					'pluginOptions' => [
						'allowClear' => true
					],
				])->label('User');?>
			</div>

            <div class="col-lg-12">
                <?= $form->field($model, 'is_active')->checkbox(['checked ' => true, 'class' => 'make-switch', 'data-size' => 'mini']) ?>
            </div>
    </div>
	
	<fieldset class="col-lg-12">
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

    <div class="col-lg-12">
            <div class="form-group">
                <div class="float-left">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
                </div>
                <div>
                    <?= Html::a('Back', Yii::$app->request->referrer, ['class' => 'btn btn-default']); ?>
                </div>
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


