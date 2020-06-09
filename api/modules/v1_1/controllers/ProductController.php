<?php

namespace app\modules\v1_1\controllers;

use app\modules\v1_1\components\ActiveController;
use yii\filters\auth\HttpBearerAuth;
use common\models\Product;
use yii\helpers\ArrayHelper;

/**
 *
 */
class ProductController extends ActiveController {

    public $modelClass = 'common\models\Product';

    /**
     *
     * @return array
     */
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['class'] = HttpBearerAuth::className();
        return $behaviors;
    }
    
    /**
     *
     * covered with GetProduct
     *
     * @param int $id
     * @return type
     */
    public function actionGet($id) {
        $product = Product::find()->where(['id' => $id])->asArray()->one();
        if($product) {
            return $this->responseSuccess($product); 
        } 
        return $this->responseFail('Product not found '.$id);
    }

    public function actionGetList($id_category, $limit, $offset) {
        $product = Product::find()->where(['is_active' => Product::IS_ACTIVE])
                ->where(['id_category' => $id_category])
                ->limit($limit)->offset($offset)->asArray()->all();
        if($product) {
            return $this->responseSuccess($product); 
        }
        return $this->responseFail('List Products not found by id_category '.$id_category);
    }

    public function actionSearch($name, $id_category = 0) {
        $query = Product::find()->where(['is_active' => Product::IS_ACTIVE]);

        if (!empty($id_category)) {
            $query->where(['id_category' => $id_category]);
        }

        $query->andWhere(['like', 'name', $name]);
        $search = $query->asArray()->all();
        if($search) {
            return $this->responseSuccess($search);
        }
        return $this->responseFail('Product not found search '.$search);
    }
}
