<?php
$params = array_merge(
    require(__DIR__ . '/../../www/common/config/params.php'),
    require(__DIR__ . '/../../www/common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        'gii'
        ],
    'modules' => [
        'gii' => [
            // path to the code generation tool
		'class' => 'yii\gii\Module',

		// IPs from which code generation is allowed; when site is accessed from non-listed IP code generation would be disabled
		'allowedIPs' => ['127.0.0.1', '::1', '93.183.233.235'],
		'generators' => [

			// code generator
			'crud' => [

			// path to the code generator
			'class' => 'yii\gii\generators\crud\Generator',

			// path to the template for CRUD code generation
			'templates' => ['CustomCrud' => '@app/templates/crud/custom']
			]
		]
        ],
    ],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
		'formatter' => [
			'currencyCode' => 'USD',
		],
		'assetManager' => [
			'bundles' => [
				'yii\bootstrap\BootstrapAsset' => [
						'basePath' => '@webroot',
						'baseUrl' => '@web/frontend/assets',
				],
			],
		],
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'practical-a-frontend',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [

            ],
        ],

    ],
    'params' => $params,
];
