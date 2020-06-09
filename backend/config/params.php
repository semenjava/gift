<?php

use yii\helpers\Url;

return [
    'adminEmail' => 'admin@example.com',
    'rules' => [
        [
            'actions' => ['index', 'error'],
            'allow' => true,
            'roles' => ['@'],
        ],
        [
            'actions' => ['view', 'error'],
            'allow' => true,
            'roles' => ['@'],
        ],
        [
            'actions' => ['create', 'error'],
            'allow' => true,
            'roles' => ['@'],
        ],
        [
            'actions' => ['update', 'error'],
            'allow' => true,
            'roles' => ['@'],
        ],
        [
            'actions' => ['delete', 'error'],
            'allow' => true,
            'roles' => ['@'],
        ],
    ],
    'active_input' => ['' => 'All', 1 => 'Yes', 0 => 'No' ], 
    
    'redirect' => function ($url) {
        $url = Url::toRoute($url);
        header("Location: $url");die();
    }
];
