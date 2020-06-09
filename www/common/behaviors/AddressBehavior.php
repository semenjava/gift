<?php

namespace common\behaviors;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Behavior;
use common\helpers\Address;

class AddressBehavior extends Behavior {

	public function events() {
		return [
			ActiveRecord::EVENT_BEFORE_INSERT => 'beforeSave',
			ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeSave',
		];
	}

	public function beforeSave() {
		if (Address::isCountryWithState($this->owner->id_country)) {
			$this->owner->custom_state = null;
			if (!empty($this->owner->zip)) {
				$idState = Yii::$app->db->createCommand('SELECT city.id_state FROM zip JOIN city ON zip.id_city = city.id WHERE zip.zip = :code')
					->bindValue(':code', $this->owner->zip)
					->queryScalar();
			}
		}
		$this->owner->id_state = empty($idState) ? null : $idState;
	}

	public static function rules() {
		return [
			[['address_type', 'id_country', 'city', 'address1'], 'required'],
			['address_type', 'in', 'range' => [Address::RESIDENTAL, Address::COMMERCIAL]],
			[['id_country', 'id_state'], 'integer'],
			[['zip'], 'string', 'max' => 10],
			[['city'], 'string', 'max' => 63],
			[['address1', 'address2'], 'string', 'max' => 255],

			['custom_state', 'required', 'when' => function($model) {
				return !Address::isCountryWithState($model->id_country);
			}, 'whenClient' => 'function (attribute, value) {
				return JSON.parse("' . json_encode(Address::getCountryWithState()) . '").indexOf(
					parseInt(
						$("select[id$=\'-id_country\']").val()
					)
				) === -1;
			}'],
		];
	}
}
