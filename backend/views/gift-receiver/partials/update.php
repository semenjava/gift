<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\GiftReceiver */

$this->title = 'Update Gift Receiver: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Gift Receivers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <header>
                <div class="icons"><i class="fa fa-th-large"></i></div>
                <h5><?= Html::encode($this->title) ?></h5>
            </header>
            <div class="body gift-receiver-update">
                <ul class="nav nav-tabs">
                    <li class="<?=$class['panel1']?$class['panel1']:''?>"><a data-toggle="tab" href="#panel1" onclick="panel1()">Gift</a></li>
                    <li class="<?=$class['panel2']?$class['panel2']:''?>"><a data-toggle="tab" href="#panel2" >Dates</a></li>
                </ul>
                <div class="tab-content" id="tab-content">
                    <?=
                    $this->render('update/_form', [
                        'model' => $model,
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'searchModelDates' => $searchModelDates,
                        'dataProviderDates' => $dataProviderDates,
                        'id_date' => $id_date,
                        'class' => $class
                    ])
                    ?>
                </div>
            </div>
        </div>
        <!--END SELECT-->
    </div>
</div>
<script>
function panel1(){
    setTimeout(function () {
        $('.chosen-container').css('width','100%');
        Metis.formGeneral();
    }, 100);
}
</script>
