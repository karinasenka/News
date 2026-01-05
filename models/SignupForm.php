<?php

namespace app\models;

use yii\base\Model;
use app\models\User;

class SignupForm extends Model
{
    public $name;
    public $email;
    public $password;

    public function rules()
    {
        return [
            [['name', 'email', 'password'], 'required'],
            [['name'], 'string','max'=>255],
            [['email'], 'email'],
            ['password', 'string', 'min' => 6],
            [['email'], 'unique', 'targetClass'=>'app\models\User', 'targetAttribute'=>'email']
        ];
    }

    public function signup()
    {
        if (!$this->validate()) {
            return false;
        }
            $user = new User();
            $user->name = $this->name;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->generateAccessToken();
            return $user->save();
        
    }
}
