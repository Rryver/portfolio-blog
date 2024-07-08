<?php


namespace common\models;

/**
 * Class Delivery
 * @package common\models
 *
 * @property int $id
 * @property string|null $name              Название доставки
 * @property int $delivery_type             ID Доставки из common/components/delivery/Delivery -> $method
 * @property string|null $description       Описание доставки
 * @property bool $active                   Вкл/откл доставка
 * @property float|null $min                Если сумма корзины больше, то доставка будет выведена пользователю
 * @property int|null $price                Цена
 * @property int|null $markup               Наценка
 * @property string $markup_type            Тип наценки (смотри константы MARKUP_TYPE_)
 * @property boolean $product_show          Показывать на странице продукта
 * @property boolean $holiday_use           Нужно ли увеличивать время доставки, если заказ перед праздниками
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $price_free_from      Бесплатно от
 * @property int $sort                      Порядковый номер для сортировки при выводе пользователю
 */
class Delivery extends CommonActiveRecord
{
    const DELIVERY_DEFAULT = 10; //По умолчанию.
    const DELIVERY_BOXBERRY = 20; //Boxberry - до двери
    const DELIVERY_BOXBERRY_PICKUP = 30; //Boxberry - пункты выдачи

    const MARKUP_TYPE_PERCENT = 'percent'; // Процентная наценка. Увеличивает стоимость на указанный процент
    const MARKUP_TYPE_FIXED = 'fixed'; // Фиксированная наценка. Прибавляет к стоимости фиксированное значение

    /**
     * @return string[]
     */
    public static function getActiveList()
    {
        return [
            true => 'Активный',
            false => 'Не активный'
        ];
    }

    public static function getMarkupTypes()
    {
        return [
            self::MARKUP_TYPE_FIXED => 'Фиксированное значение',
            self::MARKUP_TYPE_PERCENT => 'Процентное значение'
        ];
    }
}