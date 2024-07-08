<?php


namespace common\components\delivery;


use common\components\cart\Cart;
use common\components\delivery\deliveryOutput\DeliveryOutputDefault;
use common\components\delivery\deliveryOutputCreator\common\NeedUnsetDeliveryModelException;
use common\components\delivery\deliveryOutputCreator\DeliveryOutputCreatorBoxberry;
use common\components\delivery\deliveryOutputCreator\DeliveryOutputCreatorBoxberryPickup;
use common\components\delivery\deliveryOutputCreator\DeliveryOutputCreatorDefault;
use common\models\City;
use Exception;
use common\models\Delivery;

class DeliveryCalculator
{
    /**
     * Формирование информации по доставке
     *
     * @param Delivery $deliveryModel
     * @param City $cityModelTo
     * @return DeliveryOutputDefault|null
     */
    public function calculateDelivery(Delivery $deliveryModel, City $cityModelTo)
    {
        $cart = Cart::getCurrentUserCart();

        try {
            $deliveryOutputCreator = $this->getDeliveryOutputCreator($deliveryModel, $cityModelTo, $cart);
            $deliveryOutput = $deliveryOutputCreator->create();
        } catch (NeedUnsetDeliveryModelException $e) {
            return null;
        } catch (Exception $e) {
            return null;
        }

        return $deliveryOutput;
    }

    /**
     * Формирование информации по доставкам
     *
     * @param Delivery[] $deliveryModels
     * @param City $cityModelTo
     * @return DeliveryOutputDefault[]
     */
    public function calculateDeliveries(array $deliveryModels, City $cityModelTo): array
    {
        $result = [];

        if (empty($deliveryModels)) {
            return $result;
        }

        $cart = Cart::getCurrentUserCart();

        foreach ($deliveryModels as $key => $deliveryModel) {
            try {
                $deliveryOutputCreator = $this->getDeliveryOutputCreator($deliveryModel, $cityModelTo, $cart);
                $deliveryOutput = $deliveryOutputCreator->create();
            } catch (NeedUnsetDeliveryModelException $e) {
                unset($deliveryModels[$key]);
                continue;
            } catch (Exception $e) {
                continue;
            }

            $result[] = $deliveryOutput;
        }

        return $result;
    }

    /**
     * Создание нужного класса для расчета доставки в зависимости от настроек модели доставки
     *
     * @param Delivery $deliveryModel
     * @param City $cityModelTo
     * @param Cart|null $cart
     *
     * @return DeliveryOutputCreatorDefault|DeliveryOutputCreatorBoxberry|DeliveryOutputCreatorBoxberryPickup
     * @throws NeedUnsetDeliveryModelException
     */
    private function getDeliveryOutputCreator(Delivery $deliveryModel, City $cityModelTo, Cart $cart = null)
    {
        switch ($deliveryModel->delivery_type) {
            case Delivery::DELIVERY_DEFAULT:
                return new DeliveryOutputCreatorDefault($deliveryModel, $cityModelTo, $cart);
            case Delivery::DELIVERY_BOXBERRY:
                return new DeliveryOutputCreatorBoxberry($deliveryModel, $cityModelTo, $cart);
            case Delivery::DELIVERY_BOXBERRY_PICKUP:
                return new DeliveryOutputCreatorBoxberryPickup($deliveryModel, $cityModelTo, $cart);
            default:
                throw new NeedUnsetDeliveryModelException("Не найден DeliveryOutputCreator для доставки. ID Доставки в БД: {$deliveryModel->id}");
        }
    }
}