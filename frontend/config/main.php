<?php

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'debug'], // Добавляем debug в bootstrap
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'cookieValidationKey' => 'DYsfgi7TbaKxJJ9Xz5jGPF41YvICLYLf',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            'name' => 'advanced-frontend',
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
    ],
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
            'class' => 'frontend\modules\Category\Category',
            // ... другие настройки модуля ...
        ],
        'shop-product' => [
            'class' => 'frontend\modules\Product\Product',
            // ... другие настройки модуля ...
        ],
        'shop-cart' => [
            'class' => 'frontend\modules\Cart\Cart',
            'controllerNamespace' => 'frontend\modules\Cart\controllers', // явно укажите namespace
        ],
        'shop-order' => [
            'class' => 'frontend\modules\Order\Order',
        ],
        'shop' => [
            'class' => 'frontend\modules\Shop\Shop',
            // ... другие настройки модуля ...
        ],

    ],
    'params' => $params,

];