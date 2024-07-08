<?php


namespace common\models\query\products;


use common\models\products\Product;
use common\models\products\ProductTag;
use common\models\products\Tag;
use yii\db\ActiveQuery;

class ProductQuery extends ActiveQuery
{
    /**
     * @return $this
     */
    public function isActive()
    {
        $this->isNotDeleted()->andWhere([Product::tableName() . ".is_active" => true]);

        return $this;
    }

    /**
     * @return $this
     */
    public function isNotDeleted()
    {
        $this->andWhere([Product::tableName() . ".is_deleted" => false]);

        return $this;
    }

    /**
     * @param int|null $tagId
     * @return $this
     */
    public function andWhereTag(?int $tagId = null)
    {
        if (!$tagId) {
            return $this;
        }

        $this->leftJoin(ProductTag::tableName(), ProductTag::tableName() . ".product_id = " . Product::tableName() . ".id")
            ->andWhere([ProductTag::tableName() . ".tag_id" => $tagId]);

        return $this;
    }
}