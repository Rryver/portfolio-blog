<?php


namespace common\components\integrations\boxberry;


use common\components\integrations\boxberry\apiClient\ApiClientBoxberryDelivery;
use common\components\integrations\boxberry\models\request\DeliveryCalculationRequest;
use common\components\integrations\boxberry\models\request\ListCitiesFullRequest;
use common\components\integrations\boxberry\models\request\ListPointsRequest;
use common\components\integrations\boxberry\models\response\DeliveryCalculationResponse;
use common\components\integrations\boxberry\models\response\ListCitiesFullResponse;
use common\components\integrations\boxberry\models\response\ListPointsResponse;
use yii\httpclient\Response;

/**
 * Class BoxberryDeliveryClient
 * @package common\components\integrations\boxberry
 *
 * Класс взаимодействия с АПИ Boxberry
 *
 * Документация АПИ: https://help.boxberry.ru/pages/viewpage.action?pageId=762955
 *
 * АПИ-токен: e931s2334xt642fdf52339a (Не рабочий, придуман для примера)
 *
 * Сервис технической поддержки: https://ссылка на сервис тех.поддержки (ссылка вроде как выдается лично клиенту)
 * Логин: example@example.ru
 * Пароль: example
 */
class BoxberryDeliveryClient
{
    const CITY_ID_SOURCE = "123123"; //ID Города отправителя в системе Boxberry

    public $apiClient;

    /**
     * EnergyDeliveryClient constructor.
     * @param string $profile
     */
    function __construct($profile = ApiClientBoxberryDelivery::PROFILE_PROD)
    {
        $this->apiClient = new ApiClientBoxberryDelivery($profile);
    }

    /**
     * Позволяет получить стоимость доставки заказа по направлениям:
     * - Отделение → Отделение / Индекс (для КД РФ) / Город
     * - Город → Город / Отделение / Индекс (для КД РФ)
     * с учётом стоимости постоянных услуг, предусмотренных Вашим договором.
     *
     * Метод служит только для расчета стоимости доставки и не осуществляет проверку. В случае передачи, например:
     * - почтового индекса/города по которому не осуществляется КД,
     * - кода пункта выдачи не осуществляющего выдачу посылок,
     * - кода пункта выдачи не существующего в Boxberry,
     *
     * @param DeliveryCalculationRequest $deliveryCalculationRequest
     * @return DeliveryCalculationResponse
     */
    public function calculate(DeliveryCalculationRequest $deliveryCalculationRequest)
    {
        $response = $this->apiClient->sendRequest(ApiClientBoxberryDelivery::METHOD_POST, "DeliveryCalculation", "", $deliveryCalculationRequest->toArray(), 5);

        if ($response instanceof Response) {
            $data = $response->getData();
            if ($response->isOk && array_key_exists('result', $data)) {
                $data = $data["result"];
            }

            return new DeliveryCalculationResponse($data, $response->statusCode);
        }

        return new DeliveryCalculationResponse();
    }

    /**
     * Позволяет получить список городов (РФ и другие страны), в которых осуществляется доставка Boxberry.
     * Рекомендуемая частота обновления данных: 1 раз в день.
     *
     * @param ListCitiesFullRequest $listCitiesFullRequest
     * @return ListCitiesFullResponse
     */
    public function listCitiesFull(ListCitiesFullRequest $listCitiesFullRequest)
    {
        $response = $this->apiClient->sendRequest(ApiClientBoxberryDelivery::METHOD_GET, "ListCitiesFull", $listCitiesFullRequest->toArray());

        if ($response instanceof Response) {
            $data = $response->getData();
            if ($response->isOk && !array_key_exists('error', $data)) {
                $data["boxberryCities"] = $data;
            }

            return new ListCitiesFullResponse($data, $response->statusCode);
        }

        return new ListCitiesFullResponse();
    }

    /**
     * Позволяет получить информацию о всех точках выдачи заказов.
     * Рекомендуемая частота обновления данных: 1 раз в час.
     *
     * @param ListPointsRequest $listPointsRequest
     * @return ListPointsResponse
     */
    public function listPoints(ListPointsRequest $listPointsRequest)
    {
        $response = $this->apiClient->sendRequest(ApiClientBoxberryDelivery::METHOD_GET, "ListPoints", $listPointsRequest->toArray());

        if ($response instanceof Response) {
            $data = $response->getData();
            if ($response->isOk && !array_key_exists('error', $data)) {
                $data["listPoints"] = $data;
            }
            return new ListPointsResponse($data, $response->statusCode);
        }

        return new ListPointsResponse();
    }
}