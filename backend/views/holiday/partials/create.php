<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Holiday */

$this->title = 'Create Holiday';
$this->params['breadcrumbs'][] = ['label' => 'Holidays', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <header>
                <div class="icons"><i class="fa fa-th-large"></i></div>
                <h5><?= Html::encode($this->title) ?></h5>
            </header>
			<div class="holiday-create body" id="div-2">

				<?=
				$this->render('_form', [
					'model' => $model,
				])
				?>

			</div>
		</div>
        <!--END SELECT-->
    </div>
</div>

