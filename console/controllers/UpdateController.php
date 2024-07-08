<?php


namespace console\controllers;


use common\components\services\delivery\BoxberryUpdateService;
use yii\console\Controller;
use yii\db\Exception;

class UpdateController extends Controller
{
    /**
     * Обновление списка городов для доставки Boxberry
     * Рекомендуемая частота: раз в сутки
     * @throws Exception
     */
    public function actionUpdateBoxberryCities()
    {
        $updateService = new BoxberryUpdateService();

        $updateService->updateCities();
    }

    /**
     * Обновление списка пунктов выдачи для доставки Boxberry
     * Рекомендуемая частота: раз в час
     * @throws Exception
     */
    public function actionUpdateBoxberryPickupPoints()
    {
        $updateService = new BoxberryUpdateService();

        $updateService->updatePickupPoints();
    }


}