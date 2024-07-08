<?php


namespace common\models\products;


use common\models\CommonActiveRecord;
use yii\base\InvalidConfigException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * Class Product
 * @package common\models\products
 *
 * @property int $id
 * @property int $category_id
 * @property string $title
 * @property string $description
 * @property double $price
 * @property boolean $is_active
 * @property boolean $is_deleted
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Category $category
 * @property Tag[] $tags
 */
class Product extends CommonActiveRecord
{
    public static function tableName()
    {
        return '{{%product}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function rules()
    {
        return [
            [['category_id', 'title'], 'required'],
            [['title', 'description'], 'string'],
            [['is_active', 'is_deleted'], 'boolean'],
            [['category_id', 'created_at', 'updated_at'], 'integer'],
            [['price'], 'double']
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ["id" => "category_id"]);
    }

    /**
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getTags()
    {
        return $this->hasMany(Tag::class, ["id" => "tag_id"])->viaTable(ProductTag::class, ["product_id" => "id"]);
    }
}