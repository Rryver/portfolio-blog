<?php


namespace api\modules\v1\requestModels;


use Yii;
use yii\base\InvalidConfigException;
use yii\data\DataFilter;

abstract class BaseRequestModel extends DataFilter
{
    /**
     * @var bool
     */
    private $isLoaded = false;

    /**
     * @var bool
     */
    private $isValidated = false;

    /**
     * @throws InvalidConfigException
     */
    public function loadAndValidate()
    {
        $requestParams = Yii::$app->getRequest()->getBodyParams();
        if (empty($requestParams)) {
            $requestParams = Yii::$app->getRequest()->getQueryParams();
        }

        $filter = null;
        if ($this->load($requestParams)) {
            $this->isLoaded = true;
        } else {
            $this->isLoaded = false;
        }

        $filter = $this->build();
        if ($filter === false) {
            $this->isValidated = false;
        } else {
            $this->isValidated = true;
        }
    }

    /**
     * @return bool
     */
    public function isLoaded(): bool
    {
        return $this->isLoaded;
    }

    /**
     * @param bool $isLoaded
     */
    public function setIsLoaded(bool $isLoaded): void
    {
        $this->isLoaded = $isLoaded;
    }

    /**
     * @return bool
     */
    public function isValidated(): bool
    {
        return $this->isValidated;
    }

    /**
     * @param bool $isValidated
     */
    public function setIsValidated(bool $isValidated): void
    {
        $this->isValidated = $isValidated;
    }
}