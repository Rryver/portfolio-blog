<?php


namespace api\modules\v1\requestModels\productController;


use api\modules\v1\requestModels\BaseRequestModel;

class ProductIndexRequestModel extends BaseRequestModel
{
    /**
     * @var float|null
     */
    private $priceFrom = null;

    /**
     * @var float|null
     */
    private $priceTo = null;

    /**
     * @var int|null
     */
    private $categoryId = null;

    /**
     * @var int|null
     */
    private $tagId = null;

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            [['priceFrom', 'priceTo'], 'double'],
            [['categoryId', 'tagId'], 'integer']
        ];
    }

    /**
     * @return float|null
     */
    public function getPriceFrom(): ?float
    {
        return $this->priceFrom;
    }

    /**
     * @param float|null $priceFrom
     */
    public function setPriceFrom(?float $priceFrom): void
    {
        $this->priceFrom = $priceFrom;
    }

    /**
     * @return float|null
     */
    public function getPriceTo(): ?float
    {
        return $this->priceTo;
    }

    /**
     * @param float|null $priceTo
     */
    public function setPriceTo(?float $priceTo): void
    {
        $this->priceTo = $priceTo;
    }

    /**
     * @return int|null
     */
    public function getCategoryId(): ?int
    {
        return $this->categoryId;
    }

    /**
     * @param int|null $categoryId
     */
    public function setCategoryId(?int $categoryId): void
    {
        $this->categoryId = $categoryId;
    }

    /**
     * @return int|null
     */
    public function getTagId(): ?int
    {
        return $this->tagId;
    }

    /**
     * @param int|null $tagId
     */
    public function setTagId(?int $tagId): void
    {
        $this->tagId = $tagId;
    }


}