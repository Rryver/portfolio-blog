<?php


namespace api\modules\v1\dataAccess;


use api\modules\v1\requestModels\BaseRequestModel;
use yii\base\InvalidConfigException;

abstract class BaseDaService
{
    /**
     * @var BaseRequestModel
     */
    protected $requestModelClass;

    /**
     * @return BaseRequestModel
     * @throws InvalidConfigException
     */
    public function getData()
    {
        if ($this->requestModelClass) {
            $requestModel = $this->requestModelClass;
            $requestModel->loadAndValidate();
            if ($requestModel->isLoaded()) {
                if (!$requestModel->isValidated()) {
                    return $requestModel;
                }
            }
        }

        return $this->processData();
    }

    abstract function processData();
}