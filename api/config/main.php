<?php

require(__DIR__ . '/settings.php');
$params = array_merge(
        require(__DIR__ . '/../../www/common/config/params.php'), require(__DIR__ . '/../../www/common/config/params-local.php'), require(__DIR__ . '/params.php'), require(__DIR__ . '/params-local.php')
);

$rules = array_merge(
		require(__DIR__ . '/v1.php'),
		require(__DIR__ . '/v1_1.php')
		);

return [
    'id' => 'app-scout-zoo-api',
    'name' => 'ScoutZoo',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'gii'],
    'modules' => [
        'v1' => [
            //'basePath' => '@app',
            'class' => 'app\modules\v1\Module'
        ],
		'v1_1' => [
            //'basePath' => '@app',
			'class' => 'app\modules\v1_1\Module'
        ],
        'gii' => [
            // path to the code generation tool
		'class' => 'yii\gii\Module',

		// IPs from which code generation is allowed; when site is accessed from non-listed IP code generation would be disabled
		'allowedIPs' => ['127.0.0.1', '::1', '192.168.5.*'],
		'generators' => [

			// code generator
			'crud' => [

			// path to the code generator
			'class' => 'yii\gii\generators\crud\Generator',

			// path to the template for CRUD code generation
			]
		]
        ]
    ],
    'components' => [
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableSession' => false
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => $rules,
        ],
    ],
    'params' => $params,
];
