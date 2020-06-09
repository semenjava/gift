<?php

namespace app\modules\v1_1;

use app\modules\v1_1\components\ErrorHandler;

class Module extends \yii\base\Module {

	public $controllerNamespace = 'app\modules\v1_1\controllers';

    public function beforeAction($action)
    {
        parent::init();
        \Yii::configure($this, [
            'components' => [
                'errorHandler' => [
                    'class' => ErrorHandler::className(),
                    'errorAction' => '/v1_1/default/error',
                ]
            ],
        ]);

        /** @var ErrorHandler $handler */
        $handler = $this->get('errorHandler');
        \Yii::$app->set('errorHandler', $handler);
        $handler->register();

         return parent::beforeAction($action);
    }
    
	public function init() {
		parent::init();
		\Yii::$app->user->enableSession = false;
	}

}
