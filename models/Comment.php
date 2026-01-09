<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Comment extends ActiveRecord
{
    public static function tableName()
    {
        return 'comments';
    }

    public function rules()
    {
        return [
            [['post_id', 'user_id', 'text'], 'required'],
            [['post_id', 'user_id', 'parent_id'], 'integer'],
            [['text'], 'string', 'min' => 1],
            [['created_at'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'text' => 'Коментар',
        ];
    }

    public function getPost()
    {
        return $this->hasOne(Post::class, ['id' => 'post_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getReplies()
    {
        return $this->hasMany(Comment::class, ['parent_id' => 'id'])
            ->orderBy(['created_at' => SORT_ASC]);
    }
}
