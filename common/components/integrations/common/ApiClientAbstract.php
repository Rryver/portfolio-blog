<?php

namespace common\components\integrations\common;

use yii\httpclient\Response;

abstract class ApiClientAbstract
{
    const METHOD_POST = "POST";
    const METHOD_GET = "GET";

    const PROFILE_PROD = 'prod'; //Отправка запросов к реальным серверам
    const PROFILE_TEST = 'test'; //Запросы будут отправлены к тестовому серверу доставки
    const PROFILE_STUBS = 'stubs'; //Данные будут взяты из заглушек (из заранее подготовленного json файла)

    /**
     * Базовый путь запросов
     * @var string
     */
    protected $baseUrl;

    /**
     * Режим работы.
     * Возможные варианты в константах выше
     * @var boolean
     */
    protected $profile;

    /**
     * Ответ последнего запроса
     * @var Response|null
     */
    protected $lastResponse = null;

    /**
     * @param string $profile
     */
    abstract function __construct(string $profile = self::PROFILE_PROD);

    /**
     * Отправка запроса с переданными параметрами
     * @param string $method POST или GET
     * @param string $apiMethod Путь до метода (все, что после BASE_URL)
     * @param null $queryParams
     * @param array|null $data Тело запроса
     * @return Response
     */
    abstract function sendRequest(string $method, string $apiMethod, $queryParams = null, $data = null);

    /**
     * @param bool $profile
     */
    public function setProfile(bool $profile)
    {
        $this->profile = $profile;
    }

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * @param string $baseUrl
     */
    public function setBaseUrl(string $baseUrl): void
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @return Response|null
     */
    public function getLastResponse(): ?Response
    {
        return $this->lastResponse;
    }
}