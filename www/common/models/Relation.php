<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "relation".
 *
 * @property int $id
 * @property string $name
 */
class Relation extends \yii\db\ActiveRecord
{
	const IS_ACTIVE = 1;
	
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'relation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['is_active'], 'boolean'],
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
			'is_active' => 'Is Active',
        ];
    }

    /**
     * {@inheritdoc}
     * @return RelationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RelationQuery(get_called_class());
    }
}
