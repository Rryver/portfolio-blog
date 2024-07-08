<?php

namespace common\components\integrations\boxberry\apiClient;

use common\components\integrations\common\ApiClientAbstract;
use Yii;
use yii\base\InvalidArgumentException;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\httpclient\Client;
use yii\httpclient\Request;
use yii\httpclient\Response;

/**
 * Class ApiClient
 * @package common\components\integrations\yandex\apiClient
 *
 * API Клиент для работы с доставкой Boxberry (доставка из города в город)
 *
 * Документация: https://help.boxberry.ru/pages/viewpage.action?pageId=762955
 *
 */
class ApiClientBoxberryDelivery extends ApiClientAbstract
{
    const BASE_URL = "https://api.boxberry.ru";
    const BASE_PATH = "/json.php";

    const DEV_TOKEN_PROD = 'fdsf23dascxz422112'; //Не рабочий, придуман для примера

    /**
     * Токен авторизации.
     *
     * Передается в:
     * - QueryParams, если запрос GET;
     * - В теле запроса ($data), если запрос POST
     * Заранее ложить токен в QueryParams или в $data не требуется. Это делается здесь в методе createRequest()
     *
     * Генерируется: В личном кабинете на сайте https://clients.nrg-tk.ru/token
     *
     * @var string
     */
    private $devToken;


    public function __construct($profile = self::PROFILE_PROD)
    {
        $this->setProfile($profile);

        if ($profile == self::PROFILE_PROD) {
            $this->baseUrl = self::BASE_URL;
            $this->devToken = self::DEV_TOKEN_PROD;
        } else if ($profile == self::PROFILE_STUBS) {
            $this->profile = self::PROFILE_STUBS;
        } else {
            throw new InvalidArgumentException("Неожиданное значение для переменной: profile");
        }
    }

    /**
     * @inheritDoc
     *
     * @param $timeout //Таймаут ожидания ответа. В секундах
     *
     * //TODO Создать интеграционный журнал. Добавитть логирование запросов и ответов https://www.yiiframework.com/extension/yiisoft/yii2-httpclient/doc/guide/2.0/en/usage-logging
     */
    public function sendRequest(string $method, string $apiMethod, $queryParams = null, $data = null, $timeout = null)
    {
        try {
            $request = $this->createRequest($method, $apiMethod, $queryParams, $data, true, $timeout);

            /** @var Response $response */
            $response = $request->send();
        } catch (\Exception $e) {
            $message = "Boxberry Delivery - API. Ошибка запроса " . $apiMethod . PHP_EOL .
                "Request: " . json_encode($data, JSON_UNESCAPED_UNICODE);

            if (isset($response)) {
                $message .= PHP_EOL . "Response: " . json_encode($response->getData(), JSON_UNESCAPED_UNICODE);
            }

            Yii::error($message);
            Yii::error($e->getMessage());

            return null;
        }

        $this->lastResponse = $response;

        return $response;
    }

    /**
     * @param string $method GET или POST запрос
     * @param string $apiMethod API метод, к которому необходимо обратиться
     * @param null $queryParams
     * @param null $data
     * @param bool $needDevToken
     * @param null $timeout //Таймаут ожидания ответа. В секундах
     * @return Request
     * @throws InvalidConfigException
     */
    private function createRequest($method, $apiMethod, $queryParams = null, $data = null, $needDevToken = true, $timeout = null)
    {
        /** @var Client $client */
        $client = new Client();

        $url = [$this->getBaseUrl() . self::BASE_PATH];

        if ($method === self::METHOD_GET) {
            $url["method"] = $apiMethod;
            if ($needDevToken) {
                $url["token"] = $this->getDevToken();
            }
        } else {
            $data["method"] = $apiMethod;
            if ($needDevToken) {
                $data["token"] = $this->getDevToken();
            }
        }

        if ($queryParams) {
            $url = ArrayHelper::merge($url, $queryParams);
        }

        $request = $client->createRequest()
            ->setUrl($url)
            ->setMethod($method)
            ->setFormat(Client::FORMAT_JSON);

        if ($timeout) {
            $request->setOptions([
                'timeout' => $timeout, //seconds
            ]);
        }

        if ($data) {
            $request->setData($data);
        }

        return $request;
    }

    private function getDevToken()
    {
        return $this->devToken;
    }
}