<?php

return [

//    [
//        'class' => 'yii\rest\UrlRule',
////        'pluralize' => false,
//        'controller' => 'bonus',
//        'only' => ['index', 'view', 'test'],
//    ],

    'v1/<controller:\w+>/<id:\d+>' => 'v1/<controller>/view',
    'v1/<controller:\w+>/<action:\w+>/<id:\d+>' => 'v1/<controller>/<action>',
    'v1/<controller:\w+>/<action:\w+>/*' => 'v1/<controller>/<action>',

    '<controller:\w+>/<id:\d+>' => '<controller>/view',
    '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
    '<controller:\w+>/<action:\w+>/*' => '<controller>/<action>',
];