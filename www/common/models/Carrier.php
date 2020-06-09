<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "carrier".
 *
 * @property int $id
 * @property string $name
 *
 * @property Parcel[] $parcels
 * @property ShippingMethod[] $shippingMethods
 */
class Carrier extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'carrier';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParcels()
    {
        return $this->hasMany(Parcel::className(), ['id_carrier' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShippingMethods()
    {
        return $this->hasMany(ShippingMethod::className(), ['id_carrier' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return CarrierQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CarrierQuery(get_called_class());
    }
}
