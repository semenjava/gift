<?php

namespace common\models;

use Yii;
use common\helpers\StringHelper;

/**
 * This is the model class for table "parcel".
 *
 * @property int $id
 * @property int $id_shipping
 * @property int $id_dates
 * @property int $id_carrier
 * @property int $id_shipping_method
 * @property string $tracking_id
 * @property string $date_send
 * @property int $id_gift
 * @property string $describe
 *
 * @property Shipping $shipping
 * @property Dates $dates
 * @property Carrier $carrier
 * @property ShippingMethod $shippingMethod
 * @property Gift $gift
 */
class Parcel extends \yii\db\ActiveRecord
{
    
    private $DATE_FORMAT = 'php:Y-m-d';
    private $GET_DATA_FORMAT = 'php:d.m.Y';
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'parcel';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_shipping', 'id_dates', 'id_carrier', 'id_shipping_method', 'tracking_id', 'date_send', 'id_gift', 'describe'], 'required'],
            [['id_shipping', 'id_dates', 'id_carrier', 'id_shipping_method', 'id_gift'], 'integer'],
            [['date_send'], 'safe'],
            ['date_send', 'date', 'format' => $this->GET_DATA_FORMAT],
            [['tracking_id', 'describe'], 'string', 'max' => 255],
            [['id_shipping'], 'exist', 'skipOnError' => true, 'targetClass' => Shipping::className(), 'targetAttribute' => ['id_shipping' => 'id']],
            [['id_dates'], 'exist', 'skipOnError' => true, 'targetClass' => Dates::className(), 'targetAttribute' => ['id_dates' => 'id']],
            [['id_carrier'], 'exist', 'skipOnError' => true, 'targetClass' => Carrier::className(), 'targetAttribute' => ['id_carrier' => 'id']],
            [['id_shipping_method'], 'exist', 'skipOnError' => true, 'targetClass' => ShippingMethod::className(), 'targetAttribute' => ['id_shipping_method' => 'id']],
            [['id_gift'], 'exist', 'skipOnError' => true, 'targetClass' => Gift::className(), 'targetAttribute' => ['id_gift' => 'id']],
        ];
    }
    
    public function beforeSave($insert) {
        if(parent::beforeSave($insert)) {
            if(!empty($this->date_send)) {
                $this->date_send = \Yii::$app->formatter->asDatetime($this->date_send, $this->DATE_FORMAT);
            }
            if(!empty($this->describe)) {
                $this->describe = StringHelper::encodeEmoji($this->describe);
            }
            return true;
        } else {
            return false;
        }    
    }
    
    public function afterFind() {
        parent::afterFind();
        if(!empty($this->describe)) {
            $this->describe = StringHelper::decodeEmoji($this->describe);
        }
        
        if(!empty($this->date_send)) {
            $this->date_send = \Yii::$app->formatter->asDatetime($this->date_send, $this->GET_DATA_FORMAT);
        }
    }
    

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_shipping' => 'Id Shipping',
            'id_dates' => 'Id Dates',
            'id_carrier' => 'Id Carrier',
            'id_shipping_method' => 'Id Shipping Method',
            'tracking_id' => 'Tracking ID',
            'date_send' => 'Date Send',
            'id_gift' => 'Id Gift',
            'describe' => 'Describe',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShipping()
    {
        return $this->hasOne(Shipping::className(), ['id' => 'id_shipping']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDates()
    {
        return $this->hasOne(Dates::className(), ['id' => 'id_dates']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarrier()
    {
        return $this->hasOne(Carrier::className(), ['id' => 'id_carrier']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShippingMethod()
    {
        return $this->hasOne(ShippingMethod::className(), ['id' => 'id_shipping_method']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGift()
    {
        return $this->hasOne(Gift::className(), ['id' => 'id_gift']);
    }

    /**
     * {@inheritdoc}
     * @return ParcelQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ParcelQuery(get_called_class());
    }
}
