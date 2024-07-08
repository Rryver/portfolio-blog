<?php


namespace api\modules\v1\models;


use common\models\products\Product;
use common\models\products\ProductTag;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\helpers\Url;
use yii\web\Link;
use yii\web\Linkable;

class ProductApi extends Product implements Linkable
{
    public function fields()
    {
        return [
            'id' => 'id',
            'title' => 'title',
            'category' => 'category',
            'description' => 'description',
            'price' => 'price',
            'tags' => function() {
                $tags = $this->tags;

                if (!$tags) {
                    return [];
                }

                return $tags;
            },
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(CategoryApi::class, ["id" => "category_id"]);
    }

    /**
     * @return ActiveQuery
     * @throws InvalidConfigException
     * @throws \yii\base\InvalidConfigException
     */
    public function getTags()
    {
        return $this->hasMany(TagApi::class, ["id" => "tag_id"])->viaTable(ProductTag::tableName(), ["product_id" => "id"]);
    }

    /**
     * @inheritDoc
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(["/product/view", "id" => $this->id], true),
            'category' => Url::to(["category/view", "id" => $this->category_id], true),
            'addToCart' => Url::to(["/cart/add-product", "productId" => $this->id], true),
            'removeFromCart' => Url::to(["/cart/remove-product", "productId" => $this->id], true)
        ];
    }
}