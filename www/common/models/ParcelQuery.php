<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Parcel]].
 *
 * @see Parcel
 */
class ParcelQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Parcel[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Parcel|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
