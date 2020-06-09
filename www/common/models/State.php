<?php

namespace common\models;

use Yii;

/**
 * @property string $id
 * @property string $code
 * @property string $name
 * @property string $id_country
 */
class State extends \yii\db\ActiveRecord {

	/**
	 * {@inheritdoc}
	 */
	public static function tableName() {
		return 'state';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			[['code', 'name'], 'required'],
			[['id_country'], 'integer'],
			[['code'], 'string', 'max' => 3],
			[['name'], 'string', 'max' => 50],
			[['id_country'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['id_country' => 'id']],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels() {
		return [
			'id' => Yii::t('app', 'ID'),
			'code' => Yii::t('app', 'Code'),
			'name' => Yii::t('app', 'Name'),
			'id_country' => Yii::t('app', 'ID Country'),
		];
	}
}
