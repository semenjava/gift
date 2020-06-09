<?php

namespace backend\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use common\models\Product;
use common\models\Category;

/**
 * ProductSearch represents the model behind the search form of `backend\models\Product`.
 */
class ProductSearch extends Product
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_category', 'is_active'], 'integer'],
            [['name'], 'safe'],
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
        $query = Product::find();

        // add conditions that should always apply here
        
        $query->join('LEFT JOIN', 'category', 'product.id_category = category.id');

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
            'id_category' => $this->id_category,
            'is_active' => $this->is_active,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
    
    public static function dropDownListCategory() {
        $result = [];
        $category = ArrayHelper::map(Category::find()->where(['is_active' => 1])->all(), 'id', 'name');
        $params = Yii::$app->request->queryParams ? Yii::$app->request->queryParams[str_replace(__NAMESPACE__.'\\','',static::className())] : [];
        if(!empty($params['id_category'])) {
            $result = [$params['id_category'] => $category[$params['id_category']]];
            unset($category[$params['id_category']]);
        }
        $result += ['' => ''];
        foreach ($category as $id => $name) {
            $result[$id] = $name;
        }
        return $result;
    }
}
