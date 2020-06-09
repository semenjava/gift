<div class="media">
	<div class="media-left media-middle">
	</div>
	<div class="media-body">
		<div class="gift_receiver__name"><?= $model->last_name;?></div>
		<div class="gift_receiver__name"><?= $model->first_name;?></div>
	</div>
	<div class="media-right">
		<a class="gift_receiver__update btn-icon btn-icon-success btn-icon-sm" href="<?php echo Yii::$app->urlManager->createUrl(['gift-receiver/update', 'id' => $model->id]) ?>">
			<i class="fas fa-pen-fancy"></i>
		</a>
	</div>
</div>

<hr>

<div class="gift_receiver__b clearfix">
	<div class="gift_receiver__b_left">
		<?php if ($model->nearestDate): ?>
			<div class="gift_receiver__birthdate">
				<span class="gift_receiver__birthmonth"><?php echo date('M', mktime(0, 0, 0, $model->nearestDate->date_m, 1));?></span>
				<span class="gift_receiver__birthday"><?php echo $model->nearestDate->date_d; ?></span>
			</div>
		<?php endif; ?>
	</div>
	<div class="gift_receiver__b_right">
		<a class="gift_receiver__add_date btn-icon btn-icon-circle-success fa-layers" href="<?php echo Yii::$app->urlManager->createUrl(['dates/index', 'idGiftReceiver' => $model->id]) ?>">
			<i class="fas fa-circle"></i>
			<i class="fas fa-inverse fa-gift" data-fa-transform="shrink-6"></i>
			<!-- <i class="fas fa-circle" data-fa-transform="shrink-9 down-5"></i>
			<i class="fas fa-inverse fa-plus-circle" data-fa-transform="shrink-10 down-5"></i> -->
		</a>
	</div>
</div>
<hr>

<a class="gift_receiver__contact" href="mailto:<?= $model->email; ?>"><i class="fas fa-at fa-lg fa-fw"></i> <?= $model->email; ?></a>
<a class="gift_receiver__contact" href="tel:<?= $model->phone; ?>"><i class="fas fa-phone fa-lg fa-fw"></i> <?= $model->phone; ?></a>
