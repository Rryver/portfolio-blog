<?php


namespace common\components\integrations\boxberry\models\response;


use common\components\integrations\boxberry\models\response\listPoints\BoxberryPickupPoint;

class ListPointsResponse extends BaseBoxberryResponse
{
    /**
     * @var BoxberryPickupPoint[]
     */
    private $listPoints;

    /**
     * @return BoxberryPickupPoint[]
     */
    public function getListPoints(): array
    {
        return $this->listPoints;
    }

    /**
     * @param BoxberryPickupPoint[] $listPoints
     */
    public function setListPoints(array $listPoints): void
    {
        foreach ($listPoints as $listPoint) {
            if ($listPoint instanceof BoxberryPickupPoint) {
                $this->listPoints[] = $listPoint;
            } else {
                $this->listPoints[] = new BoxberryPickupPoint($listPoint);
            }
        }
    }


}