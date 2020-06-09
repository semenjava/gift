<?php

$config = [
    'components' => [
//	        'urlManagerFrontend' => [
//            'class' => 'yii\web\urlManager',
////            'baseUrl' => FRONTEND_BASE_URL,
//            'enablePrettyUrl' => true,
//            'showScriptName' => false,
//        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'yzV0rS_DbrFduSw8DvOx_YyFdIV3jhln',
        ],
	],
];


if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
