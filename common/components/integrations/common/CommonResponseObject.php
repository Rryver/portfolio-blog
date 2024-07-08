<?php


namespace common\components\integrations\common;


use yii\base\InvalidCallException;
use yii\helpers\Inflector;

/**
 * Class CommonResponseObject
 * @package common\components\delivery\yandex\models\common
 *
 * Базовый класс ответа
 *
 * Параметры, которые не удалось распарсить и записать в переменную, будут записаны в additionalParams
 *
 * Если переменная помечена как [required] значит она обязательно придет в ответе
 * Если перменная не отмечена как [required] или помечена как [optional] значит она не может быть не заполнена после получения ответа
 */
abstract class CommonResponseObject extends CommonObject
{
    const DEFAULT_ERROR_DETAILS = "Произошла ошибка. Пожалуйста, попробуйте еще раз позже";

    /**
     * Http код ответа
     * @var int|null
     */
    protected $statusCode;

    /**
     * Статус операции запроса
     * @var bool
     */
    protected $success;

    /**
     * CommonResponseObject constructor.
     * @param array $config
     * @param int|null $httpCode
     */
    public function __construct($config = [],
                                ?int $httpCode = null)
    {
        $this->statusCode = $httpCode;
        if ($httpCode >= 200 && $httpCode <= 299) {
            $this->success = true;
        } else {
            $this->success = false;
        }

        parent::__construct($config);
    }

    /**
     * @return int|null
     */
    public function getStatusCode(): ?int
    {
        return $this->statusCode;
    }

    /**
     * @param int|null $statusCode
     */
    public function setStatusCode(?int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->success;
    }

    /**
     * @param bool $success
     */
    public function setSuccess(bool $success): void
    {
        $this->success = $success;
    }
}