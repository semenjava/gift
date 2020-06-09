<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Dates;

class DatesSearch extends Dates {

	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [];
	}

	/**
	 * {@inheritdoc}
	 */
	public function scenarios() {
		return Model::scenarios();
	}

	/**
	 * @param array $params
	 * @param int $idGiftReceiver
	 *
	 * @return ActiveDataProvider
	 */
	public function search($params, $idGiftReceiver) {
		$query = Dates::find()->with(['holiday']);
		$query->joinWith('gift');

		$query->andFilterWhere([
			'id_gift_receiver' => $idGiftReceiver,
		]);

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'sort'=> [
				'defaultOrder' => ['date' => SORT_ASC],
				'attributes' => [
					'date' => [
						'asc' => ['date_m' => SORT_ASC, 'date_d' => SORT_ASC],
						'desc' => ['date_m' => SORT_DESC, 'date_d' => SORT_DESC],
					],
					'from' => [
						'asc' => ['gift.from' => SORT_ASC],
						'desc' => ['gift.from' => SORT_DESC],
					],
					'to' => [
						'asc' => ['gift.to' => SORT_ASC],
						'desc' => ['gift.to' => SORT_DESC],
					],
				]
			]
		]);

		$this->load($params);
		if (!$this->validate()) {
			// uncomment the following line if you do not want to return any records when validation fails
			// $query->where('0=1');
			return $dataProvider;
		}

		return $dataProvider;
	}
}
