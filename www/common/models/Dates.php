<?php

namespace common\models;

use Yii;
use common\models\Holiday;
use common\helpers\StringHelper;

/**
 * This is the model class for table "dates".
 *
 * @property int $id
 * @property int $id_gift_receiver
 * @property string $mem_date
 * @property int $id_holiday
 * @property string $custom_holiday
 *
 * @property GiftReceiver $giftReceiver
 * @property Holiday $holiday
 * @property Gift[] $gifts
 * @property Parcel[] $parcels
 */
class Dates extends \yii\db\ActiveRecord {

	public $gift_receiver_name;

	public $date_description;
    public $tags;

    const DATE_FORMAT = 'php:Y-m-d';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dates';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
			[['id_holiday'], 'filter', 'filter' => function ($value) {
				return empty($value) ? null : intval($value);
			}],
			['id_holiday', 'required', 'when' => function($model) {
				return empty($model->custom_holiday);
			}, 'whenClient' => "function (attribute, value) {
				return !$('#dates-custom_holiday').val();
			}",],
			['custom_holiday', 'required', 'when' => function($model) {
				return empty($model->id_holiday);
			}, 'whenClient' => "function (attribute, value) {
				return !$('#dates-id_holiday').val();
			}",],
			
            [['id_gift_receiver', 'date_m', 'date_d'], 'required'],
            [['id_holiday'], 'integer'],
            [['custom_holiday', 'date_m', 'date_d', 'date_y'], 'safe'],
//            ['mem_date', 'date', 'format' => self::DATE_FORMAT],
            [['custom_holiday'], 'string', 'max' => 255],
            [['id_gift_receiver'], 'exist', 'skipOnError' => true, 'targetClass' => GiftReceiver::className(), 'targetAttribute' => ['id_gift_receiver' => 'id']],
            [['id_holiday'], 'exist', 'skipOnError' => true, 'targetClass' => Holiday::className(), 'targetAttribute' => ['id_holiday' => 'id']],
        ];
    }

    public function beforeSave($insert) {
        if(parent::beforeSave($insert)) {
            if(!empty($this->custom_holiday)) {
                $this->custom_holiday = StringHelper::encodeEmoji($this->custom_holiday);
            }

            return true;
        } else {
            return false;
        }
    }

    public function afterFind() {
        parent::afterFind();
        if(!empty($this->custom_holiday)) {
            $this->custom_holiday = StringHelper::decodeEmoji($this->custom_holiday);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_gift_receiver' => 'Gift Receiver',
//            'mem_date' => 'Mem Date',
            'date_m' => 'Month',
            'date_d' => 'Day',
            'date_y' => 'Year',
            'id_holiday' => 'Holiday',
            'custom_holiday' => 'Custom Holiday',
            'gift_receiver_name' => 'Gift Receiver',
            'date_description' => 'Date Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGiftReceiver()
    {
        return $this->hasOne(GiftReceiver::className(), ['id' => 'id_gift_receiver']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHoliday()
    {
        return $this->hasOne(Holiday::className(), ['id' => 'id_holiday']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGift()
    {
        return $this->hasOne(Gift::className(), ['id_dates' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParcels()
    {
        return $this->hasMany(Parcel::className(), ['id_dates' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return DatesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DatesQuery(get_called_class());
    }

    public static function getMonthByDay($month, $year=false) {
        $number = cal_days_in_month(CAL_GREGORIAN, $month, $year?$year:date('Y'));
        $day = [""];
        $i=1;
        while ($number >= $i) {
            $day[]=$i;
            $i++;
        }
        return $day;
    }

    public static function getMonth() {
        return [
            "",1,2,3,4,5,6,7,8,9,10,11,12
        ];
    }

    public static function getYear() {
        $year = [];
        $i=1900;
        $number = 2200;
        while ($number >= $i) {
            $year[$i]=$i;
            $i++;
        }

        return $year;
    }

}
