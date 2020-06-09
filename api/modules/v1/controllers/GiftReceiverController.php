<?php

namespace app\modules\v1\controllers;

use app\modules\v1\components\ActiveController;
use yii\filters\auth\HttpBearerAuth;
use common\models\GiftReceiver;
use common\models\Gender;
use yii\helpers\ArrayHelper;
use common\helpers\StringHelper;

/**
 *
 */
class GiftReceiverController extends ActiveController {

    public $modelClass = 'common\models\GiftReceiver';

    /**
     *
     * @return array
     */
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['class'] = HttpBearerAuth::className();
		$behaviors['authenticator']['except'] = ['get-list-gender'];
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
        $reciver = GiftReceiver::find()
                        ->where(['gift_receiver.id' => $id])
                        ->with(['user'])->asArray()->one();
        if($reciver) {
            return $this->responseSuccess($reciver);
        }
        return $this->responseFail($reciver);
    }

    public function actionGetReceiverUser($id_users) {
        $reciver = GiftReceiver::find()->where(['id_user' => $id_users])->asArray()->one();
        if($reciver) {
            return $this->responseSuccess($reciver);
        }
        return $this->responseFail($reciver);
    }

    public function actionGetList($id_users, $limit, $offset) {
        $reciver = GiftReceiver::find()->where(['id_user' => $id_users, 'is_active' => GiftReceiver::IS_ACTIVE])
                ->limit($limit)->offset($offset)->asArray()->all();
        if($reciver) {
            return $this->responseSuccess($reciver);
        }
        return $this->responseFail($reciver);
    }


    public function actionGetListGender() {
        return $this->responseSuccess(Gender::getList());
    }


    public function actionCreate() {
        $model = new GiftReceiver();
        $post = \Yii::$app->getRequest()->post();

        if ($model->load($post, '')) {
            $model->address_type = \common\helpers\Address::RESIDENTAL;
            $model->id_country = \common\models\Country::USA;
            $model->id_state = 1;
            $model->city = 'Anchorage';
            $model->zip = '99501';
            $model->address1 = 'House ' . time();

            if($model->save()) {
                return $this->responseSuccess(ArrayHelper::toArray($model));
            } else {
                return $this->responseFail($model->errors);
            }
        }

    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $post = \Yii::$app->getRequest()->getBodyParams();

        if ($model->load($post, '')) {
            if($model->save()) {
                return $this->responseSuccess(ArrayHelper::toArray($model));
            } else {
                return $this->responseFail($model->errors);
            }
        }
    }


    protected function findModel($id) {
        if (($model = GiftReceiver::findOne($id)) !== null) {
            return $model;
        }

        throw new \yii\web\ForbiddenHttpException('The requested page does not exist.');
    }
}
