<?php


namespace common\components\integrations\boxberry\models\request;

use common\components\integrations\boxberry\helpers\BoxberryCountryCode;

/**
 * Class ListPointsRequest
 * @package common\components\integrations\boxberry\models\request
 *
 * Позволяет получить информацию о всех точках выдачи заказов.
 * Рекомендуемая частота обновления данных: 1 раз в час.
 */
class ListPointsRequest extends BaseBoxberryRequest
{
    /**
     * Код страны.
     * Возможные варианты: см. BoxberrryCountryCode.php
     * По умолчанию возвращается информация по отделениям для всех стран (направления: РФ, Экспорт из РФ).
     *
     * @var string|null
     */
    private $countryCode;

    /**
     * Код города Boxberry
     * @var string|null
     */
    private $cityCode;

    /**
     * Возможности оплаты на ПВЗ при выдаче:
     * 0 - только отделения с возможностью оплатить посылку при получении наличными денежными средствами (OnlyPrepaidOrders=No).
     * 1 - все отделения (OnlyPrepaidOrders=Yes):
     *
     * с возможностью оплаты при получении;
     * - работающие только по предоплате.
     * - Если не передан, то по умолчанию 0 - только ПВЗ, где есть приём платежа.
     *
     * @var bool|null
     */
    private $prepaid;

    /**
     * Фильтр на получение списка с\без постaматов.
     * 1 - все отделения, включая постaматы
     * 0 - только отделения со значением postamat = false
     *
     * @var bool|null
     */
    private $isIncludePostamat;


    /**
     * @param string|null $countryCode
     * @param string|null $cityCode
     * @param bool|null $prepaid
     * @param bool|null $isIncludePostamat
     * @param array $config
     */
    public function __construct(?string $countryCode = BoxberryCountryCode::RUSSIA,
                                ?string $cityCode = null,
                                $prepaid = null,
                                ?bool $isIncludePostamat = null,
                                $config = [])
    {
        $this->countryCode = $countryCode;
        $this->cityCode = $cityCode;
        $this->prepaid = $prepaid;
        $this->isIncludePostamat = $isIncludePostamat;

        parent::__construct($config);
    }

    public function fields()
    {
        return [
            'CountryCode' => 'countryCode',
            'CityCode' => 'cityCode',
            'prepaid' => 'prepaid',
            'is_include_postamat' => 'isIncludePostamat',
        ];
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
     * @return bool|null
     */
    public function getPrepaid(): ?bool
    {
        return $this->prepaid;
    }

    /**
     * @param bool|null $prepaid
     */
    public function setPrepaid(?bool $prepaid): void
    {
        $this->prepaid = $prepaid;
    }

    /**
     * @return bool|null
     */
    public function getIsIncludePostamat(): ?bool
    {
        return $this->isIncludePostamat;
    }

    /**
     * @param bool|null $isIncludePostamat
     */
    public function setIsIncludePostamat(?bool $isIncludePostamat): void
    {
        $this->isIncludePostamat = $isIncludePostamat;
    }


}