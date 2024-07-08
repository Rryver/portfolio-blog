<?php


namespace api\modules\v1\models;


use common\models\products\Tag;

class TagApi extends Tag
{
    public function fields()
    {
        return [
            'id' => 'id',
            'title' => 'title',
        ];
    }
}