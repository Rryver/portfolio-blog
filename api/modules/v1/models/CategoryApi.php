<?php


namespace api\modules\v1\models;


use common\models\products\Category;

class CategoryApi extends Category
{
    public function fields()
    {
        return [
            'id' => 'id',
            'title' => 'title',
        ];
    }
}