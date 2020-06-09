<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[GiftReceiver]].
 *
 * @see GiftReceiver
 */
class GiftReceiverQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return GiftReceiver[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return GiftReceiver|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
