<?php

namespace app\modules\v1_1\components;

use app\models\LoginForm;
use yii\helpers\ArrayHelper;
use app\modules\v1_1\components\ExceptionAction;
use yii\web\BadRequestHttpException;

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
            return $this->responseErrorValid($model->errors);
        }
		
		$this->responseFail('Could not save');
    }
    
    public function responseSuccess($data) {
        return [
            'code' => 200,
            'data'   => $data
        ];
    }
	
	public function responseErrorValid($error) {
        return [
            'code' => 200,
            'error'   => $error
        ];
    }
    
    public function responseFail($message='Bad Request') {
		throw new BadRequestHttpException($message);
    }

}
