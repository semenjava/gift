<?php

namespace app\modules\v1_1\controllers;

use app\modules\v1_1\components\ActiveController;
use yii\filters\auth\HttpBearerAuth;
use common\models\Holiday;
use yii\helpers\ArrayHelper;

class HolidayController extends ActiveController {

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
            $data = ArrayHelper::toArray($holidays);
            return $this->responseSuccess($data);
        }
        return $this->responseFail();
    }

}
