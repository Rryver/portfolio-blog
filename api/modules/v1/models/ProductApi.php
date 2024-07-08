<?php


namespace api\modules\v1\models;


use common\models\products\Product;
use common\models\products\ProductTag;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;

class ProductApi extends Product
{
    public function fields()
    {
        return [
            'id' => 'id',
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
        return $this->hasMany(TagApi::class, ["id" => "tag_id"])->viaTable(ProductTag::class, ["product_id" => "id"]);
    }
}