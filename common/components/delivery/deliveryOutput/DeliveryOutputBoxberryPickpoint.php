<?php


namespace common\components\delivery\deliveryOutput;


class DeliveryOutputBoxberryPickpoint extends DeliveryOutputDefault
{
    protected $boxberryPickups = [];

    public function fields()
    {
        $fields = [
            'boxberry_pickups' => 'boxberryPickups',
        ];

        return array_merge(parent::fields(), $fields);
    }

    /**
     * @return array
     */
    public function getBoxberryPickups(): array
    {
        return $this->boxberryPickups;
    }

    /**
     * @param array $boxberryPickups
     */
    public function setBoxberryPickups(array $boxberryPickups): void
    {
        $this->boxberryPickups = $boxberryPickups;
    }

}