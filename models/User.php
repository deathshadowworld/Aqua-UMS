<?php

namespace app\models;
use app\models\DBHandler;
use yii\data\ActiveDataProvider;

class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface
{
    public $id;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;
    public $fullname;
    public $email;
    public $admin;

    private static $users = [
        1 => [
            'id' => '1',
            'username' => 'admin',
            'password' => 'admin',
            'fullname' => 'John Doe',
            'email' => 'asd@asd.com',
            'admin' => true,
            'authKey' => 'test1key',
            'accessToken' => '1-token',
        ],
        2 => [
            'id' => '2',
            'username' => 'marisa',
            'password' => 'root',
            'fullname' => 'Marisa Kirisame',
            'email' => 'asda@ada.com',
            'admin' => true,
            'authKey' => 'test2key',
            'accessToken' => '1-token',
        ],
    ];


    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        $dbc = new DBHandler;
        $users = $dbc->getUser();
        return isset($users[$id]) ? new static($users[$id]) : null;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $dbc = new DBHandler;
        $users = $dbc->getUser();
        foreach ($users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $dbc = new DBHandler;
        $users = $dbc->getUser();
        foreach ($users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }

    

}
