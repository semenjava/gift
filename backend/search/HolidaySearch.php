<?php

namespace backend\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Holiday;

/**
 * HolidaySearch represents the model behind the search form of `common\models\Holiday`.
 */
class HolidaySearch extends Holiday
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
			[['is_birthday'], 'boolean'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Holiday::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
                 'forcePageParam' => false,
                 'pageSizeParam' => false,
                'pageSize' => 10
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
