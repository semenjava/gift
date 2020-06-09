<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "gift_tag".
 *
 * @property int $id
 * @property int $id_gift
 * @property string $name
 *
 * @property Gift $gift
 */
class GiftTag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gift_tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_gift', 'id_tag'], 'required'],
            [['id_gift', 'id_tag'], 'integer'],
//            [['name'], 'string', 'max' => 255],
            [['id_gift'], 'exist', 'skipOnError' => true, 'targetClass' => Gift::className(), 'targetAttribute' => ['id_gift' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_gift' => 'Id Gift',
            'id_tag' => 'Id Tag',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGift()
    {
        return $this->hasOne(Gift::className(), ['id' => 'id_gift']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTag()
    {
        return $this->hasMany(Tag::className(), ['id' => 'id_tag']);
    }

    /**
     * {@inheritdoc}
     * @return GiftTagQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GiftTagQuery(get_called_class());
    }
}
