<?php

namespace frontend\models;

use frontend\controllers\TestController;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class GiftWork extends \yii\db\ActiveRecord{

    public static function tableName()
    {
        return 'gift';
    }

    public static function getAll()
    {
        $data = self::find()->all();
        return $data;
    }
		
	public static function getGifts($id_dates)
    {
        $data = self::find()->where(['id_dates' => $id_dates])->asArray()->all();
        return $data;
    }
		public static function getGift($id_dates)
    {
        $data = self::find()->where(['id' => $id_dates])->asArray()->one();
        return $data;
    }
}

