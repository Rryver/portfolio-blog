<?php


namespace api\modules\v1\dataAccess\productController;


use api\modules\v1\dataAccess\BaseDaService;
use api\modules\v1\models\ProductApi;
use api\modules\v1\requestModels\productController\ProductIndexRequestModel;
use yii\data\ActiveDataProvider;

class ProductIndexDaService extends BaseDaService
{
    /**
     * @var ProductIndexRequestModel|null
     */
    private ProductIndexRequestModel $requestModel;

    public function __construct(ProductIndexRequestModel $requestModel)
    {
        $this->requestModel = $requestModel;
    }

    function getData()
    {
        $query = ProductApi::find()->isActive();

        $query->andFilterWhere(['>=', "price", $this->requestModel->getPriceFrom()])
            ->andFilterWhere(['<=', "price", $this->requestModel->getPriceTo()])
            ->andFilterWhere(["category_id" => $this->requestModel->getCategoryId()]);

        $query->andWhereTag($this->requestModel->getTagId());

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
    }
}