<?php


namespace api\modules\v1\requestModels;


use common\components\utils\Utils;
use ReflectionClass;
use ReflectionException;
use yii\base\Model;
use yii\web\BadRequestHttpException;

abstract class BaseRequestModel extends Model
{
    /**
     * @inheritDoc
     *
     * @throws BadRequestHttpException
     */
    public function __construct($config = [])
    {
        parent::__construct($config);

        if (!$this->validate()) {
            throw new BadRequestHttpException(Utils::errorsToStr($this->getErrors()));
        }
    }

    /**
     * @inheritDoc
     *
     * @throws ReflectionException
     */
    public function attributes()
    {
        $class = new ReflectionClass($this);
        $names = [];
        foreach ($class->getProperties() as $property) {
            if (!$property->isStatic()) {
                $names[] = $property->getName();
            }
        }

        return $names;
    }
}