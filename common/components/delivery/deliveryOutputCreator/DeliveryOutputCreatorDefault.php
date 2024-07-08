<?php


namespace common\components\delivery\deliveryOutputCreator;


class DeliveryOutputCreatorDefault extends DeliveryOutputCreatorAbstract
{

    /**
     * @inheritDoc
     */
    protected function calculateExternalDeliveryInfo()
    {
        //Не требуется для этой доcтавки
    }

    protected function fillPrice()
    {
        $this->deliveryOutput->setPrice($this->deliveryModel->price);
    }

    protected function fillTimeInterval()
    {
        //Не требуется для этой доcтавки
    }

    protected function fillDeliveryDate()
    {
        // TODO: Implement fillDeliveryDate() method.
    }
}