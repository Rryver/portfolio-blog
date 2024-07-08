<?php


namespace api\modules\v1\dataAccess\productController;


use api\modules\v1\dataAccess\BaseDaService;
use api\modules\v1\requestModels\productController\ProductIndexRequestModel;

class ProductIndexDaService extends BaseDaService
{
    protected $requestModelClass = ProductIndexRequestModel::class;

    function processData()
    {

    }
}