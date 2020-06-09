<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use common\helpers\StringHelper;

/**
 * This is the model class for table "gift".
 *
 * @property int $id
 * @property int $id_dates
 * @property int $id_category
 * @property int $id_product
 * @property double $from
 * @property double $to
 * @property string $describe
 *
 * @property Dates $dates
 * @property Category $category
 * @property Product $product
 * @property Parcel[] $parcels
 */
class Gift extends \yii\db\ActiveRecord {

	public $newTags;

	/**
	 * {@inheritdoc}
	 */
	public static function tableName() {
		return 'gift';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
//			['to', 'required', 'when' => function($model) {
//				if(!empty($model->to) && ($model->to > $model->from)) {
//					return true;
//				} else {
//					return false;
//				} 
//			}, 'whenClient' => "function (attribute, value) {
//				if(($('#gift-to').val() != '') && ($('#gift-to').val() > $('#gift-from').val())) {
//					return true;
//				} else {
//					return false;
//				}
//			}",],
			[
				'to', 
				'compare', 
				'when' => function ($model) {
					return !empty($model->to) && ($model->to < $model->from);
				}, 
				'whenClient' => "function (attribute, value) {
					return !(($('#gift-to').val() != '') && ($('#gift-to').val() > $('#gift-from').val()));
				}", 
				'compareValue' => 0, 
				'message'=>'to must be greater than from'
			],
			[['id_dates', 'to'], 'required'],
			[['id_dates', 'id_category', 'id_product'], 'integer'],
			[['from', 'to'], 'number'],
			[['newTags'], 'safe'],
			[['describe'], 'string', 'max' => 255],
			[['id_dates'], 'exist', 'skipOnError' => true, 'targetClass' => Dates::className(), 'targetAttribute' => ['id_dates' => 'id']],
			[['id_category'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['id_category' => 'id']],
			[['id_product'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['id_product' => 'id']],
		];
	}

	public function beforeSave($insert) {
		if (parent::beforeSave($insert)) {
			if (!empty($this->describe)) {
				$this->describe = StringHelper::encodeEmoji($this->describe);
			}
			return true;
		} else {
			return false;
		}
	}

	public function afterSave($insert, $changedAttributes) {
		parent::afterSave($insert, $changedAttributes);

		$oldTags = ArrayHelper::getColumn($this->tags, 'name');
		if (empty($this->newTags)) {
			$this->newTags = [];
		}

		if ($oldTags != $this->newTags) {
			$toRemove = array_diff($oldTags, $this->newTags);
			$toAdd = array_diff($this->newTags, $oldTags);

			if (!empty($toRemove)) {
				foreach ($this->tags as $tag) {
					if (in_array($tag->name, $toRemove)) {
						$this->unlink('tags', $tag, true);
					}
				}
			}

			if (!empty($toAdd)) {
				$toLink = Tag::find()->where(['in', 'name', $toAdd])->indexBy('name')->all();
				foreach ($toAdd as $name) {
					if (isset($toLink[$name])) {
						$this->link('tags', $toLink[$name]);
					} else {
						$modelTag = new Tag();
						$modelTag->name = $name;
						$modelTag->save();
						$this->link('tags', $modelTag);
					}
				}
			}
		}
	}

	public function afterFind() {
		parent::afterFind();
		if (!empty($this->describe)) {
			$this->describe = StringHelper::decodeEmoji($this->describe);
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels() {
		return [
			'id' => 'ID',
			'id_dates' => 'ID Dates',
			'id_category' => 'ID Category',
			'id_product' => 'ID Product',
			'from' => 'From',
			'to' => 'To',
			'describe' => 'Describe',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getDates() {
		return $this->hasOne(Dates::className(), ['id' => 'id_dates']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getCategory() {
		return $this->hasOne(Category::className(), ['id' => 'id_category']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getProduct() {
		return $this->hasOne(Product::className(), ['id' => 'id_product']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getGiftsTag() {
		return $this->hasMany(GiftTag::className(), ['id_gift' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getTags() {
		return $this->hasMany(Tag::className(), ['id' => 'id_tag'])
						->viaTable('gift_tag', ['id_gift' => 'id']);
	}

	public static function getTagsById($id) {
		$gift = self::findOne($id);
		return $gift->tags;
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getParcels() {
		return $this->hasMany(Parcel::className(), ['id_gift' => 'id']);
	}

	/**
	 * {@inheritdoc}
	 * @return GiftQuery the active query used by this AR class.
	 */
	public static function find() {
		return new GiftQuery(get_called_class());
	}

}
