<?php


namespace api\modules\v1\controllers;


use api\components\ApiController;
use api\modules\v1\dataAccess\productController\ProductIndexDaService;
use api\modules\v1\requestModels\productController\ProductIndexRequestModel;
use Yii;
use yii\web\BadRequestHttpException;

class ProductController extends ApiController
{
    /**
     * @throws BadRequestHttpException
     */
    public function actionIndex()
    {
        $requestModel = new ProductIndexRequestModel(Yii::$app->request->post());

        return (new ProductIndexDaService($requestModel))->getData();
    }
}