<?php


namespace common\components\integrations\common;


use yii\base\Arrayable;
use yii\base\ArrayableTrait;
use yii\base\BaseObject;
use yii\base\InvalidCallException;
use yii\helpers\Inflector;

abstract class CommonObject extends BaseObject implements Arrayable
{
    use ArrayableTrait;

    /**
     * Переопределен для игнорирования неожиданных значений (например, которые приходят в ответе)
     * @inheritDoc
     */
    public function __set($name, $value)
    {
        $nameCamelCase = Inflector::variablize($name);

        $setter = 'set' . $nameCamelCase;
        $getter = 'get' . $nameCamelCase;
        if (method_exists($this, $setter)) {
            $this->$setter($value);
        } elseif (method_exists($this, $getter)) {
            throw new InvalidCallException('Setting read-only property: ' . get_class($this) . '::' . $nameCamelCase);
        }
    }
}