<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "shipping".
 *
 * @property int $id
 * @property int $id_gift_receiver
 * @property int $id_country
 * @property int $id_state
 * @property string $state
 * @property int $id_city
 * @property string $zip
 * @property string $address1
 * @property string $address2
 *
 * @property Parcel[] $parcels
 * @property GiftReceiver $giftReceiver
 */
class Shipping extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shipping';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_gift_receiver', 'id_country', 'id_state', 'state', 'id_city', 'zip', 'address1'], 'required'],
            [['id_gift_receiver', 'id_country', 'id_state', 'id_city'], 'integer'],
            [['state', 'zip', 'address1', 'address2'], 'string', 'max' => 255],
            [['id_gift_receiver'], 'exist', 'skipOnError' => true, 'targetClass' => GiftReceiver::className(), 'targetAttribute' => ['id_gift_receiver' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_gift_receiver' => 'Id Gift Receiver',
            'id_country' => 'Id Country',
            'id_state' => 'Id State',
            'state' => 'State',
            'id_city' => 'Id City',
            'zip' => 'Zip',
            'address1' => 'Address1',
            'address2' => 'Address2',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParcels()
    {
        return $this->hasMany(Parcel::className(), ['id_shipping' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGiftReceiver()
    {
        return $this->hasOne(GiftReceiver::className(), ['id' => 'id_gift_receiver']);
    }

    /**
     * {@inheritdoc}
     * @return ShippingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ShippingQuery(get_called_class());
    }
}
