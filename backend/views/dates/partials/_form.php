<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;
use common\models\Holiday;
use common\helpers\StringHelper;
use common\models\Dates;
use common\models\Gift;
use kartik\select2\Select2;
use common\models\GiftTag;
use yii\web\JsExpression;

$holidays = Holiday::find()->asArray()->all();
for ($i = 0; $i < count($holidays); $i++) {
	if ($holidays[$i]['strtotime']) {
		$time = strtotime($holidays[$i]['strtotime']);
		$holidays[$i]['m'] = date('n', $time);
		$holidays[$i]['d'] = date('j', $time);
	}

	if ($holidays[$i]['is_birthday']) {
		$holidays[$i]['m'] = $dates->giftReceiver->birthday_month;
		$holidays[$i]['d'] = $dates->giftReceiver->birthday_day;
	}
}


//$describe_data = GiftTag::find()->select('name')->groupBy('name')->asArray()->all();


/* @var $this yii\web\View */
/* @var $model common\models\Dates */
/* @var $form yii\widgets\ActiveForm */

?>

<?php $form = ActiveForm::begin(['class' => 'form-horizontal', 'id' => 'dates-form', 'enableAjaxValidation' => true]); ?>
<div class="modal-body">
    <div id="input-content">
        <div class="col-mc-12 dates-select">
			<div class="col-lg-6">
				<?php echo $form->field($dates, 'id_holiday')
					->dropDownList(ArrayHelper::map($holidays, 'id', 'name'), [
						'prompt' => Yii::t('app', 'Select a date...')
					])
					->label(Yii::t('app', 'Select Holiday or ...')); ?>
			</div>

			<div class="col-lg-6">
				<?php echo $form->field($dates, 'custom_holiday')
					->textInput()
					->label(Yii::t('app', '... enter custom')); ?>
			</div>
			
			<div class="clearfix"></div>
            <div class="col-lg-6">
                <?php echo $form->field($dates, 'date_m')
					->dropDownList([
						1 => 'January',
						2 => 'February',
						3 => 'March',
						4 => 'April',
						5 => 'May',
						6 => 'June',
						7 => 'July',
						8 => 'August',
						9 => 'September',
						10 => 'October',
						11 => 'November',
						12 => 'December',
					], ['prompt' => Yii::t('app', 'Select month ...')])
					->label(Yii::t('app', 'Month')); ?>
            </div>
            <div class="col-lg-6">
                <?php echo $form->field($dates, 'date_d')
					->dropDownList([], ['disabled' => true, 'prompt' => Yii::t('app', 'Select day ...')])
					->label(Yii::t('app', 'Day'));  ?>
            </div>
            <?php /* <div class="form-group col-lg-4">
                <?=
                $form->field($dates, 'date_y')->dropDownList(Dates::getYear(), ['class' => 'form-control chzn-select', 'tabindex' => '2', 'prompt' => 'Select a year...', 'onchange' => 'date_change.date_y(this)', 'data-url' => Url::toRoute('dates/get-day')]);
                ?>
            </div>*/ ?>
        </div>
        <div class="clearfix"></div>
        <div class="col-mc-12">
			<div class="col-lg-6">
				<?= $form->field($gift, 'from')->textInput(['type' => 'number',  'min' => 0]) ?>
			</div>
			<div class="col-lg-6">
				<?= $form->field($gift, 'to')->textInput(['type' => 'number',  'min' => 0]) ?>
			</div>
        </div>

        <div class="col-lg-12">
                <?= $form->field($gift, 'newTags')->widget(Select2::classname(), [
                    'options' => [
                        'value' => ArrayHelper::getColumn($gift->tags, 'name'),
                        'placeholder' => Yii::t('app', 'add a tag ...'),
                        'multiple' => true
                    ],
                     'maintainOrder' => true,
                    'pluginOptions' => [
                        'tags' => true,
                        'allowClear' => true,
                        'minimumInputLength' => 3,
                        'language' => [
                            'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                        ],
                        'ajax' => [
                            'url' => Url::toRoute('dates/get-tag'),
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {name:params.term}; }')
                        ],
                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                        'templateResult' => new JsExpression('function(r) {return r.name ? r.name : r.text; }'),
                        'templateSelection' => new JsExpression('function(r) {return r.name ? r.name : r.text; }'),
                    ],
                ]) ?>
        </div>
    </div>
</div>
<div class="modal-footer">
    <div class="col-lg-12" >
        <div class="float-left">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>
        <div>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

<?php $this->registerJs(
	"var dates = new Dates(); dates.initDayByMonth($('#dates-date_m'), $('#dates-date_d'), {$dates->date_d})",
	\yii\web\View::POS_END
); ?>
<?php $this->registerJs(
	'var notindexholidays = JSON.parse(\'' . json_encode($holidays) . '\');
	var holidays = {};
	for (var i = 0; i < notindexholidays.length; i++) {
		holidays[notindexholidays[i].id] = notindexholidays[i]
	}

	$("#dates-id_holiday").change(function(){
		$("#dates-custom_holiday").val("")

		var holiday = holidays[$(this).val()];
		$("#dates-date_m").val(holiday.m).trigger("change");
		$("#dates-date_d").val(holiday.d);

		if (parseInt(holiday.is_birthday)) {
			$("#dates-date_m, #dates-date_d").removeClass("disabled");
		} else {
			$("#dates-date_m, #dates-date_d").addClass("disabled");
		}
	})
	$("#dates-custom_holiday").change(()=>{
		$("#dates-id_holiday").val("")
		$("#dates-date_m, #dates-date_d").removeClass("disabled");
	});
	
	$("#dates-date_m, #dates-date_d").change(()=>{
		if($(this).hasClass("disabled")) {
			return false;
		}
	});
	',
	\yii\web\View::POS_READY
); ?>
