<?php


namespace common\models;


use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * Class CityBoxberryBase
 * @package common\models\base
 *
 * Модель для таблицы 'city_boxberry'
 * Хранинится город из системы Boxberry
 *
 * @property int $id
 * @property int $city_id               Внешний ключ с таблицей city
 * @property string $boxberry_id        ID города в системе Boxberry
 * @property string $kladr              ID города в системе КЛАДР
 * @property string $name
 * @property string $uniq_name          Составное уникальное имя (для городов с не уникальным наименованием город + область + район)
 * @property string $country_code       Код страны
 * @property string $region             Регион
 * @property string $district           Район
 * @property string $prefix             Префикс: г - Город, п - Поселок и т.д.
 * @property bool $foreign_reception_returns    Прием международных возвратов
 * @property bool $terminal             Наличие терминала в городе
 * @property bool $pickup_point         Наличие пунктов выдачи заказов в городе
 * @property bool $courier_delivery     Наличие курьерской доставки в городе
 * @property bool $courier_reception    Наличие курьерского забора
 * @property int $created_at
 * @property int $updated_at
 *
 * @property City $city
 * @property PickupPointBoxberry[] $pickupPointsBoxberry
 *
 */
class CityBoxberry extends CommonActiveRecord
{
    public static function tableName()
    {
        return '{{%city_boxberry}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function rules()
    {
        return [
            [['city_id', 'country_code', 'created_at', 'updated_at'], 'integer'],
            [['boxberry_id', 'kladr', 'name', 'uniq_name', 'region', 'district', 'prefix'], 'string'],
            [['foreign_reception_returns', 'terminal', 'pickup_point', 'courier_delivery', 'courier_reception'], 'boolean']
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPickupPointsBoxberry()
    {
        return $this->hasMany(PickupPointBoxberry::class, ['city_boxberry_id' => 'boxberry_id']);
    }
}