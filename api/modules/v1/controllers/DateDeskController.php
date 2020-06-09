<?php

namespace app\modules\v1\controllers;

use app\modules\v1\components\ActiveController;
use yii\filters\auth\HttpBearerAuth;
use common\models\Holiday;
use yii\helpers\ArrayHelper;

class DateDeskController extends ActiveController {

    public $modelClass = 'common\models\Holiday';

    /**
     *
     * @return array
     */
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['class'] = HttpBearerAuth::className();
        return $behaviors;
    }

    public function actionGetList() {
        $holidays = Holiday::find()->asArray()->all();
        if ($holidays) {
					for ($i=0; $i < count($holidays); $i++) {
						$holidays[$i]['day'] = null;
						$holidays[$i]['month'] = null;
					}
            $data = ArrayHelper::toArray($holidays);
            return $this->responseSuccess($data);
        }
        return $this->responseFail($holidays);
    }

}
