<?php

namespace common\models;

use Yii;

class Gender {

	const MALE        = 1;
	const WOMEN       = 2;
	const GAY         = 3;
	const LESBIAN     = 4;
	const VAGUE_SEX   = 5;
	const TRANSGENDER = 6;

	public static function getList() {
		return [
			self::MALE => Yii::t('app', 'Male'),
			self::WOMEN => Yii::t('app', 'Women'),
			self::GAY => Yii::t('app', 'Gay'),
			self::LESBIAN => Yii::t('app', 'Lesbian'),
			self::VAGUE_SEX => Yii::t('app', 'Vague sex'),
			self::TRANSGENDER => Yii::t('app', 'Transgender'),
		];
	}

	public static function getFAIcon($gender) {
		switch ($gender) {
			case self::MALE:
				return 'mars';
			case self::WOMEN:
				return 'venus';
			case self::GAY:
				return 'mars-double';
			case self::LESBIAN:
				return 'venus-double';
			case self::VAGUE_SEX:
				return 'genderless';
			case self::TRANSGENDER:
				return 'transgender-alt';
			default:
				return 'helicopter';
		}
	}

}
