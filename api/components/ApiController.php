<?php


namespace api\components;


use yii\filters\auth\HttpBasicAuth;
use yii\rest\Controller;

abstract class ApiController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::class,
        ];
        return $behaviors;
    }
}