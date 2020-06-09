<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Holiday]].
 *
 * @see Holiday
 */
class HolidayQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Holiday[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Holiday|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
