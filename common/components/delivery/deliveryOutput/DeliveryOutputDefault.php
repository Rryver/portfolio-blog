<?php


namespace common\components\delivery\deliveryOutput;


use yii\base\Arrayable;
use yii\base\ArrayableTrait;
use yii\base\BaseObject;

class DeliveryOutputDefault extends BaseObject implements Arrayable
{
    use ArrayableTrait;

    const DEFAULT_ERROR_DESCRIPTION = "По техническим причинам доставка будет доступна позже";

    /**
     * ID Доставки в БД
     * @var int
     */
    protected $id;

    /**
     * Сортировка вывода доставок
     * @var int
     */
    protected $sort = 999;

    /**
     * Наименование доставки для пользователя
     * @var string
     */
    protected $name;

    /**
     * Описание доставки для пользовтеля
     * @var string|null
     */
    protected $description;


    /**
     * Конечная стоимость доставки после всех расчетов
     * @var float|null
     */
    protected $price; //delivery_price

    /**
     * Конечная стоимость доставки после всех расчетов (форматированная строка). Вид: "200 руб"
     * @var string|null
     */
    protected $priceStr;

    /**
     * Бесплатная доставка от
     * @var float|null
     */
    protected $priceFreeFrom;

    /**
     * Бесплатная доставка от (форматированная строка).
     * @var string
     */
    protected $priceFreeFromStr;

    /**
     * Минимальная цена, при которой доставка будет показана пользователю
     * @var float|null
     */
    protected $priceMin = 0;

    /**
     * Время доставки в виде "1-2 дня"
     * @var string|null
     */
    protected $timeInterval = "";

    /**
     * Предполагаемая дата доставки. Рассчитывается исходя из текущего дня и времени доставки
     * Формат: 22.01.2024
     *
     * @var string|null
     */
    protected $deliveryDate;

    /**
     * Доставка недоступна для выбора?
     * @var bool
     */
    protected $disable = false;

    /**
     * Доставка недоступна, так как суммы корзины нехватает
     * @var bool
     */
    protected $disabledByMinPriceToCanSelect = false;

    /**
     * Произошла ошибка при расчете информации о доставке
     * @var bool
     */
    protected $error = false;

    /**
     * Текст ошибки
     * @var string
     */
    protected $errorDescription;

    /**
     * Наценка
     * @var float|null
     */
    protected $markup = 0;

    /**
     * @inheritDoc
     */
    public function fields()
    {
        return [
            'id' => 'id',
            'sort' => 'sort',
            'name' => 'name',
            'description' => 'description',
            'deliveryPrice' => 'price',
            'deliveryPriceStr' => 'priceStr',
            'minSum' => 'priceFreeFrom',
            'minSumNumberFormat' => 'priceFreeFromStr',
            'min' => 'priceMin',
            'deliveryTime' => 'timeInterval',
            'deliveryDate' => 'deliveryDate',
            'disable' => 'disable',
            'disabledByMinPriceToCanSelect' => 'disabledByMinPriceToCanSelect',
            'error' => 'error',
            'active' => 'active',
            'current' => 'current',
            'default' => 'default',
            'markup' => 'markup',
        ];
    }


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getSort(): ?int
    {
        return $this->sort;
    }

    /**
     * @param int $sort
     */
    public function setSort(int $sort = 999): void
    {
        $this->sort = $sort;
    }

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
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param float|null $price
     */
    public function setPrice(?float $price): void
    {
        $this->price = $price;
        $this->priceStr = number_format((int) $price, 0, '.', ' ');
    }

    /**
     * @return string|null
     */
    public function getPriceStr(): ?string
    {
        return $this->priceStr;
    }

    /**
     * @return float|null
     */
    public function getPriceFreeFrom(): ?float
    {
        return $this->priceFreeFrom;
    }

    /**
     * @param float|null $priceFreeFrom
     */
    public function setPriceFreeFrom(?float $priceFreeFrom): void
    {
        $this->priceFreeFrom = $priceFreeFrom;
        $this->priceFreeFromStr = number_format((int)$priceFreeFrom, 0, '.', ' ');
    }

    /**
     * @return string
     */
    public function getPriceFreeFromStr(): string
    {
        return $this->priceFreeFromStr;
    }

    /**
     * @return float|null
     */
    public function getPriceMin(): ?float
    {
        return $this->priceMin;
    }

    /**
     * @param float|null $priceMin
     */
    public function setPriceMin(?float $priceMin): void
    {
        $this->priceMin = $priceMin;
    }

    /**
     * @return string|null
     */
    public function getTimeInterval(): ?string
    {
        return $this->timeInterval;
    }

    /**
     * @param string|null $timeInterval
     */
    public function setTimeInterval(?string $timeInterval): void
    {
        $this->timeInterval = $timeInterval;
    }

    /**
     * @return string|null
     */
    public function getDeliveryDate(): ?string
    {
        return $this->deliveryDate;
    }

    /**
     * @param string|null $deliveryDate
     */
    public function setDeliveryDate(?string $deliveryDate): void
    {
        $this->deliveryDate = $deliveryDate;
    }

    /**
     * @return bool
     */
    public function isDisable(): bool
    {
        return $this->disable;
    }

    /**
     * @param bool $disable
     */
    public function setDisable(bool $disable): void
    {
        $this->disable = $disable;
    }

    /**
     * @return bool
     */
    public function isDisabledByMinPriceToCanSelect(): bool
    {
        return $this->disabledByMinPriceToCanSelect;
    }

    /**
     * @param bool $disabledByMinPriceToCanSelect
     */
    public function setDisabledByMinPriceToCanSelect(bool $disabledByMinPriceToCanSelect): void
    {
        $this->disabledByMinPriceToCanSelect = $disabledByMinPriceToCanSelect;
    }

    /**
     * @return bool
     */
    public function isError(): bool
    {
        return $this->error;
    }

    /**
     * @param bool $error
     */
    public function setError(bool $error): void
    {
        $this->error = $error;
    }

    /**
     * @return string
     */
    public function getErrorDescription(): string
    {
        if (!isset($this->errorDescription) && $this->isError()) {
            return self::DEFAULT_ERROR_DESCRIPTION;
        }

        return $this->errorDescription;
    }

    /**
     * @param string $errorDescription
     */
    public function setErrorDescription(string $errorDescription): void
    {
        $this->errorDescription = $errorDescription;
    }

    /**
     * @return float|null
     */
    public function getMarkup(): ?float
    {
        return $this->markup;
    }

    /**
     * @param float|null $markup
     */
    public function setMarkup(?float $markup): void
    {
        $this->markup = $markup;
    }

}