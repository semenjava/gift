<?php

namespace app\modules\v1\controllers;

use app\modules\v1\components\ActiveController;
use yii\filters\auth\HttpBearerAuth;
use common\models\Category;
use yii\helpers\ArrayHelper;

class CategoryController extends ActiveController {

    public $modelClass = 'common\models\Category';

    /**
     *
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
     * @return array
     */
    public function actionGetList() {
        $category = Category::find()->where(['is_active' => Category::IS_ACTIVE])->all();
        if($category) {
            $data = ArrayHelper::toArray($category);
            $data['count'] = Category::find()->where(['is_active' => Category::IS_ACTIVE])->count();
            return $this->responseSuccess($data);
        } 
        return $this->responseFail($category);
    }

}
