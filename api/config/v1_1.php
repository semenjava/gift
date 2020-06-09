<?php

return		[
				[
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1_1/user',
                    'tokens' => [
                        '{id}' => '<id:\\w+>',
                        '{limit}' => '<limit:\\w+>',
                        '{mode}' => '<mode:\\w+>',
                        '{v}' => '<v:\\w+\\.\\w+\\.\\w+>',
                    ],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET partial-upload-log' => 'partial-upload-log',
                        'PUT update-user/{id}' => 'update-user',
                        'POST login' => 'login',
                        'POST check-access-token' => 'check-access-token',
                        'POST check-facebook-token' => 'check-facebook-token',
                        'POST change-password/{id}' => 'change-password',
                        'POST reset' => 'reset',
                        'POST search/{id}' => 'search',
                        'GET get/{id}' => 'get',
                        'GET profile/{id}' => 'profile',
                        'POST create' => 'create',
                        'PUT update/{id}' => 'update',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1_1/product',
                    'tokens' => [
                        '{id}' => '<id:\\w+>',
                        '{id_category}' => '<id_category:\\w+>',
                        '{limit}' => '<limit:\\w+>',
                        '{offset}' => '<offset:\\w+>',
                        '{name}' => '<name:\\w+>',
                    ],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET get-list/{id_category}/{limit}/{offset}' => 'get-list',
                        'GET get/{id}' => 'get',
                        'GET search/{name}' => 'search',
                        'GET search/{name}/{id_category}' => 'search',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1_1/category',
                    'tokens' => [
                        '{id}' => '<id:\\w+>',
                    ],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET get-list' => 'get-list',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1_1/holiday',
                    'tokens' => [
                        '{id}' => '<id:\\w+>',
                    ],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET get-list' => 'get-list',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1_1/gift-receiver',
                    'tokens' => [
                        '{id}' => '<id:\\w+>',
                        '{gender}' => '<gender:\\w+>',
                        '{id_user}' => '<id_user:\\w+>',
                        '{limit}' => '<limit:\\w+>',
                        '{offset}' => '<offset:\\w+>',
                    ],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET get/{id}' => 'get',
                        'GET get-receiver-by-gender/{gender}' => 'get-receiver-by-gender',
                        'GET get-list-gender' => 'get-list-gender',
						'GET get-address-type' => 'get-address-type',
						'GET get-country' => 'get-country',
                        'GET get-receiver-user/{id_user}' => 'get-receiver-user',
                        'GET get-list/{id_user}/{limit}/{offset}' => 'get-list',
                        'POST create' => 'create',
                        'PUT update/{id}' => 'update',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1_1/dates',
                    'tokens' => [
                        '{id}' => '<id:\\w+>',
                        '{id_gift_receiver}' => '<id_gift_receiver:\\w+>',
						'{name}' => '<name:\\w+>',
						'{month}' => '<month:\\w+>',
						'{year}' => '<year:\\w+>',
                    ],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET get/{id}' => 'get',
                        'GET get-list/{id_gift_receiver}' => 'get-list',
						'GET get-tag/{name}' => 'get-tag',
						'GET get-day/{month}' => 'get-day',
						'GET get-day/{month}/{year}' => 'get-day',
                        'POST create' => 'create',
                        'PUT update/{id}' => 'update',
                        'POST del/{id}' => 'del',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1_1/gift',
                    'tokens' => [
                        '{id}' => '<id:\\w+>',
                        '{id_dates}' => '<id_dates:\\w+>',
                        '{id_category}' => '<id_category:\\w+>',
                        '{id_product}' => '<id_product:\\w+>',
                        '{from}' => '<from:\\w+>',
                        '{to}' => '<to:\\w+>',
                        '{limit}' => '<limit:\\w+>',
                        '{offset}' => '<offset:\\w+>',

                    ],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET get/{id}' => 'get',
                        'GET get-list/{id_dates}' => 'get-list',
                        'POST create' => 'create',
                        'PUT update/{id}' => 'update',
                        'POST del/{id}' => 'del',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1_1/parcel',
                    'tokens' => [
                        '{id}' => '<id:\\w+>',
                        '{id_gift}' => '<id_gift:\\w+>',
                        '{limit}' => '<limit:\\w+>',
                        '{offset}' => '<offset:\\w+>',
                    ],
                    'pluralize' => false,
                    'extraPatterns' => [
						'GET get/{id}' => 'get',
                        'GET get-list/{id_gift}/{limit}/{offset}' => 'get-list',
                    ]
                ]
			];
