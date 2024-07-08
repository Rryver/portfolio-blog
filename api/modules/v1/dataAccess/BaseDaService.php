<?php


namespace api\modules\v1\dataAccess;


use api\modules\v1\requestModels\BaseRequestModel;
use yii\base\InvalidConfigException;

abstract class BaseDaService
{
    abstract function getData();
}