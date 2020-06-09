<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ShippingMethod]].
 *
 * @see ShippingMethod
 */
class ShippingMethodQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ShippingMethod[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ShippingMethod|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
