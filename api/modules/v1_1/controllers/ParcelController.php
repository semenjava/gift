<?php

namespace app\modules\v1_1\controllers;

use app\modules\v1_1\components\ActiveController;
use yii\filters\auth\HttpBearerAuth;
use common\models\Parcel;
use yii\helpers\ArrayHelper;

class ParcelController extends ActiveController {

    public $modelClass = 'common\models\Parcel';

    /**
     *
     * @return array
     */
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['class'] = HttpBearerAuth::className();
        return $behaviors;
    }

    public function actionGetList($id_gift, $limit, $offset) {
        $parcel = Parcel::find()
                        ->where(['id_gift' => $id_gift])
                        ->with(['shipping', 'dates', 'carrier', 'shipping_method', 'gift'])
                        ->limit($limit)->offset($offset)->asArray()->all();
        if($parcel) {
            return $this->responseSuccess($parcel);
        }
        return $this->responseFail('Parcel not found in id_gift '.$id_gift);
    }
	
	public function actionGet($id) {
        $parcel = Parcel::find()->where(['id' => $id])->asArray()->one();
        if($parcel) {
            return $this->responseSuccess($parcel); 
        } 
        return $this->responseFail('Parcel not found '.$id);
    }

}
