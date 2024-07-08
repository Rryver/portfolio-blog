<?php


namespace common\components\integrations\boxberry\helpers\mappers;


use common\components\integrations\boxberry\helpers\Utils;
use common\components\integrations\boxberry\models\response\listCitiesFull\BoxberryCity;
use common\models\CityBoxberry;

class BoxberryCityResponseToModelMapper
{
    /**
     * @var BoxberryCity
     */
    private $sourceCity;

    /**
     * @var CityBoxberry
     */
    private $targetCity;

    /**
     * @param BoxberryCity $sourceCity
     * @param CityBoxberry $targetCity
     * @return CityBoxberry
     */
    public function convert(BoxberryCity $sourceCity, CityBoxberry $targetCity)
    {
        $this->sourceCity = $sourceCity;

        if (!$targetCity) {
            $targetCity = new CityBoxberry();
        }

        $this->targetCity = $targetCity;

        $this->fillTarget();

        return $this->targetCity;
    }


    private function fillTarget()
    {
        $this->targetCity->boxberry_id = $this->sourceCity->getCode();
        $this->targetCity->kladr = $this->sourceCity->getKladr();
        $this->targetCity->name = $this->sourceCity->getName();
        $this->targetCity->uniq_name = $this->sourceCity->getUniqName();
        $this->targetCity->country_code = $this->sourceCity->getCountryCode();
        $this->targetCity->region = $this->sourceCity->getRegion();
        $this->targetCity->district = $this->sourceCity->getDistrict();
        $this->targetCity->prefix = $this->sourceCity->getPrefix();
        $this->targetCity->foreign_reception_returns = Utils::strToBool($this->sourceCity->getForeignReceptionReturns());
        $this->targetCity->terminal = Utils::strToBool($this->sourceCity->getTerminal());
        $this->targetCity->pickup_point = Utils::strToBool($this->sourceCity->getPickupPoint());
        $this->targetCity->courier_delivery = Utils::strToBool($this->sourceCity->getCourierDelivery());
        $this->targetCity->courier_reception = Utils::strToBool($this->sourceCity->getCourierReception());
    }
}