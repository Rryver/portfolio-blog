<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "{{%city}}".
 *
 * @property int $id
 * @property string $title
 * @property string $city_kladr_id          ID Города в системе КЛАДР
 * @property string $region_kladr_id        ID Области в системе КЛАДР
 * @property string $settlement_kladr_id    ID Района в системе КЛАДР
 * @property string $unrestricted_value     Полное наименование нас. пункта
 * @property string $postal_code            Почтовый индекс
 * @property int $created_at
 * @property int $updated_at
 *
 * @property CityBoxberry $cityBoxberry
 * @property PickupPointBoxberry[] $pickupPointsBoxberry
 */
class City extends CommonActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%city}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            ['unrestricted_value', 'required'],
            ['unrestricted_value', 'unique', 'message' => Yii::t('app', 'Already exists')],

            [['title', 'postal_code'], 'string'],
            [['city_kladr_id', 'settlement_kladr_id', 'region_kladr_id'], 'string', 'max' => 255],
            [['created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'postal_code' => Yii::t('app', 'Postal Code'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getCityBoxberry()
    {
        return $this->hasOne(CityBoxberry::class, ['city_id' => 'id']);
    }

    public function getPickupPointsBoxberry()
    {
        return $this->hasMany(PickupPointBoxberry::class, ['city_id' => 'id']);
    }

    /**
     * Индекс из строки unrestricted_value
     * @return string
     */
    public function getIndex(): string
    {
        $explode_title = explode(',', $this->unrestricted_value);
        if (ctype_digit($explode_title[0])) {
            return $explode_title[0];
        } else {
            return '0';
        }
    }
}
