<?php
namespace app\models;

use yii\db\ActiveRecord;

class Category extends ActiveRecord
{
    public static function tableName()
    {
        return 'categories';
    }

    public function getPosts()
    {
        return $this->hasMany(Post::class, ['category_id' => 'id']);
    }
}