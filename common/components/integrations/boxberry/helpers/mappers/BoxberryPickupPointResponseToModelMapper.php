<?php


namespace common\components\integrations\boxberry\helpers\mappers;


use common\components\integrations\boxberry\helpers\Utils;
use common\components\integrations\boxberry\models\response\listPoints\BoxberryPickupPoint;
use common\models\PickupPointBoxberry;

class BoxberryPickupPointResponseToModelMapper
{
    /**
     * @var BoxberryPickupPoint
     */
    private $sourceCity;

    /**
     * @var PickupPointBoxberry
     */
    private $targetCity;

    /**
     * @param BoxberryPickupPoint $sourceCity
     * @param PickupPointBoxberry|null $targetCity
     * @return PickupPointBoxberry|null
     */
    public function convert(BoxberryPickupPoint $sourceCity, ?PickupPointBoxberry $targetCity)
    {
        $this->sourceCity = $sourceCity;

        if (!$targetCity) {
            $targetCity = new BoxberryPickupPoint();
        }

        $this->targetCity = $targetCity;

        $this->fillTarget();

        return $this->targetCity;
    }


    private function fillTarget()
    {
        $this->targetCity->boxberry_id = $this->sourceCity->getCode();
        $this->targetCity->boxberry_city_id = $this->sourceCity->getCityCode();
        $this->targetCity->name = $this->sourceCity->getName();
        $this->targetCity->address = $this->sourceCity->getAddress();
        $this->targetCity->boxberry_country_code = $this->sourceCity->getCountryCode();
        $this->targetCity->phone = $this->sourceCity->getPhone();
        $this->targetCity->work_schedule = $this->sourceCity->getWorkShedule();
        $this->targetCity->trip_description = $this->sourceCity->getTripDescription();
        $this->targetCity->gps = $this->sourceCity->getGps();
        $this->targetCity->only_prepaid_orders = Utils::strToBool($this->sourceCity->getOnlyPrepaidOrders());
        $this->targetCity->nalKD = Utils::strToBool($this->sourceCity->getNalKD());
        $this->targetCity->volume_limit = (float)$this->sourceCity->getVolumeLimit();
        $this->targetCity->weight_limit = $this->sourceCity->getLoadLimit();
        $this->targetCity->acquiring = Utils::strToBool($this->sourceCity->getAcquiring());
        $this->targetCity->is_postamat = Utils::strToBool($this->sourceCity->getPostamat());
    }
}