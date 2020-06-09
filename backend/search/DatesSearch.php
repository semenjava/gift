<?php

namespace backend\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Dates;

/**
 * DatesSearch represents the model behind the search form of `common\models\Dates`.
 */
class DatesSearch extends Dates
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_gift_receiver', 'id_holiday'], 'integer'],
            [['mem_date', 'custom_holiday'], 'safe'],
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
        $query = Dates::find()->with(['gift', 'gift.tags']);

        if(!empty($params)) {
            foreach ($params as $column => $value) {
                $query->where([$column => $value]);
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                 'forcePageParam' => false,
                 'pageSizeParam' => false,
                'pageSize' => 100
            ]
        ]);

        // add conditions that should always apply here

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_gift_receiver' => $this->id_gift_receiver,
            'id_holiday' => $this->id_holiday,
        ]);

        $query->andFilterWhere(['like', 'custom_holiday', $this->custom_holiday]);



        return $dataProvider;
    }
}
