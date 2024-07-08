<?php


namespace common\components\delivery\deliveryOutputCreator;


use common\components\delivery\deliveryOutputCreator\common\DeliveryCreateException;
use common\components\delivery\deliveryOutputCreator\common\NeedUnsetDeliveryModelException;
use common\components\integrations\boxberry\BoxberryDeliveryClient;
use common\components\integrations\boxberry\helpers\DeliveryType;
use common\components\integrations\boxberry\models\request\deliveryCalculation\BoxSize;
use common\components\integrations\boxberry\models\request\DeliveryCalculationRequest;
use common\components\integrations\boxberry\models\response\DeliveryCalculationResponse;
use common\components\utils\Utils;
use common\models\CityBoxberry;
use yii\base\Exception;

/**
 * Class DeliveryOutputCreatorBoxberry
 * @package common\components\delivery\integrationsOutputCreator
 *
 * Курьерская доставка Boxberry
 */
class DeliveryOutputCreatorBoxberry extends DeliveryOutputCreatorAbstract
{
    /**
     * Тип доставки курьером
     * @return string
     */
    protected function getDeliveryType()
    {
        return DeliveryType::COURIER;
    }

    /**
     * @inheritDoc
     */
    protected function calculateExternalDeliveryInfo()
    {
        $boxberryDeliveryClient = new BoxberryDeliveryClient();

        $cityModel = $this->cityModelTo;
        $cityBoxberry = $cityModel->cityBoxberry;

        if (!$cityBoxberry || !$this->hasDeliveryInCity($cityBoxberry)) {
            $this->deliveryOutput->setError(true);
            $this->deliveryOutput->setDescription("Выбранный город недоступен для досавки");
            throw new NeedUnsetDeliveryModelException();
        }

        $boxSizes = [
            new BoxSize($this->cart->getWeight())
        ];

        $cityIdTo = $cityBoxberry->boxberry_id;
        $cart_sum = $this->cart->getSum();
        $deliveryType = $this->getDeliveryType();

        $deliveryCalculationRequest = new DeliveryCalculationRequest($cityIdTo, $boxSizes, $deliveryType, $cart_sum);

        $deliveryCalculation = $boxberryDeliveryClient->calculate($deliveryCalculationRequest);

        if (!$deliveryCalculation->isSuccess() || empty($deliveryCalculation->getDeliveryCosts())) {
            throw new DeliveryCreateException();
        }

        $this->externalDeliveryInfo = $deliveryCalculation;
    }

    /**
     * @inheritDoc
     */
    protected function fillPrice()
    {
        /** @var DeliveryCalculationResponse $boxberryResponse */
        $boxberryResponse = $this->externalDeliveryInfo;

        $deliveryCost = $boxberryResponse->findDeliveryCost($this->getDeliveryType());
        $deliveryPrice = $deliveryCost->getTotalPrice();
        $this->deliveryOutput->setPrice($deliveryPrice);
    }

    /**
     * @inheritDoc
     */
    protected function fillTimeInterval()
    {
        /** @var DeliveryCalculationResponse $boxberryResponse */
        $boxberryResponse = $this->externalDeliveryInfo;

        $deliveryCost = $boxberryResponse->findDeliveryCost($this->getDeliveryType());
        $daysCount = $deliveryCost->getDeliveryPeriod();

        if ($daysCount == 1) {
            $deliveryTime = $daysCount . ' день';
        } else {
            $deliveryTime = 'до ' . $daysCount . ' дней';
        }

        $this->deliveryOutput->setTimeInterval($deliveryTime);
    }

    /**
     * @inheritDoc
     */
    protected function fillDeliveryDate()
    {
        /** @var DeliveryCalculationResponse $boxberryResponse */
        $boxberryResponse = $this->externalDeliveryInfo;

        $deliveryCost = $boxberryResponse->findDeliveryCost($this->getDeliveryType());
        $daysCount = $deliveryCost->getDeliveryPeriod();
        $deliveryDate = Utils::addDaysToCurrentDate($daysCount);
        $this->deliveryOutput->setDeliveryDate($deliveryDate);
    }

    /**
     * @param CityBoxberry $cityBoxberry
     * @return bool
     * @throws Exception
     */
    protected function hasDeliveryInCity(CityBoxberry $cityBoxberry)
    {
        $deliveryType = $this->getDeliveryType();

        if ($deliveryType == DeliveryType::PICKUP) {
            return $cityBoxberry->pickup_point;
        } else if ($deliveryType == DeliveryType::COURIER) {
            return $cityBoxberry->courier_delivery;
        } else {
            throw new Exception("Неожиданное значение deliveryType");
        }
    }
}