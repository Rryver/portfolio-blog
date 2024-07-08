<?php

use yii\caching\FileCache;
use yii\i18n\PhpMessageSource;
use yii\log\DbTarget;
use yii\rbac\DbManager;
use yii2mod\settings\components\Settings;

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => FileCache::class,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => DbTarget::class,
                    //'categories' => ['app\models\*', 'app\backend\*'],
                    'levels' => ['error', 'warning'],
                    'logVars' => [],
                    'except' => [
                        "yii\debug\Module::checkAccess",
                    ],
                ],
            ],
        ],
        'authManager' => [
            'class' => DbManager::class,
        ],
        'i18n' => [
            'translations' => [
                'app' => [
                    'class' => PhpMessageSource::class,
                    'basePath' => '@common/messages',
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app'       => 'app.php',
                    ],
                ],
                'yii2mod.settings' => [
                    'class' => PhpMessageSource::class,
                    'basePath' => '@yii2mod/settings/messages',
                ],
            ],
        ],
        'settings' => [
            'class' => 'yii2mod\settings\components\Settings',
        ],
        'formatter' => [
            'locale' => 'ru-RU',
            'dateFormat' => 'dd.MM.yyyy',
            'datetimeFormat' => 'dd.MM.yyyy HH:mm:ss',
            'booleanFormat' => ['Нет', 'Да'],
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'currencyCode' => 'EUR',
            'nullDisplay' => '&nbsp;',
        ],
//        'mailer' => [
//            'class' => \yii\symfonymailer\Mailer::class,
//            'viewPath' => '@app/mail',
//            // send all mails to a file by default.
//            'useFileTransport' => false,
//
//            'transport' => [
//                'scheme' => 'smtps',
//                'host' => 'smtp.yandex.com',
//                'username' => 'ryver.mailer@yandex.ru',
//                'password' => 'ihwwerbyexvjhmxr',
//                'port' => 465,
//                //'dsn' => 'native://default',
//            ],
//        ],
    ],
];
