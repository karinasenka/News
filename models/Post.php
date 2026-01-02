<?php

namespace app\models;

use yii\db\ActiveRecord;

class Post extends ActiveRecord

{
    public static function tableName()

    {

        return 'news';

    }
        public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }


}