<?php


namespace common\models\products;


use common\models\CommonActiveRecord;
use yii\base\InvalidConfigException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * Class Tag
 * @package common\models\products
 *
 * @property int $id
 * @property int $category_id
 * @property string $title
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Product[] $products
 */
class Tag extends CommonActiveRecord
{
    public static function tableName()
    {
        return '{{%tag}}';
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
            [['category_id', 'created_at', 'updated_at'], 'integer']
        ];
    }

    /**
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ["id" => "product_id"])->viaTable(ProductTag::tableName(), ["tag_id" => "id"]);
    }
}