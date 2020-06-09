<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Parcel */

$this->title = 'Create Parcel';
$this->params['breadcrumbs'][] = ['label' => 'Parcels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parcel-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
