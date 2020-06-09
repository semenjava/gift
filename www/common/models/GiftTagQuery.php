<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[GiftTag]].
 *
 * @see GiftTag
 */
class GiftTagQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return GiftTag[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return GiftTag|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
