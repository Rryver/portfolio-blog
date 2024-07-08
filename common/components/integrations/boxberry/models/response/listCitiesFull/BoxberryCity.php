<?php


namespace common\components\integrations\boxberry\models\response\listCitiesFull;


use common\components\integrations\common\CommonObject;

class BoxberryCity extends CommonObject
{
    /**
     * Наименование города
     * @var string
     */
    private $name;

    /**
     * Код города в boxberry
     * @var string
     */
    private $code;

    /**
     * Код страны
     * @var string|null
     */
    private $countryCode;

    /**
     * Префикс: г - Город, п - Поселок и т.д.
     * @var string|null
     */
    private $prefix;

    /**
     * Прием писем и посылок от физ. лиц (0/1)
     * @var string|null
     */
    private $receptionLaP;

    /**
     * Выдача писем и посылок физ. лиц (0/1)
     * @var string|null
     */
    private $deliveryLaP;

    /**
     * Прием заказов от ИМ на пунктах выдачи (0/1)
     * @var string|null
     */
    private $reception;

    /**
     * Прием международных возвратов (0/1)
     * @var string|null
     */
    private $foreignReceptionReturns;

    /**
     * Наличие терминала в городе (0/1)
     * @var string
     */
    private $terminal;

    /**
     * ИД КЛАДРа
     * Может приходить пустая строка
     * @var string|null
     */
    private $kladr;

    /**
     * Наличие пунктов выдачи заказов в городе (0/1)
     * @var bool
     */
    private $pickupPoint;

    /**
     * Наличие курьерской доставки в городе (0/1)
     * @var string
     */
    private $courierDelivery;

    /**
     * Область
     * @var string|null
     */
    private $region;

    /**
     * Составное уникальное имя (для городов с не уникальным наименованием город + область + район)
     * @var string|null
     */
    private $uniqName;

    /**
     * Район
     * @var string|null
     */
    private $district;


    /**
     * Наличие курьерского забора (0/1)
     * @var string
     */
    private $courierReception;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return string|null
     */
    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    /**
     * @param string|null $countryCode
     */
    public function setCountryCode(?string $countryCode): void
    {
        $this->countryCode = $countryCode;
    }

    /**
     * @return string|null
     */
    public function getPrefix(): ?string
    {
        return $this->prefix;
    }

    /**
     * @param string|null $prefix
     */
    public function setPrefix(?string $prefix): void
    {
        $this->prefix = $prefix;
    }

    /**
     * @return string|null
     */
    public function getReceptionLaP(): ?string
    {
        return $this->receptionLaP;
    }

    /**
     * @param string|null $receptionLaP
     */
    public function setReceptionLaP(?string $receptionLaP): void
    {
        $this->receptionLaP = $receptionLaP;
    }

    /**
     * @return string|null
     */
    public function getDeliveryLaP(): ?string
    {
        return $this->deliveryLaP;
    }

    /**
     * @param string|null $deliveryLaP
     */
    public function setDeliveryLaP(?string $deliveryLaP): void
    {
        $this->deliveryLaP = $deliveryLaP;
    }

    /**
     * @return string|null
     */
    public function getReception(): ?string
    {
        return $this->reception;
    }

    /**
     * @param string|null $reception
     */
    public function setReception(?string $reception): void
    {
        $this->reception = $reception;
    }

    /**
     * @return string|null
     */
    public function getForeignReceptionReturns(): ?string
    {
        return $this->foreignReceptionReturns;
    }

    /**
     * @param string|null $foreignReceptionReturns
     */
    public function setForeignReceptionReturns(?string $foreignReceptionReturns): void
    {
        $this->foreignReceptionReturns = $foreignReceptionReturns;
    }

    /**
     * @return string
     */
    public function getTerminal(): string
    {
        return $this->terminal;
    }

    /**
     * @param string $terminal
     */
    public function setTerminal(string $terminal): void
    {
        $this->terminal = $terminal;
    }

    /**
     * @return string|null
     */
    public function getKladr(): ?string
    {
        return $this->kladr;
    }

    /**
     * @param string|null $kladr
     */
    public function setKladr(?string $kladr): void
    {
        $this->kladr = $kladr;
    }

    /**
     * @return string
     */
    public function getPickupPoint()
    {
        return $this->pickupPoint;
    }

    /**
     * @param string $pickupPoint
     */
    public function setPickupPoint($pickupPoint): void
    {
        $this->pickupPoint = $pickupPoint;
    }

    /**
     * @return string
     */
    public function getCourierDelivery(): string
    {
        return $this->courierDelivery;
    }

    /**
     * @param string $courierDelivery
     */
    public function setCourierDelivery(string $courierDelivery): void
    {
        $this->courierDelivery = $courierDelivery;
    }

    /**
     * @return string|null
     */
    public function getRegion(): ?string
    {
        return $this->region;
    }

    /**
     * @param string|null $region
     */
    public function setRegion(?string $region): void
    {
        $this->region = $region;
    }

    /**
     * @return string|null
     */
    public function getUniqName(): ?string
    {
        return $this->uniqName;
    }

    /**
     * @param string|null $uniqName
     */
    public function setUniqName(?string $uniqName): void
    {
        $this->uniqName = $uniqName;
    }

    /**
     * @return string|null
     */
    public function getDistrict(): ?string
    {
        return $this->district;
    }

    /**
     * @param string|null $district
     */
    public function setDistrict(?string $district): void
    {
        $this->district = $district;
    }

    /**
     * @return string
     */
    public function getCourierReception(): string
    {
        return $this->courierReception;
    }

    /**
     * @param string $courierReception
     */
    public function setCourierReception(string $courierReception): void
    {
        $this->courierReception = $courierReception;
    }


}