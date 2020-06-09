<?php

namespace common\models;

use Yii;

/**
 * @property string $id_city
 * @property string $zip
 */
class Zip extends \yii\db\ActiveRecord {
	/**
	 * {@inheritdoc}
	 */
	public static function tableName() {
		return 'zip';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			[['id_city', 'zip'], 'required'],
			[['id_city'], 'integer'],
			[['zip'], 'string', 'max' => 10],
			[['id_city', 'zip'], 'unique', 'targetAttribute' => ['id_city', 'zip']],
			[['id_city'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['id_city' => 'id']],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels() {
		return [
			'id_city' => Yii::t('app', 'ID City'),
			'zip' => Yii::t('app', 'Zip'),
		];
	}

}
