<?php

namespace app\models;

use yii\db\ActiveRecord;
use app\models\Comment;

class Post extends ActiveRecord
{
    public $imageFile;
    public static function tableName()
    {
        return 'news';
    }

    public function rules()
    {
        return [
            [['category_id', 'title', 'text'], 'required'],
            [['category_id', 'published'], 'integer'],
            [['text'], 'string'],
            [['created_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['tags'], 'string', 'max' => 255],
            [['tags'], 'filter', 'filter' => function($v){
                $v = trim((string)$v);
                $v = preg_replace('/\s*,\s*/u', ', ', $v);
                $v = preg_replace('/\s{2,}/u', ' ', $v);
                return $v;
            }],
            [['imageFile'], 'file', 'extensions' => 'png, jpg, jpeg, webp', 'skipOnEmpty' => true],
        ];
    }

    public function attributeLabels()
    {
        return [
            'category_id' => 'Категорія',
            'title' => 'Заголовок',
            'text' => 'Текст',
            'created_at' => 'Дата створення',
            'published' => 'Опубліковано',
            'tags' => 'Мітки (через кому)',
        ];
    }


    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }
    public function getComments()
    {
        return $this->hasMany(Comment::class, ['post_id' => 'id'])
            ->where(['parent_id' => null])
            ->orderBy(['created_at' => SORT_DESC]);
    }   

}
