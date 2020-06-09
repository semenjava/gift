<?php

namespace backend\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use common\models\GiftReceiver;
use common\models\User;
use common\models\Gender;

/**
 * GiftReceiverSearch represents the model behind the search form of `backend\models\GiftReceiver`.
 */
class GiftReceiverSearch extends GiftReceiver
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'gender', 'id_user', 'is_active'], 'integer'],
            [['last_name', 'first_name', 'email', 'phone', 'birthday'], 'safe'],
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
        $query = GiftReceiver::find();

        // add conditions that should always apply here

        $query->join('LEFT JOIN', 'user', 'gift_receiver.id_user = user.id');

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
            'gender' => $this->gender,
            'id_user' => $this->id_user,
            'is_active' => $this->is_active,
        ]);

        $query->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'birthday', $this->birthday]);

        return $dataProvider;
    }


    public static function dropDownListUsers() {
        $result = [];
        $users = ArrayHelper::map(User::find()->all(), 'id', 'username');
        $params = !empty(Yii::$app->request->queryParams[str_replace(__NAMESPACE__.'\\','',static::className())])
                ? Yii::$app->request->queryParams[str_replace(__NAMESPACE__.'\\','',static::className())] : [];
        if(!empty($params['id_user'])) {
            $result = [$params['id_user'] => $users[$params['id_user']]];
            unset($users[$params['id_user']]);
        }
        $result += ['' => ''];
        foreach ($users as $id => $name) {
            $result[$id] = $name;
        }
        return $result;
    }


}
