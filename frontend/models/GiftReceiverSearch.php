<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\GiftReceiver;

class GiftReceiverSearch extends GiftReceiver {

	public $all;
	public $nextBirthdayInDay;

	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			[['all', 'nextBirthdayInDay'], 'safe'],
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
	 * @param array $params
	 *
	 * @return ActiveDataProvider
	 */
	public function search($params) {
		$query = GiftReceiver::find();
		$query->andFilterWhere([
			'id_user' => Yii::$app->user->identity->id,
			'is_active' => true,
		]);

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'sort'=> ['defaultOrder' => ['first_name' => SORT_ASC, 'last_name' => SORT_ASC]]
		]);

		$this->load($params);
		if (!$this->validate()) {
			// uncomment the following line if you do not want to return any records when validation fails
			// $query->where('0=1');
			return $dataProvider;
		}

		$query->andFilterWhere([
			'or',
			['like', 'last_name', $this->all],
			['like', 'first_name', $this->all],
			['like', 'email', $this->all],
			['like', 'phone', $this->all],
			['like', 'address1', $this->all],
		]);

		if (!empty($this->nextBirthdayInDay)) {
			$query->andFilterWhere(['>', 'DATE_FORMAT(`birthday`, "%m-%d")', date('m-d')]);
			$query->andFilterWhere(['<', 'DATE_FORMAT(`birthday`, "%m-%d")', date('m-d', time() + 60 * 60 * 24 * $this->nextBirthdayInDay)]);
		}

		return $dataProvider;
	}
}
