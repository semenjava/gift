<?php

namespace common\models;

use Yii;
use common\helpers\DateHelper;

/**
 * This is the model class for table "holiday".
 *
 * @property int $id
 * @property string $name
 * @property string $strtotime
 * @property boolean $is_birthday
 *
 * @property Dates[] $dates
 */
class Holiday extends \yii\db\ActiveRecord {

	/**
	 * {@inheritdoc}
	 */
	public static function tableName() {
		return 'holiday';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			[['is_birthday'], 'boolean'],
			[['name', 'strtotime'], 'string', 'max' => 255],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels() {
		return [
			'id' => 'ID',
			'name' => 'Name',
			'strtotime' => 'Strtotime',
		];
	}

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDates()
    {
        return $this->hasMany(Dates::className(), ['id_holiday' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return HolidayQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new HolidayQuery(get_called_class());
    }
}
