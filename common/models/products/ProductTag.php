<?php


namespace common\models\products;


use common\models\CommonActiveRecord;
use yii\db\ActiveQuery;


/**
 * Class ProductTag
 * @package common\models\product
 *
 * @property int $id
 * @property int $product_id
 * @property int $tag_id
 *
 * @property Product $product
 * @property Tag $tag
 */
class ProductTag extends CommonActiveRecord
{
    public static function tableName()
    {
        return '{{%product_tag}}';
    }

    public function rules()
    {
        return [
            [['product_id', 'tag_id'], 'required'],
            [['product_id', 'tag_at'], 'integer'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
            [['tag_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tag::class, 'targetAttribute' => ['tag_id' => 'id']],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ["id" => "product_id"]);
    }

    /**
     * @return ActiveQuery
     */
    public function getTag()
    {
        return $this->hasOne(Tag::class, ["id" => "tag_id"]);
    }
}