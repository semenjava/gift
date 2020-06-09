<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\GiftReceiver */

$this->title = 'Create Gift Receiver';
$this->params['breadcrumbs'][] = ['label' => 'Gift Receivers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <header>
                <div class="icons"><i class="fa fa-th-large"></i></div>
                <h5><?= Html::encode($this->title) ?></h5>
            </header>
            <div class="body gift-receiver-create" id="div-2">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#panel1">Gift</a></li>
                    <li class="disabled"><a  href="javascript:void(0);">Dates</a></li>
                </ul>
                <div class="tab-content">
                    <?=
                    $this->render('_form', [
                        'model' => $model
                    ])
                    ?>
                </div>
            </div>
        </div>
        <!--END SELECT-->
    </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {
        Metis.formGeneral();
});
</script>
