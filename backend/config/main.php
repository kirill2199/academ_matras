<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $params['bootstrap'][] = 'debug';
    $params['modules']['debug'] = [
        'class' => \yii\debug\Module::class,
        'allowedIPs' => ['*'],
    ];

    $params['bootstrap'][] = 'gii';
    $params['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['*'],
        'generators' => [ // here
            'crud' => [ // generator name
                'class' => 'yii\gii\generators\crud\Generator', // generator class
                'templates' => [ // setting for our templates
                    'yii2-adminlte3' => '@vendor/hail812/yii2-adminlte3/src/gii/generators/crud/default' // template name => path to template
                ]
            ]
        ]
    ];
}
return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log', 'debug'], // Добавляем debug в bootstrap
    'modules' => [
        'debug' => [
            'class' => \yii\debug\Module::class,
            'allowedIPs' => ['127.0.0.1', '::1', '*'], // Убедитесь что ваш IP разрешен
        ],
        'gii' => [
            'class' => \yii\gii\Module::class,
            'allowedIPs' => ['127.0.0.1', '::1', '*'], // Убедитесь что ваш IP разрешен
        ],
        'shop-category' => [
            'class' => 'backend\modules\Category\Category',
            // ... другие настройки модуля ...
        ],
        'shop-product' => [
            'class' => 'backend\modules\Product\Product',
            // ... другие настройки модуля ...
        ],
        'shop-menu' => [
            'class' => 'backend\modules\Menu\Menu',
        ],
        'shop-menu-item' => [
            'class' => 'backend\modules\MenuItem\MenuItem',
        ],
        // 'shop-order' => [
        //     'class' => 'backend\modules\Order\Order',
        // ],
        // 'shop' => [
        //     'class' => 'backend\modules\Shop\Shop',
        //     // ... другие настройки модуля ...
        // ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            'cookieValidationKey' => 'DYsfgi7TbaKxJJ9Xz5jGPF41YvICLYLf',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        // 'view' => [
        //     'theme' => [
        //         'pathMap' => [
        //             '@app/views' => '@vendor/hail812/yii2-adminlte3/src/views'
        //         ],
        //     ],
        // ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                // Правила для модулей
                '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',

                // Правила для контроллеров
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',

            ],
        ],
    ],
    'params' => $params,
];
