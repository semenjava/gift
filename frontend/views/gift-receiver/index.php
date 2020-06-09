<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\GiftReceiverSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Those who will receive gifts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
	<div class="sub_menu">
		<h1 class="sub_menu__h1"><?= Html::encode($this->title) ?></h1>
		<div class="sub_menu__buttons">
			<a title="<?php echo Yii::t('app', 'Create Gift Receiver') ?>" class="btn-icon btn-icon-circle-success fa-layers" href="<?php echo Yii::$app->urlManager->createUrl(['gift-receiver/create']) ?>">
				<i class="fas fa-circle"></i>
				<i class="fas fa-inverse fa-user" data-fa-transform="shrink-6"></i>
				<i class="fas fa-circle" data-fa-transform="shrink-9 down-5"></i>
				<i class="fas fa-inverse fa-plus-circle" data-fa-transform="shrink-10 down-5"></i>
			</a>
		</div>
	</div>
</div>

<?php echo $this->render('_search', ['model' => $searchModel]); ?>

<?php Pjax::begin(['id' => 'gift_receiver__pjax']); ?>
<div class="container-fluid">
	<?php echo ListView::widget([
		'dataProvider' => $dataProvider,
		'itemView' => '_post',
		'options' => [
			'tag' => 'section',
			'id' => 'gift_receiver__section',
		],
		'layout' => "{summary}\n<div class=\"clearfix\">{items}</div>\n{pager}",
		'itemOptions' => [
			'tag' => 'article',
			'class' => 'gift_receiver',
		],
	]); ?>
</div>
<?php Pjax::end(); ?>
