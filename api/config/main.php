<?php

use api\modules\v1\ApiModule;
use \yii\web\Request;

$s = DIRECTORY_SEPARATOR;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

$baseUrl = str_replace('/web', '', (new Request)->getBaseUrl());

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
//    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            'class' => ApiModule::class,
        ],
    ],
    'components' => [
        'request' => [
            'baseUrl' => $baseUrl,
            'cookieValidationKey' => '2vOYNWS4FM5xsurJMpmLf3kdCuc_U7SdhFzc1123vJqw123eeq2312w',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'response' => [
            'format' => yii\web\Response::FORMAT_JSON,
            'charset' => 'UTF-8',
            'on beforeSend' => function ($event) {
                header("Access-Control-Allow-Origin: *");
            }
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-api', 'httpOnly' => true],
            'enableSession' => false,
        ],
//        'session' => [
//            // this is the name of the session cookie used for login on the api
//            'name' => 'advanced-api',
//        ],
//        'errorHandler' => [
//            'errorAction' => 'site/error',
//        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => file_exists(__DIR__ . $s . 'rules.php') ? require_once(__DIR__ . $s . 'rules.php') : [],
        ],
    ],
    'params' => $params,
];
