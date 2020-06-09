<?php

namespace app\modules\v1_1\controllers;

use app\modules\v1_1\components\ActiveController;
use yii\filters\auth\HttpBearerAuth;
use common\models\GiftReceiver;
use common\models\Gender;
use yii\helpers\ArrayHelper;
use common\helpers\StringHelper;
use common\helpers\Address;
use common\models\Country;

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
                        ->with(['user', 'relations'])->asArray()->one();
        if($reciver) {
            return $this->responseSuccess($reciver);
        }
        return $this->responseFail('Gift Receiver not found '.$id);
    }

    public function actionGetReceiverUser($id_user) {
        $reciver = GiftReceiver::find()->where(['id_user' => $id_user])->asArray()->one();
        if($reciver) {
            return $this->responseSuccess($reciver);
        }
        return $this->responseFail('Gift Receiver not found by id_user '.$id_user);
    }

    public function actionGetList($id_user, $limit, $offset) {
        $reciver = GiftReceiver::find()->where(['id_user' => $id_user, 'is_active' => GiftReceiver::IS_ACTIVE])->with('relations')
                ->limit($limit)->offset($offset)->asArray()->all();
        if($reciver) {
            return $this->responseSuccess($reciver);
        }
        return $this->responseFail('List Gift Receiver not found by id_user '.$id_user);
    }


    public function actionGetListGender() {
        return $this->responseSuccess(Gender::getList());
    }
	
	public function actionGetAddressType() {
        return $this->responseSuccess(Address::getAddressTypes());
    }
	
	public function actionGetCountry() {
        return $this->responseSuccess(ArrayHelper::map(Country::find()->all(), 'id', 'name'));
    }


    public function actionCreate() {
        $model = new GiftReceiver();
        $post = \Yii::$app->getRequest()->post();

        if ($model->load($post, '')) {
            if($model->save()) {
                return $this->responseSuccess(ArrayHelper::toArray($model));
            } else {
                return $this->responseErrorValid($model->errors);
            }
        }
		return $this->responseFail('Could not create by gift receiver '.$id);
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $post = \Yii::$app->getRequest()->getBodyParams();

        if ($model->load($post, '')) {
            if($model->save()) {
                return $this->responseSuccess(ArrayHelper::toArray($model));
            } else {
                return $this->responseErrorValid($model->errors);
            }
        }
		return $this->responseFail('Could not update by gift receiver '.$id);
    }


    protected function findModel($id) {
        if (($model = GiftReceiver::findOne($id)) !== null) {
            return $model;
        }

        throw new \yii\web\ForbiddenHttpException('The requested page does not exist.');
    }
}
