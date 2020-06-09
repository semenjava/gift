<?php

namespace app\models;

use Yii;
use common\models\User;


/**
 * This is the model class for table "access_token".
 *
 * @property int $id
 * @property string $token
 * @property int $ttl
 * @property string $created
 * @property int $id_user
 *
 * @property User $user
 */
class AccessToken extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'access_token';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['token', 'ttl', 'created', 'id_user'], 'required'],
            [['ttl', 'id_user'], 'integer'],
            [['created'], 'safe'],
            [['token'], 'string', 'max' => 255],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'token' => 'Token',
            'ttl' => 'Ttl',
            'created' => 'Created',
            'id_user' => 'Id User',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    /**
     * {@inheritdoc}
     * @return AccessTokenQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AccessTokenQuery(get_called_class());
    }
}
