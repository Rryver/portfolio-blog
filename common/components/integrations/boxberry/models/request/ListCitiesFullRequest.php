<?php


namespace common\components\integrations\boxberry\models\request;


use common\components\integrations\boxberry\helpers\BoxberryCountryCode;
use yii\helpers\ArrayHelper;

/**
 * Class ListCitiesFullRequest
 * @package common\components\integrations\boxberry\models\request
 *
 * Касс запроса для получения списка городов (РФ и другие страны), в которых осуществляется доставка Boxberry.
 *
 * Рекомендуемая частота обновления данных: 1 раз в день.
 */
class ListCitiesFullRequest extends BaseBoxberryRequest
{
    /**
     * Код страны.
     * Возможные варианты: см. BoxberrryCountryCode.php
     *
     * @var string|null
     */
    private $countryCode;


    public function __construct(string $countryCode = BoxberryCountryCode::RUSSIA,
                                $config = [])
    {
        $this->countryCode = $countryCode;
        parent::__construct($config);
    }

    public function fields()
    {
        return [
            'CountryCode' => 'countryCode',
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


}