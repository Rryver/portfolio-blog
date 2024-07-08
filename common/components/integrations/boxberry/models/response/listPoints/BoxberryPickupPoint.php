<?php


namespace common\components\integrations\boxberry\models\response\listPoints;


use common\components\integrations\common\CommonObject;

class BoxberryPickupPoint extends CommonObject
{
    /**
     * Код пункта выдачи в базе boxberry
     * @var string
     */
    private $code;

    /**
     * Наименование пункта выдачи
     * Пример: Москва Холодильный_7712_С
     * @var string|null
     */
    private $name;

    /**
     * Полный адрес
     * Пример: 115191, Москва г, Холодильный пер, д.3, оф. 37А
     * @var string|null
     */
    private $address;

    /**
     * Телефон или телефоны
     * @var string|null
     */
    private $phone;

    /**
     * График работы
     * Пример: пн-пт: 12.00-20.30, сб: 12.00-19.00
     * График работы по дням можно получить в запросе: PointsDescription - Расширенная информация о ПВЗ
     *
     * @var string|null
     */
    private $workShedule;

    /**
     * Описание проезда
     *
     * Пример:
     * Метро "Тульская".
     * Примерное расстояние от остановки до отделения - 200 м.
     * ТРЦ "Ролл Холл".
     * Расположение входа в отделение - центральный вход.
     * Павильон 37А.
     *
     * @var string|null
     */
    private $tripDescription;

    /**
     * Срок доставки в днях (по умолчанию срок доставки от Москвы)
     * @var string|null
     */
    private $deliveryPeriod;

    /**
     * Код города в Boxberry
     * @var string|null
     */
    private $cityCode;

    /**
     * Наименование города
     * Пример: Москва
     * @var string|null
     */
    private $cityName;

    /**
     * Тарифная зона для города отправления - Москва
     * @var string|null
     */
    private $tariffZone;

    /**
     * Наименование населенного пункта
     * Пример: Москва
     * @var string|null
     */
    private $settlement;

    /**
     * Область
     * @var string|null
     */
    private $area;

    /**
     * Наименование страны
     * @var string|null
     */
    private $country;

    /**
     * Координаты GPS
     * Пример: 55.7083892,37.6254865
     * @var string|null
     */
    private $gps;

    /**
     * Адрес сокращенный (улица, дом, номер квартиры)
     * Пример: Холодильный пер, д.3, оф. 37А
     * @var string|null
     */
    private $addressReduce;

    /**
     * Выдача только полностью оплаченных посылок:
     * "Yes" - только выдача посылок без приема оплаты,
     * "No" - выдача любых посылок
     * @var string|null
     */
    private $onlyPrepaidOrders;

    /**
     * Возможность оплаты банковской картой (Yes/No)
     * @var string|null
     */
    private $acquiring;

    /**
     * Наличие планшета для цифровой подписи:
     * "Yes" - Подпись получателя будет хранится в системе boxberry в электронном виде
     * "No" - отсутствуют подписи в электронном виде
     * @var string|null
     */
    private $digitalSignature;

    /**
     * Код страны в Boxberry
     * @var string|null
     */
    private $countryCode;

    /**
     * Отделение осуществляет курьерскую доставку (Yes/No)
     * @var string|null
     */
    private $nalKD;

    /**
     * Станция метро
     * @var string|null
     */
    private $metro;

    /**
     * Тип пункта выдачи:
     * 1 - собственное отделение
     * 2 - партнерское
     *
     * Судя по всему документация неактуальна. Приходит "СПВЗ"
     *
     * @var string|null
     */
    private $typeOfOffice;

    /**
     * Ограничение объема, м3
     * @var string|null
     */
    private $volumeLimit;

    /**
     * Ограничение веса, кг
     * @var int|null
     */
    private $loadLimit;

    /**
     * Отделение является постaматом
     * @var bool|null
     */
    private $postamat;

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
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string|null $address
     */
    public function setAddress(?string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     */
    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return string|null
     */
    public function getWorkShedule(): ?string
    {
        return $this->workShedule;
    }

    /**
     * @param string|null $workSchedule
     */
    public function setWorkShedule(?string $workSchedule): void
    {
        $this->workShedule = $workSchedule;
    }

    /**
     * @return string|null
     */
    public function getTripDescription(): ?string
    {
        return $this->tripDescription;
    }

    /**
     * @param string|null $tripDescription
     */
    public function setTripDescription(?string $tripDescription): void
    {
        $this->tripDescription = $tripDescription;
    }

    /**
     * @return string|null
     */
    public function getDeliveryPeriod(): ?string
    {
        return $this->deliveryPeriod;
    }

    /**
     * @param string|null $deliveryPeriod
     */
    public function setDeliveryPeriod(?string $deliveryPeriod): void
    {
        $this->deliveryPeriod = $deliveryPeriod;
    }

    /**
     * @return string|null
     */
    public function getCityCode(): ?string
    {
        return $this->cityCode;
    }

    /**
     * @param string|null $cityCode
     */
    public function setCityCode(?string $cityCode): void
    {
        $this->cityCode = $cityCode;
    }

    /**
     * @return string|null
     */
    public function getCityName(): ?string
    {
        return $this->cityName;
    }

    /**
     * @param string|null $cityName
     */
    public function setCityName(?string $cityName): void
    {
        $this->cityName = $cityName;
    }

    /**
     * @return string|null
     */
    public function getTariffZone(): ?string
    {
        return $this->tariffZone;
    }

    /**
     * @param string|null $tariffZone
     */
    public function setTariffZone(?string $tariffZone): void
    {
        $this->tariffZone = $tariffZone;
    }

    /**
     * @return string|null
     */
    public function getSettlement(): ?string
    {
        return $this->settlement;
    }

    /**
     * @param string|null $settlement
     */
    public function setSettlement(?string $settlement): void
    {
        $this->settlement = $settlement;
    }

    /**
     * @return string|null
     */
    public function getArea(): ?string
    {
        return $this->area;
    }

    /**
     * @param string|null $area
     */
    public function setArea(?string $area): void
    {
        $this->area = $area;
    }

    /**
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param string|null $country
     */
    public function setCountry(?string $country): void
    {
        $this->country = $country;
    }

    /**
     * @return string|null
     */
    public function getGps(): ?string
    {
        return $this->gps;
    }

    /**
     * @param string|null $gps
     */
    public function setGps(?string $gps): void
    {
        $this->gps = $gps;
    }

    /**
     * @return string|null
     */
    public function getAddressReduce(): ?string
    {
        return $this->addressReduce;
    }

    /**
     * @param string|null $addressReduce
     */
    public function setAddressReduce(?string $addressReduce): void
    {
        $this->addressReduce = $addressReduce;
    }

    /**
     * @return string|null
     */
    public function getOnlyPrepaidOrders(): ?string
    {
        return $this->onlyPrepaidOrders;
    }

    /**
     * @param string|null $onlyPrepaidOrders
     */
    public function setOnlyPrepaidOrders(?string $onlyPrepaidOrders): void
    {
        $this->onlyPrepaidOrders = $onlyPrepaidOrders;
    }

    /**
     * @return string|null
     */
    public function getAcquiring(): ?string
    {
        return $this->acquiring;
    }

    /**
     * @param string|null $acquiring
     */
    public function setAcquiring(?string $acquiring): void
    {
        $this->acquiring = $acquiring;
    }

    /**
     * @return string|null
     */
    public function getDigitalSignature(): ?string
    {
        return $this->digitalSignature;
    }

    /**
     * @param string|null $digitalSignature
     */
    public function setDigitalSignature(?string $digitalSignature): void
    {
        $this->digitalSignature = $digitalSignature;
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
    public function getNalKD(): ?string
    {
        return $this->nalKD;
    }

    /**
     * @param string|null $nalKD
     */
    public function setNalKD(?string $nalKD): void
    {
        $this->nalKD = $nalKD;
    }

    /**
     * @return string|null
     */
    public function getMetro(): ?string
    {
        return $this->metro;
    }

    /**
     * @param string|null $metro
     */
    public function setMetro(?string $metro): void
    {
        $this->metro = $metro;
    }

    /**
     * @return string|null
     */
    public function getTypeOfOffice(): ?string
    {
        return $this->typeOfOffice;
    }

    /**
     * @param string|null $typeOfOffice
     */
    public function setTypeOfOffice(?string $typeOfOffice): void
    {
        $this->typeOfOffice = $typeOfOffice;
    }

    /**
     * @return string|null
     */
    public function getVolumeLimit(): ?string
    {
        return $this->volumeLimit;
    }

    /**
     * @param string|null $volumeLimit
     */
    public function setVolumeLimit(?string $volumeLimit): void
    {
        $this->volumeLimit = $volumeLimit;
    }

    /**
     * @return int|null
     */
    public function getLoadLimit(): ?int
    {
        return $this->loadLimit;
    }

    /**
     * @param int|null $loadLimit
     */
    public function setLoadLimit(?int $loadLimit): void
    {
        $this->loadLimit = $loadLimit;
    }

    /**
     * @return bool|null
     */
    public function getPostamat(): ?bool
    {
        return $this->postamat;
    }

    /**
     * @param bool|null $postamat
     */
    public function setPostamat(?bool $postamat): void
    {
        $this->postamat = $postamat;
    }



}