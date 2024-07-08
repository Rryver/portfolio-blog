<?php


namespace common\models\products;


use common\models\CommonActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * Class Category
 * @package common\models\products
 *
 * @property int $id
 * @property int $parent_id
 * @property string $title
 * @property boolean $is_active
 * @property boolean $is_deleted
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Category $parentCategory
 * @property Product[] $products
 */
class Category extends CommonActiveRecord
{
    public static function tableName()
    {
        return '{{%category}}';
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
            [['title'], 'required'],
            [['title'], 'string'],
            [['is_active', 'is_deleted'], 'boolean'],
            [['parent_id', 'created_at', 'updated_at'], 'integer']
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getParentCategory()
    {
        return $this->hasOne(Category::class, ["id" => "parent_id"]);
    }

    /**
     * @return ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ["category_id" => "id"]);
    }
}