<?php


namespace common\components\delivery\deliveryOutputCreator\common;


use common\components\cart\Cart;
use common\models\City;
use common\models\Delivery;

interface DeliveryOutputCreatorInterface
{
    public function __construct(Delivery $deliveryModel, City $cityModelTo, Cart $cart);

    public function create();
}