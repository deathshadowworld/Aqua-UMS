<?php

namespace app\models;
use app\models\DBHandler;
use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */
class ProfileForm extends Model
{
    public $username;
    public $fullname;
    public $email;
    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username','fullname','email'], 'required'],
            ['email','email','message' => 'Please enter a valid email address.'],

        ];
    }

    public function updateProfile()
    {
        if ($this->validate()) {
            $new = [
                'username'=>$this->username,
                'email'=>$this->email,
                'fullname'=>$this->fullname,
            ];

            return DBHandler::updateUser($new);
        }
        return false;
    }

    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
