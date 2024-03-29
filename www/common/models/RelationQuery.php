<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Relation]].
 *
 * @see Relation
 */
class RelationQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Relation[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Relation|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
