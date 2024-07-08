<?php


namespace common\components\delivery\deliveryOutputCreator;


use common\components\delivery\deliveryOutput\DeliveryOutputBoxberryPickpoint;
use common\components\delivery\deliveryOutputCreator\common\DeliveryCreateException;
use common\components\delivery\deliveryOutputCreator\common\NeedUnsetDeliveryModelException;
use common\components\integrations\boxberry\helpers\DeliveryType;
use common\models\PickupPointBoxberry;

class DeliveryOutputCreatorBoxberryPickup extends DeliveryOutputCreatorBoxberry
{
    protected function getDeliveryType()
    {
        return DeliveryType::PICKUP;
    }

    protected function createNewDeliveryOutputObject()
    {
        return new DeliveryOutputBoxberryPickpoint();
    }

    /**
     * @throws DeliveryCreateException
     * @throws NeedUnsetDeliveryModelException
     */
    protected function fillParamsIfNotDisabled()
    {
        parent::fillParamsIfNotDisabled();

        $this->fillBoxberryPickpoints();
    }

    /**
     * @throws DeliveryCreateException
     * @throws NeedUnsetDeliveryModelException
     */
    protected function fillBoxberryPickpoints()
    {
        $cityModel = $this->cityModelTo;
        $cityBoxberry = $cityModel->cityBoxberry;

        if (!$cityModel || !$cityBoxberry->pickup_point) {
            throw new NeedUnsetDeliveryModelException();
        }

        $pickupPoints = PickupPointBoxberry::find()->where(['city_id' => $cityModel->id])->asArray()->all();

        if (empty($pickupPoints)) {
            throw new DeliveryCreateException("ID Города в таблице \"city\": {$cityModel->id}. Не найдены пункты выдачи. Но у города должны быть пункты выдачи так как cityBoxberry->pickup_point: {$cityBoxberry->pickup_point}");
        }

        foreach ($pickupPoints as $key => $pickupPoint) {
            $pickupPoints[$key]["price"] = $this->deliveryOutput->getPrice();

            $workSchedule = $pickupPoint["work_schedule"];
            if ($workSchedule && !empty($workSchedule)) {
                $workScheduleArr = explode(", ", $workSchedule);
                $pickupPoints[$key]["work_schedule"] = $workScheduleArr;
            }
            $gpsArr = explode(",", $pickupPoint["gps"]);
            $pickupPoints[$key]["latitude"] = $gpsArr[0];
            $pickupPoints[$key]["longitude"] = $gpsArr[1];
        }

        $this->deliveryOutput->setBoxberryPickups($pickupPoints);
    }
}