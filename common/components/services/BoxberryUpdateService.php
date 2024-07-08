<?php


namespace common\components\services\delivery;


use common\components\integrations\boxberry\BoxberryDeliveryClient;
use common\components\integrations\boxberry\helpers\BoxberryCountryCode;
use common\components\integrations\boxberry\helpers\mappers\BoxberryCityResponseToModelMapper;
use common\components\integrations\boxberry\helpers\mappers\BoxberryPickupPointResponseToModelMapper;
use common\components\integrations\boxberry\models\request\ListCitiesFullRequest;
use common\components\integrations\boxberry\models\request\ListPointsRequest;
use common\components\utils\Utils;
use common\models\City;
use common\models\CityBoxberry;
use common\models\PickupPointBoxberry;
use Yii;
use yii\db\Exception;
use yii\helpers\ArrayHelper;

/**
 * @package common\services\delivery
 *
 * Сервис обновления сущностей Boxberry.
 */
class BoxberryUpdateService
{
    /**
     * @var BoxberryDeliveryClient
     */
    private $boxberryDeliveryClient;

    public function __construct()
    {
        $this->boxberryDeliveryClient = new BoxberryDeliveryClient();
    }

    /**
     * Обновление городов Boxberry
     * Рекомендуемая частота: 1 раз в сутки
     *
     * Добавление нового, если есть такой город в таблице city.
     * Обновление, если данные изменились
     * Удаление, если не пришел в ответе от Boxberry
     *
     * @param string $countryCode Код страны в системе Boxberry (см. common\components\integrations\boxberry\helpers\BoxberryCountryCode)
     * @throws Exception
     */
    public function updateCities($countryCode = BoxberryCountryCode::RUSSIA)
    {
        $listCities = $this->boxberryDeliveryClient->listCitiesFull(new ListCitiesFullRequest($countryCode));

        if (!$listCities->isSuccess()) {
            Yii::error(self::class . " Ошибка обновления информации о городах Boxberry. Ошибка: " . $listCities->getMessage());
            return;
        }

        $localCities = City::find()->all();
        $citiesMapIdToCityKladr = ArrayHelper::map($localCities, "id", 'city_kladr_id');
        $citiesMapIdToSettlementKladr = ArrayHelper::map($localCities, "id", 'settlement_kladr_id');

        $responseListBoxberryCitiesIds = [];
        foreach ($listCities->getBoxberryCities() as $boxberryCity) {
            $responseListBoxberryCitiesIds[] = $boxberryCity->getCode();
            $boxberryCityModel = CityBoxberry::findOne(['boxberry_id' => $boxberryCity->getCode()]);

            if (!$boxberryCityModel) {
                $boxberryCityKladr = $boxberryCity->getKladr();
                if (!$boxberryCityKladr) {
                    continue;
                }

                $cityId = array_search($boxberryCityKladr, $citiesMapIdToCityKladr);
                if ($cityId === false) {
                    $cityId = array_search($boxberryCityKladr, $citiesMapIdToSettlementKladr);
                    if ($cityId === false) {
                        continue;
                    }
                }

                $boxberryCityModel = new CityBoxberry();
                $boxberryCityModel->city_id = $cityId;
            }

            $boxberryCityModel = (new BoxberryCityResponseToModelMapper())->convert($boxberryCity, $boxberryCityModel);

            if (!$boxberryCityModel->save()) {
                Yii::error(self::class . "Обновление городов Boxberry. Ошибка сохранения модели. {$boxberryCity->getUniqName()}: " . Utils::errorsToStr($boxberryCityModel->getErrors()));
            }
        }


        //Удаление городов, которые не пришли в ответе. Видимо в этих городах больше нет ПВЗ.
        $localCitiesBoxberry = CityBoxberry::find()->all();
        $localCitiesBoxberryIds = ArrayHelper::map($localCitiesBoxberry, "id", "boxberry_id");

        $deletedCities = array_diff($localCitiesBoxberryIds, $responseListBoxberryCitiesIds);

        CityBoxberry::deleteAll(['boxberry_id' => $deletedCities]);
    }

    /**
     * Обновление пунктов выдачи Boxberry
     * Рекомендуемая частота: 1 раз в час
     *
     * Добавление нового, если есть такой город.
     * Обновление, если данные о ПВЗ изменились
     * Удаление, если не пришел в ответе от Boxberry
     *
     * @param string|null $cityCode Код города в системе Boxberry для которого обновить ПВЗ (см. таблицу city_boxberry)
     * @param string|null $countryCode Код страны в системе Boxberry (см. common\components\integrations\boxberry\helpers\BoxberryCountryCode)
     * @throws Exception
     */
    public function updatePickupPoints(?string $cityCode = null, ?string $countryCode = BoxberryCountryCode::RUSSIA)
    {
        $pickupPoints = $this->boxberryDeliveryClient->listPoints(new ListPointsRequest($countryCode, $cityCode));

        if (!$pickupPoints->isSuccess()) {
            Yii::error(self::class . " Ошибка обновления информации о ПВЗ Boxberry. Ошибка: " . $pickupPoints->getMessage());
            return;
        }

        $responseListBoxberryPickupPointsIds = [];
        foreach ($pickupPoints->getListPoints() as $pickupPoint) {
            $responseListBoxberryPickupPointsIds[] = $pickupPoint->getCode();
            $pickupPointModel = PickupPointBoxberry::findOne(['boxberry_id' => $pickupPoint->getCode()]);

            if (!$pickupPointModel) {
                $cityBoxberryModel = CityBoxberry::findOne(['boxberry_id' => $pickupPoint->getCityCode()]);

                if (!$cityBoxberryModel) {
                    continue;
                }

                $pickupPointModel = new PickupPointBoxberry();
                $pickupPointModel->city_boxberry_id = $cityBoxberryModel->id;
                $pickupPointModel->city_id = $cityBoxberryModel->city_id;
            }

            $pickupPointModel = (new BoxberryPickupPointResponseToModelMapper())->convert($pickupPoint, $pickupPointModel);

            if (!$pickupPointModel->save()) {
                Yii::error(self::class . "Обновление ПВЗ Boxberry. Ошибка сохранения модели. {$pickupPoint->getCode()}. Name: {$pickupPoint->getAddress()}: " . Utils::errorsToStr($pickupPointModel->getErrors()));
            }
        }


        //Удаление ПВЗ, которые не пришли в ответе. Видимо они закрылись.
        $localPickupPointsBoxberry = PickupPointBoxberry::find()->all();
        $localPickupPointsBoxberryIds = ArrayHelper::map($localPickupPointsBoxberry, "id", "boxberry_id");

        $deletedPickupPoints = array_diff($localPickupPointsBoxberryIds, $responseListBoxberryPickupPointsIds);

        PickupPointBoxberry::deleteAll(['boxberry_id' => $deletedPickupPoints]);
    }
}