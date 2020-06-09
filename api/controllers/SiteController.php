<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\VarDumper;
use common\models\LoginForm;
use app\modules\v1\components\ExceptionAction;


/**
 * Site controller
 */
class SiteController extends Controller
{        
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
//    
//    public function actions()
//    {
//        $exception = Yii::$app->errorHandler->exception;
//        if ($exception !== null) {
//            if(!empty($exception->statusCode)) {
//                $result =  new ExceptionAction($exception->statusCode);
//            } else {
//                $result =  new ExceptionAction(500);
//            }
//            
//            return $result;
//        }
//    }

    /**
     * @inheritdoc
     */
//    public function actions()
//    {
//        return [
//            'error' => [
//                'class' => 'yii\web\ErrorAction',
//            ],
//        ];
//    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    
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
