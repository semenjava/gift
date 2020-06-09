<?php

namespace common\models;

use Yii;

/**
 * @property string $id
 * @property string $name
 * @property string $id_state
 * @property string $id_country
 */
class City extends \yii\db\ActiveRecord {

	/**
	 * {@inheritdoc}
	 */
	public static function tableName() {
		return 'city';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			[['name'], 'required'],
			[['id_state', 'id_country'], 'integer'],
			[['name'], 'string', 'max' => 50],
			[['id_country'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['id_country' => 'id']],
			[['id_state'], 'exist', 'skipOnError' => true, 'targetClass' => State::className(), 'targetAttribute' => ['id_state' => 'id']],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels() {
		return [
			'id' => Yii::t('app', 'ID'),
			'name' => Yii::t('app', 'Name'),
			'id_state' => Yii::t('app', 'ID State'),
			'id_country' => Yii::t('app', 'ID Country'),
		];
	}
}
