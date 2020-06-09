<?php
namespace app\modules\v1\controllers;

use Yii;
use yii\web\Controller;



/**
 * Site controller
 */
class DefaultController extends Controller
{        

    
    public function actionError() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON; 
        return [
            'status' => Yii::$app->getErrorHandler()->exception->statusCode,
            'code' => Yii::$app->getErrorHandler()->exception->getCode(),
            'error' => [
                'dev' => empty(\Yii::$app->controller->isDev)
                    ? [
                        'message' => Yii::$app->getErrorHandler()->exception->getMessage(),
                        'file' => Yii::$app->getErrorHandler()->exception->getFile(),
                        'line' => Yii::$app->getErrorHandler()->exception->getLine(),
                        'trace' => Yii::$app->getErrorHandler()->exception->getTrace(),
                    ]
                    : null,
            ]
        ];
    }
}
