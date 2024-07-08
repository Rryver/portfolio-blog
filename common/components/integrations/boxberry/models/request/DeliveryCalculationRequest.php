<?php


namespace common\components\integrations\boxberry\models\request;


use common\components\integrations\boxberry\BoxberryDeliveryClient;
use common\components\integrations\boxberry\models\request\deliveryCalculation\BoxSize;

/**
 * Class DeliveryCalculationRequest
 * @package common\components\integrations\boxberry\models\request
 *
 * Класс запроса на рассчет стоимости доставки
 */
class DeliveryCalculationRequest extends BaseBoxberryRequest
{
    /**
     * Город получения.
     *
     * Обязательный параметр для расчета доставки в другие страны
     * @var string|null
     */
    private $recipientCityId;

    /**
     * Город отправления
     *
     * Обязательно к заполению:
     * да, если не передан TargetStart
     * нет - во всех иных случаях
     *
     * @var string|null
     */
    private $senderCityId;

    /**
     * Массив массо-габаритных характеристик для каждого места в заказе
     * @var BoxSize[]
     */
    private $boxSizes;

    /**
     * Тип доставки
     * Возможные значения (common\components\integrations\boxberry\helpers\DeliveryType):
     * 1 - Доставка до ПВЗ
     * 2 - Курьерская доставка
     * Если не заполнено в ответе возвращаются все типы доставки
     *
     * @var string|null
     */
    private $deliveryType;

    /**
     * Объявленная стоимость заказа, руб.
     * @var float|null
     */
    private $orderSum;

    /**
     * Стоимость доставки объявленная получателю ИМ, руб.
     * @var float|null
     */
    private $deliverySum;

    /**
     * Сумма, которую необходимо взять с получателя, руб.
     * @var float|null
     */
    private $paySum;

    /**
     * Отделение отправления
     * @var string|null
     */
    private $targetStart;

    /**
     * Отделение получения
     * @var string|null
     */
    private $targetStop;

    /**
     * Индекс получателя (только РФ)
     * Если передан, то в ответе будет вариант для КД
     * @var string|null
     */
    private $zip;

    /**
     * Расчет с учетом настроек установленных в ЛК ИМ:
     * Возможные значения:
     * 1 - получить расчет с учетом индивидуальных настроек
     * 0 - получить расчет без настроек
     *
     * Настройки находятся в:
     * "Настройки средств интеграции - Расчеты - Включить настройки расчета".
     *
     * @var string|null
     */
    private $useShopSettings;

    /**
     * Название CMS. Параметр предназначен для разработчиков CMS, проводящих интеграцию с Boxberry.
     * Применяется только в JSON.
     * Для учета данного параметра в статистике также должен быть передан параметр url
     *
     * Пример:
     * - bitrix
     * - wordpress
     * - cscart
     *
     * @var string|null
     */
    private $cmsName;

    /**
     * url сайта. Параметр предназначен для разработчиков CMS, проводящих интеграцию с Boxberry.
     * Применяется только в JSON.
     * @var string|null
     */
    private $url;

    /**
     * версия интеграции/модуля
     *
     * Пример: 2.2
     *
     * @var string|null
     */
    private $version;

    /**
     * DeliveryCalculationRequest constructor.
     * @param string|null $recipientCityId
     * @param string|null $senderCityId
     * @param BoxSize[] $boxSizes
     * @param string|null $deliveryType
     * @param float|null $orderSum
     * @param float|null $deliverySum
     * @param float|null $paySum
     * @param string|null $targetStart
     * @param string|null $targetStop
     * @param string|null $zip
     * @param string|null $useShopSettings
     * @param string|null $cmsName
     * @param string|null $url
     * @param string|null $version
     */
    public function __construct(?string $recipientCityId,
                                array $boxSizes = null,
                                ?string $deliveryType = null,
                                ?float $orderSum = null,
                                ?float $deliverySum = null,
                                ?float $paySum = null,
                                ?string $senderCityId = BoxberryDeliveryClient::CITY_ID_SOURCE,
                                ?string $targetStart = null,
                                ?string $targetStop = null,
                                ?string $zip = null,
                                ?string $useShopSettings = null,
                                ?string $cmsName = null,
                                ?string $url = null,
                                ?string $version = null,
                                array $config = [])
    {
        $this->recipientCityId = $recipientCityId;
        $this->boxSizes = $boxSizes ?? [new BoxSize(1000)];
        $this->deliveryType = $deliveryType;
        $this->orderSum = $orderSum;
        $this->deliverySum = $deliverySum;
        $this->senderCityId = $senderCityId;
        $this->paySum = $paySum;
        $this->targetStart = $targetStart;
        $this->targetStop = $targetStop;
        $this->zip = $zip;
        $this->useShopSettings = $useShopSettings;
        $this->cmsName = $cmsName;
        $this->url = $url;
        $this->version = $version;

        parent::__construct($config);
    }


    public function fields()
    {
        return [
            'SenderCityId' => 'senderCityId',
            'RecipientCityId' => 'recipientCityId',
            'BoxSizes' => 'boxSizes',
            'DeliveryType' => 'deliveryType',
            'OrderSum' => 'orderSum',
            'DeliverySum' => 'deliverySum',
            'PaySum' => 'paySum',
            'TargetStart' => 'targetStart',
            'TargetStop' => 'targetStop',
            'Zip' => 'zip',
            'UseShopSettings' => 'useShopSettings',
            'CmsName' => 'cmsName',
            'Url' => 'url',
            'Version' => 'version',
        ];
    }

    /**
     * @return string|null
     */
    public function getRecipientCityId(): ?string
    {
        return $this->recipientCityId;
    }

    /**
     * @param string|null $recipientCityId
     */
    public function setRecipientCityId(?string $recipientCityId): void
    {
        $this->recipientCityId = $recipientCityId;
    }

    /**
     * @return string|null
     */
    public function getSenderCityId(): ?string
    {
        return $this->senderCityId;
    }

    /**
     * @param string|null $senderCityId
     */
    public function setSenderCityId(?string $senderCityId): void
    {
        $this->senderCityId = $senderCityId;
    }

    /**
     * @return BoxSize[]
     */
    public function getBoxSizes(): array
    {
        return $this->boxSizes;
    }

    /**
     * @param BoxSize[] $boxSizes
     */
    public function setBoxSizes(array $boxSizes): void
    {
        $this->boxSizes = $boxSizes;
    }

    /**
     * @return string|null
     */
    public function getDeliveryType(): ?string
    {
        return $this->deliveryType;
    }

    /**
     * @param string|null $deliveryType
     */
    public function setDeliveryType(?string $deliveryType): void
    {
        $this->deliveryType = $deliveryType;
    }

    /**
     * @return float|null
     */
    public function getOrderSum(): ?float
    {
        return $this->orderSum;
    }

    /**
     * @param float|null $orderSum
     */
    public function setOrderSum(?float $orderSum): void
    {
        $this->orderSum = $orderSum;
    }

    /**
     * @return float|null
     */
    public function getDeliverySum(): ?float
    {
        return $this->deliverySum;
    }

    /**
     * @param float|null $deliverySum
     */
    public function setDeliverySum(?float $deliverySum): void
    {
        $this->deliverySum = $deliverySum;
    }

    /**
     * @return float|null
     */
    public function getPaySum(): ?float
    {
        return $this->paySum;
    }

    /**
     * @param float|null $paySum
     */
    public function setPaySum(?float $paySum): void
    {
        $this->paySum = $paySum;
    }

    /**
     * @return string|null
     */
    public function getTargetStart(): ?string
    {
        return $this->targetStart;
    }

    /**
     * @param string|null $targetStart
     */
    public function setTargetStart(?string $targetStart): void
    {
        $this->targetStart = $targetStart;
    }

    /**
     * @return string|null
     */
    public function getTargetStop(): ?string
    {
        return $this->targetStop;
    }

    /**
     * @param string|null $targetStop
     */
    public function setTargetStop(?string $targetStop): void
    {
        $this->targetStop = $targetStop;
    }

    /**
     * @return string|null
     */
    public function getZip(): ?string
    {
        return $this->zip;
    }

    /**
     * @param string|null $zip
     */
    public function setZip(?string $zip): void
    {
        $this->zip = $zip;
    }

    /**
     * @return string|null
     */
    public function getUseShopSettings(): ?string
    {
        return $this->useShopSettings;
    }

    /**
     * @param string|null $useShopSettings
     */
    public function setUseShopSettings(?string $useShopSettings): void
    {
        $this->useShopSettings = $useShopSettings;
    }

    /**
     * @return string|null
     */
    public function getCmsName(): ?string
    {
        return $this->cmsName;
    }

    /**
     * @param string|null $cmsName
     */
    public function setCmsName(?string $cmsName): void
    {
        $this->cmsName = $cmsName;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string|null $url
     */
    public function setUrl(?string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return string|null
     */
    public function getVersion(): ?string
    {
        return $this->version;
    }

    /**
     * @param string|null $version
     */
    public function setVersion(?string $version): void
    {
        $this->version = $version;
    }


}