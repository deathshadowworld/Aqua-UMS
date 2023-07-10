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
class PasswordForm extends Model
{
    public $username;
    public $password;
    public $password2;
    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username','password','password2'], 'required'],
            ['password', 'match', 'pattern' => '/^[a-zA-Z0-9!@#$%^&*()]{6,}$/'],
            [['password2'], 'compare', 'compareAttribute' => 'password', 'message' => 'Passwords do not match.'],
        ];
    }

    public function updatePassword()
    {
        if ($this->validate()) {
            $new = [
                'username'=>$this->username,
                'password'=>$this->password,
            ];

            return DBHandler::updatePassword($new);
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
