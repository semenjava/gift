<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Gift]].
 *
 * @see Gift
 */
class GiftQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Gift[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Gift|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
