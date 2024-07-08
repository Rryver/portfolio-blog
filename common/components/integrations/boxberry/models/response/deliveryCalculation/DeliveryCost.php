<?php


namespace common\components\integrations\boxberry\models\response\deliveryCalculation;


use common\components\integrations\common\CommonObject;

/**
 * Class DeliveryCost
 * @package common\components\integrations\boxberry\models\response\deliveryCalculation
 *
 * Вариант расчета для одного типа доставки
 */
class DeliveryCost extends CommonObject
{
    /**
     * Рассчитывается как TotalPrice – PriceBase
     * @var float
     */
    private $priceService;

    /**
     * Стоимость всех начисленных  услуг с учетом скидки, руб.
     * @var float|null
     */
    private $totalPrice;

    /**
     * Тип услуги доставки (common\components\integrations\boxberry\helpers\DeliveryType):
     * 1 склад-склад
     * 2 склад-дверь
     *
     * @var int
     */
    private $deliveryTypeId;

    /**
     * Срок доставки, дни
     * @var int
     */
    private $deliveryPeriod;

    /**
     * Стоимость базовой услуги
     * @var float
     */
    private $priceBase;


    /**
     * @return float
     */
    public function getPriceService(): float
    {
        return $this->priceService;
    }

    /**
     * @param float $priceService
     */
    public function setPriceService(float $priceService): void
    {
        $this->priceService = $priceService;
    }

    /**
     * @return float|null
     */
    public function getTotalPrice(): ?float
    {
        return $this->totalPrice;
    }

    /**
     * @param float|null $totalPrice
     */
    public function setTotalPrice(?float $totalPrice): void
    {
        $this->totalPrice = $totalPrice;
    }

    /**
     * @return int
     */
    public function getDeliveryTypeId(): int
    {
        return $this->deliveryTypeId;
    }

    /**
     * @param int $deliveryTypeId
     */
    public function setDeliveryTypeId(int $deliveryTypeId): void
    {
        $this->deliveryTypeId = $deliveryTypeId;
    }

    /**
     * @return int
     */
    public function getDeliveryPeriod(): int
    {
        return $this->deliveryPeriod;
    }

    /**
     * @param int $deliveryPeriod
     */
    public function setDeliveryPeriod(int $deliveryPeriod): void
    {
        $this->deliveryPeriod = $deliveryPeriod;
    }

    /**
     * @return float
     */
    public function getPriceBase(): float
    {
        return $this->priceBase;
    }

    /**
     * @param float $priceBase
     */
    public function setPriceBase(float $priceBase): void
    {
        $this->priceBase = $priceBase;
    }


}