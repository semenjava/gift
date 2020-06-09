<?php

namespace backend\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Gift;
use yii\helpers\ArrayHelper;
use common\models\Category;
use common\models\Product;
use common\models\Dates;

/**
 * GiftSearch represents the model behind the search form of `common\models\Gift`.
 */
class GiftSearch extends Gift {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'id_dates', 'id_category', 'id_product'], 'integer'],
            [['from', 'to'], 'number'],
            [['describe'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios() {
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
    public function search($params) {
        $query = Gift::find();

        if(!empty($params)) {
            foreach ($params as $column => $value) {
                $query->where([$column => $value]);
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'id_dates' => $this->id_dates,
            'id_category' => $this->id_category,
            'id_product' => $this->id_product,
            'from' => $this->from,
            'to' => $this->to,
        ]);

        $query->andFilterWhere(['like', 'describe', $this->describe]);

        return $dataProvider;
    }
    
    public static function dropDownListDates($data_desk) {
        $result = [];
        $params = !empty(Yii::$app->request->queryParams[str_replace(__NAMESPACE__ . '\\', '', static::className())]) ?
                Yii::$app->request->queryParams[str_replace(__NAMESPACE__ . '\\', '', static::className())] : [];
        if (!empty($params['id_dates'])) {
            $result = [$params['id_dates'] => $data_desk[$params['id_dates']]];
            unset($data_desk[$params['id_dates']]);
        }
        $result += ['' => ''];
        foreach ($data_desk as $id => $name) {
            $result[$id] = $name;
        }
        return $result;
    }

    public static function dropDownListCategory() {
        $result = [];
        $categpry = ArrayHelper::map(Category::find()->all(), 'id', 'name');
        $params = !empty(Yii::$app->request->queryParams[str_replace(__NAMESPACE__ . '\\', '', static::className())]) ?
                Yii::$app->request->queryParams[str_replace(__NAMESPACE__ . '\\', '', static::className())] : [];
        if (!empty($params['id_category'])) {
            $result = [$params['id_category'] => $categpry[$params['id_category']]];
            unset($categpry[$params['id_category']]);
        }
        $result += ['' => ''];
        foreach ($categpry as $id => $name) {
            $result[$id] = $name;
        }
        return $result;
    }
    
    public static function dropDownListProducts() {
        $result = [];
        $product = ArrayHelper::map(Product::find()->all(), 'id', 'name');
        $params = !empty(Yii::$app->request->queryParams[str_replace(__NAMESPACE__ . '\\', '', static::className())]) ?
                Yii::$app->request->queryParams[str_replace(__NAMESPACE__ . '\\', '', static::className())] : [];
        if (!empty($params['id_product'])) {
            $result = [$params['id_product'] => $product[$params['id_product']]];
            unset($product[$params['id_product']]);
        }
        $result += ['' => ''];
        foreach ($product as $id => $name) {
            $result[$id] = $name;
        }
        return $result;
    }

}
