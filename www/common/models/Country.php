<?php

namespace common\models;

use Yii;

/**
 * @property string $id
 * @property string $code
 * @property string $name
 */
class Country extends \yii\db\ActiveRecord {

	const USA = 211;
	const CANADA = 34;

	/**
	 * {@inheritdoc}
	 */
	public static function tableName() {
		return 'country';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			[['code', 'name'], 'required'],
			[['code'], 'string', 'max' => 2],
			[['name'], 'string', 'max' => 50],
			[['code'], 'unique'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels() {
		return [
			'id'   => Yii::t('app', 'ID'),
			'code' => Yii::t('app', 'Code'),
			'name' => Yii::t('app', 'Name'),
		];
	}
}
