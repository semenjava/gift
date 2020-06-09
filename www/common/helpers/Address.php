<?php

namespace common\helpers;

use Yii;
use common\models\Country;

class Address {

	const RESIDENTAL = 1;
	const COMMERCIAL = 2;

	public static function getAddressTypes() {
		return [
			self::RESIDENTAL => Yii::t('app', 'Residental'),
			self::COMMERCIAL => Yii::t('app', 'Commercial'),
		];
	}

	public static function getCountryWithState() {
		return [Country::USA, Country::CANADA];
	}

	/**
	 * @param integer $id
	 */
	public static function isCountryWithState($id) {
		return in_array($id, [Country::USA, Country::CANADA]);
	}

}
