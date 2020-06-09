<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use common\models\Holiday;

/**
 * This is the ActiveQuery class for [[Dates]].
 *
 * @see Dates
 */
class DatesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Dates[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Dates|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public static function dropDownListHoliday() {
        $result = [];
        $dateDesk = ArrayHelper::map(Holiday::find()->all(), 'id', 'name');
        $params = !empty(Yii::$app->request->queryParams[str_replace(__NAMESPACE__.'\\','',static::className())])
                ? Yii::$app->request->queryParams[str_replace(__NAMESPACE__.'\\','',static::className())] : [];
        if(!empty($params['id_holiday'])) {
            $result = [$params['id_holiday'] => $dateDesk[$params['id_holiday']]];
            unset($dateDesk[$params['id_holiday']]);
        }
        $result += ['' => ''];
        foreach ($dateDesk as $id => $name) {
            $result[$id] = $name;
        }
        return $result;
    }
}
