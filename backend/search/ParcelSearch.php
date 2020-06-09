<?php

namespace backend\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Parcel;

/**
 * ParcelSearch represents the model behind the search form of `backend\models\Parcel`.
 */
class ParcelSearch extends Parcel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_shipping', 'id_dates', 'id_carrier', 'id_shipping_method', 'id_gift'], 'integer'],
            [['tracking_id', 'date_send', 'describe'], 'safe'],
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
        $query = Parcel::find();

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
            'id_shipping' => $this->id_shipping,
            'id_dates' => $this->id_dates,
            'id_carrier' => $this->id_carrier,
            'id_shipping_method' => $this->id_shipping_method,
            'date_send' => $this->date_send,
            'id_gift' => $this->id_gift,
        ]);

        $query->andFilterWhere(['like', 'tracking_id', $this->tracking_id])
            ->andFilterWhere(['like', 'describe', $this->describe]);

        return $dataProvider;
    }
}
