<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <link href="https://fonts.googleapis.com/css?family=Comfortaa:300,400,700" rel="stylesheet">
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<header>
	<div class="container-fluid">
		<a href="<?php echo Url::base(true); ?>"><i class="btn-icon-sm fas fa-gift"></i> <span><?php echo Yii::t('app', 'Go to receivers') ?></span></a>

		<div class="pull-right">
			<span>Signed in as <b><?php echo Yii::$app->user->identity->username ?></b></span>
			<a class="btn-icon btn-icon-sm btn-icon-circle-success fa-layers" title="logout" href="<?php echo Yii::$app->urlManager->createUrl(['site/logout']) ?>">
				<i class="fas fa-circle"></i>
				<i class="fas fa-sign-out-alt fa-inverse" data-fa-transform="shrink-7"></i>
			</a>
		</div>
	</div>
</header>

	<?php /*echo Breadcrumbs::widget([
		'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
	]) */?>
	<?= Alert::widget() ?>
	<?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
