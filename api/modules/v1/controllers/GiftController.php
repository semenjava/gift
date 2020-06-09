<?php

namespace app\modules\v1\controllers;

use app\modules\v1\components\ActiveController;
use yii\filters\auth\HttpBearerAuth;
use common\models\Gift;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use common\helpers\StringHelper;

/**
 *
 */
class GiftController extends ActiveController {

    public $modelClass = 'common\models\Gift';

    /**
     *
     * @return array
     */
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['class'] = HttpBearerAuth::className();
        return $behaviors;
    }

    public function actionGet($id) {
        $gift = Gift::find()->where(['id' => $id])->with(['dates', 'category', 'product'])->asArray()->one();
        if ($gift) {
            if(!empty($gift['describe'])) {
                $gift['describe'] = StringHelper::decodeEmoji($gift['describe']);
            }
            return $this->responseSuccess($gift);
        }
        return $this->responseFail($gift);
    }

    public function actionGetList($id_dates) {
        $gift = Gift::find()
                        ->where(['id_dates' => $id_dates])
                        ->with(['dates', 'category', 'product'])->asArray()->all();
        if ($gift) {
            foreach ($gift as $key => $value) {
                if(!empty($value['describe'])) {
                    $gift[$key]['describe'] = StringHelper::decodeEmoji($value['describe']);
                }

                if(!empty($value['dates'])) {
                    if(!empty($value['dates']['custom_holiday'])) {
                        $gift[$key]['dates']['describe'] = StringHelper::decodeEmoji($value['dates']['custom_holiday']);
                    }
                }
            }

            return $this->responseSuccess($gift);
        }
        return $this->responseFail($gift);
    }

    public function actionCreate() {
        $model = new Gift();
        return $this->responseSave($model);
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);
        return $this->responseSave($model);
    }

    public function actionDel($id) {

        $model = $this->findModel($id);
        $id_dates = $model->id_dates;

        return $this->responseSuccess($this->findModel($id)->delete());
    }

    protected function findModel($id) {
        if (($model = Gift::findOne($id)) !== null) {
            return $model;
        }

        throw new \yii\web\ForbiddenHttpException('The requested page does not exist.');
    }

}
