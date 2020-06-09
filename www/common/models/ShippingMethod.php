<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "shipping_method".
 *
 * @property int $id
 * @property int $id_carrier
 * @property string $name
 *
 * @property Parcel[] $parcels
 * @property Carrier $carrier
 */
class ShippingMethod extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shipping_method';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_carrier', 'name'], 'required'],
            [['id_carrier'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['id_carrier'], 'exist', 'skipOnError' => true, 'targetClass' => Carrier::className(), 'targetAttribute' => ['id_carrier' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_carrier' => 'Id Carrier',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParcels()
    {
        return $this->hasMany(Parcel::className(), ['id_shipping_method' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarrier()
    {
        return $this->hasOne(Carrier::className(), ['id' => 'id_carrier']);
    }

    /**
     * {@inheritdoc}
     * @return ShippingMethodQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ShippingMethodQuery(get_called_class());
    }
}
