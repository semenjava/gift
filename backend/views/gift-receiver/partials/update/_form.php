<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\GiftReceiver */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row gift-receiver-form">
    <div id="panel1" class="tab-pane hide <?=$class['panel1']?'in '.$class['panel1']:''?>">
        <?=
        $this->render('panel1', [
            'model' => $model,
        ])
        ?>
    </div>
    <div id="panel2" class="tab-pane hide <?=$class['panel2']?'in '.$class['panel2']:''?>">
        <?=$this->render('panel2', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchModelDates' => $searchModelDates,
            'dataProviderDates' => $dataProviderDates,
            'id_date' => $id_date
        ]);
        ?>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
//        Metis.formGeneral();
        $('#giftreceiver-birthday').addClass('form-control');

         $("#myTab a").click(function(e){
            e.preventDefault();
            $(this).tab('show');
        });
    });
</script>
