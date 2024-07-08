<?php

namespace common\components\integrations\boxberry\models\response;

use common\components\integrations\boxberry\models\response\deliveryCalculation\DeliveryCost;

class DeliveryCalculationResponse extends BaseBoxberryResponse
{
    /**
     * Массив вариантов расчетов для разных типов доставки
     * @var DeliveryCost[]
     */
    private $deliveryCosts;

    /**
     * @return DeliveryCost[]
     */
    public function getDeliveryCosts(): array
    {
        return $this->deliveryCosts;
    }

    /**
     * @param DeliveryCost[] $deliveryCosts
     */
    public function setDeliveryCosts(array $deliveryCosts): void
    {
        foreach ($deliveryCosts as $deliveryCost) {
            if ($deliveryCost instanceof DeliveryCost) {
                $this->deliveryCosts[] = $deliveryCost;
            } else {
                $this->deliveryCosts[] = new DeliveryCost($deliveryCost);
            }
        }
    }

    /**
     * Находит объект доставки по необходиомму типу
     * - до пвз
     * - курьером
     *
     * @param string $deliveryType Тип доставки:  (см. common\components\integrations\boxberry\helpers\DeliveryType)
     * @return DeliveryCost
     */
    public function findDeliveryCost(string $deliveryType)
    {
        foreach ($this->deliveryCosts as $deliveryCost) {
            if ($deliveryCost->getDeliveryTypeId() == $deliveryType) {
                return $deliveryCost;
            }
        }
    }
}