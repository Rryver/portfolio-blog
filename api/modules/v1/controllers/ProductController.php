<?php


namespace api\modules\v1\controllers;


use api\components\ApiController;
use api\modules\v1\dataAccess\productController\ProductIndexDaService;

class ProductController extends ApiController
{
    public function actionIndex()
    {
        return (new ProductIndexDaService())->getData();
    }

    public function actionView()
    {

    }

    public function actionTags()
    {

    }

}