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
class RegisterForm extends Model
{
    public $username;
    public $password;
    public $password2;
    public $fullname;
    public $email;
    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username', 'password','password2','fullname','email'], 'required'],
            ['password', 'match', 'pattern' => '/^[a-zA-Z0-9!@#$%^&*()]{6,}$/'],
            [['password2'], 'compare', 'compareAttribute' => 'password', 'message' => 'Passwords do not match.'],
            ['username','duplicateCheck','message' => 'Username is taken.'],
            ['email','email','message' => 'Please enter a valid email address.'],

        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function duplicateCheck($attribute,$params){
        if (!DBHandler::searchUsernameDuplicate($this->username)){
            $this->addError($attribute, 'Duplicate username.');
        }
    }
    public function matchPassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || $this->password !== $this->password2) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
        else 
            $this->addError($attribute, 'Missing fields.');
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function register()
    {
        if ($this->validate()) {
            $new = new User();
            $new->username = $this->username;
            $new->password = $this->password;
            $new->email = $this->email;
            $new->fullname = $this->fullname;

            return DBHandler::addUser($new);
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
