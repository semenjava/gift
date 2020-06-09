<?php

namespace common\models;

use Yii;
use app\models\SuccessAction;
use common\helpers\StringHelper;
use common\behaviors\AddressBehavior;
use common\models\Relation;

/**
 * This is the model class for table "gift_receiver".
 *
 * @property int $id
 * @property string $last_name
 * @property string $first_name
 * @property string $email
 * @property string $phone
 * @property string $birthday
 * @property string $birthday_day
 * @property string $birthday_month
 * @property string $birthday_year
 * @property boolean $is_approximate_age
 * @property int $gender
 * @property int $id_user
 * @property int $is_active
 * @property int $id_relation
 * @property int $address_type
 * @property int $id_country
 * @property int $id_state
 * @property int $custom_state
 * @property string $city
 * @property string $zip
 * @property string $address1
 * @property string $address2
 *
 * @property Dates[] $dates
 * @property User $user
 * @property Shipping[] $shippings
 */
class GiftReceiver extends \yii\db\ActiveRecord {

    const IS_ACTIVE = 1;
    const DATE_FORMAT = 'php:Y-m-d';

	public $approximateAge;

	public function behaviors() {
		return [
			AddressBehavior::className(),
		];
	}

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gift_receiver';
    }

	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return array_merge(AddressBehavior::rules(), [
			[['birthday_year', 'approximateAge', 'gender', 'birthday_day', 'birthday_month'], 'filter', 'filter' => function ($value) {
				return empty($value) ? null : intval($value);
			}],
			['birthday_year', 'required', 'when' => function($model) {
				return empty($model->approximateAge);
			}, 'whenClient' => "function (attribute, value) {
				return !$('#giftreceiver-approximateage').val();
			}",],
			['approximateAge', 'required', 'when' => function($model) {
				return empty($model->birthday_year);
			}, 'whenClient' => "function (attribute, value) {
				return !$('#giftreceiver-birthday_year').val();
			}",],
            [['last_name', 'first_name', 'gender', 'id_user'], 'required'],
            [['is_active'], 'boolean'],
            ['email', 'email'],
            [['birthday', 'describe'], 'safe'],
//            [['birthday'], 'string', 'max' => 50],
            [['gender', 'id_user', 'is_active', 'id_relation'], 'integer'],
            [['last_name', 'first_name', 'email', 'phone'], 'string', 'max' => 255],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels() {
		return [
            'id' => 'ID',
            'last_name' => 'Last Name',
            'first_name' => 'First Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'birthday' => 'Birthday',
            'gender' => 'Gender',
            'describe' => 'Describe',
            'id_user' => 'Id User',
            'is_active' => 'Is Active',
            'id_relation' => 'Relation',
		];
	}

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDates()
    {
        return $this->hasMany(Dates::className(), ['id_gift_receiver' => 'id']);
    }

		/**
		 * @return \yii\db\ActiveQuery
		 */
		public function getNearestDate() {
			$currentMonth = date('m');
			$currentDay = date('d');
				return $this->hasOne(Dates::className(), ['id_gift_receiver' => 'id'])
					->orderBy(new \yii\db\Expression("
						CASE
								WHEN date_m > {$currentMonth} THEN 4
								WHEN date_m = {$currentMonth} AND date_d > {$currentDay} THEN 3
								WHEN date_m = {$currentMonth} AND date_d <= {$currentDay} THEN 2
								WHEN date_m < {$currentMonth} THEN 1
						END DESC,
						date_m, date_d
					"))
					->limit(1);
		}

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }
	
    public function getRelations()
    {
        return $this->hasMany(Relation::className(), ['id' => 'id_relation']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShippings()
    {
        return $this->hasMany(Shipping::className(), ['id_gift_receiver' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return GiftReceiverQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GiftReceiverQuery(get_called_class());
    }

	public function beforeSave($insert) {
		if (!parent::beforeSave($insert)) {
			return false;
		}

		if (!$insert && $this->oldAttributes['birthday_year'] != $this->birthday_year) {
			$this->is_approximate_age = 0;
		}

		if (!empty($this->approximateAge)) {
			$this->is_approximate_age = 1;
			$this->birthday_year = $this->approximateAge;
		}

		if ($this->birthday_year && $this->birthday_month && $this->birthday_day) {
			$this->birthday = (new \DateTime( "{$this->birthday_year}-{$this->birthday_month}-{$this->birthday_day}"))->format('Y-m-d');
		} else {
			$this->birthday = null;
		}

		return true;
	}

	public function getGenderLabel() {
		return Gender::getList()[$this->gender];
	}

	public function getName() {
		return $this->first_name . ' ' . $this->last_name;
	}

	public static function getApproximateAgeRange() {
		$range = [];
		for ($i = 2; $i < 100; $i += 5) {
			$range[date('Y') - $i] = ($i-2) . ' - ' . ($i + 2);
		}
		return $range;
	}

	public function getAge() {
		return date('Y') - $this->birthday_year;
	}

	public function getAgeRange() {
		return ($this->getAge() - 2) . ' - ' . ($this->getAge() + 2);
	}
}
