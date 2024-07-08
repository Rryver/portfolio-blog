<?php


namespace common\components\integrations\boxberry\models\response;


use common\components\integrations\boxberry\models\response\listCitiesFull\BoxberryCity;

class ListCitiesFullResponse extends BaseBoxberryResponse
{
    /**
     * @var BoxberryCity[]
     */
    private $boxberryCities;

    /**
     * @return BoxberryCity[]
     */
    public function getBoxberryCities(): array
    {
        return $this->boxberryCities;
    }

    /**
     * @param BoxberryCity[] $boxberryCities
     */
    public function setBoxberryCities(array $boxberryCities): void
    {
        foreach ($boxberryCities as $boxberryCity) {
            if ($boxberryCity instanceof BoxberryCity) {
                $this->boxberryCities[] = $boxberryCity;
            } else {
                $this->boxberryCities[] = new BoxberryCity($boxberryCity);
            }
        }
    }


}