<?php


namespace common\models;


use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * Class PickupPointBoxberry
 * @package common\models
 *
 * Модель для таблицы 'pickup_point_boxberry'
 * Хранинится пукнт выдачи из системы Boxberry
 *
 * @property int $id
 * @property int $city_id                       Внешний ключ с таблицей city
 * @property int $city_boxberry_id              Внешний ключ с таблицей city_boxberry
 * @property string $boxberry_id                ID ПВЗ в системе Boxberry
 * @property string|null $boxberry_city_id      ID города в системе Boxberry
 * @property string $name                       Наименование пункта выдачи
 * @property string $address                    Полный адрес
 * @property string|null $boxberry_country_code Код города в системе Boxberry (см. common\components\delivery\boxberry\helpers\BoxberryCountryCode.php)
 * @property string $phone                      Телефон или телефоны
 * @property string $work_schedule              График работы
 * @property string $trip_description           Описание проезда
 * @property string $gps                        Координаты GPS
 * @property bool|null $only_prepaid_orders     Выдача только полностью оплаченных посылок: true - только выдача посылок без приема оплаты, false - выдача любых посылок
 * @property bool $nalKD                        Отделение осуществляет курьерскую доставку
 * @property float|null $volume_limit           Ограничение объема, куб. метры
 * @property int|null $weight_limit             Ограничение веса, кг
 * @property bool $acquiring                    Возможность оплаты банковской картой
 * @property bool $is_postamat                  Отделение является постaматом
 * @property int $created_at
 * @property int $updated_at
 *
 * @property CityBoxberry $cityBoxberry
 * @property City $city
 */
class PickupPointBoxberry extends CommonActiveRecord
{

    /**
     * @inheritDoc
     */
    public static function tableName()
    {
        return '{{%pickup_point_boxberry}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            [['city_boxberry_id', 'boxberry_id', 'gps'], 'required'],
            [['city_boxberry_id', 'boxberry_id', 'boxberry_country_code', 'weight_limit', 'created_at', 'updated_at'], 'integer'],
            [['volume_limit'], 'double'],
            [['boxberry_city_id', 'name', 'address', 'phone', 'work_schedule', 'trip_description', 'gps'], 'string'],
            [['only_prepaid_orders', 'nalKD', 'acquiring', 'is_postamat'], 'boolean'],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getCityBoxberry()
    {
        return $this->hasOne(CityBoxberry::class, ['id' => 'city_boxberry_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }
}