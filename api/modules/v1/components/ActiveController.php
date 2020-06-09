<?php

namespace app\modules\v1\components;

use app\models\LoginForm;
use yii\helpers\ArrayHelper;
use app\modules\v1\components\ExceptionAction;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ActiveController
 *
 * @author semen
 */
class ActiveController extends \yii\rest\Controller {

    public $isDev = false;

    public function init() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    }

    public function beforeAction($action) {
        if (parent::beforeAction($action)) {
            $param = \Yii::$app->getRequest()->getBodyParams();
            if (!empty($param['is_dev'])) {
                $this->isDev = true;
            }
            return true;
        }
        return false;
    }

    public function responseSave($model) {
        if (!empty(\Yii::$app->getRequest()->getBodyParams())) {
            $post = \Yii::$app->getRequest()->getBodyParams();
        } else {
            $post = \Yii::$app->getRequest()->post();
        }

        if ($model->load($post, '') && $model->save()) {
            return $this->responseSuccess(ArrayHelper::toArray($model));
        } else {
            return $this->responseFail($model->errors);
        }
    }
    
    public function responseSuccess($data) {
        return [
            'status' => 200,
            'code'   => 1,
            'data'   => $data
        ];
    }
    
    public function responseFail($data) {
        return [
            'status' => 200,
            'code'   => 0,
            'data'   => $data
        ];
    }

}
