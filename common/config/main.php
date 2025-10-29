<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
        'db' => [
            'class' => \yii\db\Connection::class,
            'dsn' => 'mysql:host=' . ($_ENV['DB_HOST'] ?? getenv('DB_HOST')) . ';dbname=' . ($_ENV['DB_NAME'] ?? getenv('DB_NAME')),
            'username' => $_ENV['DB_USER'] ?? getenv('DB_USER'),
            'password' => $_ENV['DB_PASSWORD'] ?? getenv('DB_PASSWORD'),
            'charset' => 'utf8',
        ],
    ],
];
