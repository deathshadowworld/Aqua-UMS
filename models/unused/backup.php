<?php

namespace app\models;

use app\models\databasehandler;

class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface
{
    public $id;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;


    private static $dummy = [
        '100' => [
            'id' => '100',
            'username' => 'admin',
            'password' => 'admin',
            #'authKey' => 'test100key',
            #'accessToken' => '100-token',
        ],
        '101' => [
            'id' => '101',
            'username' => 'demo',
            'password' => 'demo',
            #'authKey' => 'test101key',
            #'accessToken' => '101-token',
        ],
        '102' => [
            'id' => '102',
            'username' => 'marisa',
            'password' => 'admin',
        ],
    ];



    private static $users;


    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {

        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
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
        $host = 'localhost';
        $port = '5432';
        $dbname = 'aquaums';
        $dbusername = 'ec2-user';
        $password = 'u0mA7l6HJ60EgYH1nY5hzr5A422reYdL';

        $connection = pg_connect("host=$host port=$port dbname=$dbname user=$dbusername password=$password");

        if (!$connection) {
            die('Database connection failed: ' . pg_last_error());
        }

        $query = "SELECT id, username, password, authkey, accesstoken FROM \"user\" WHERE username = '$username'";
        $result = pg_query($connection, $query);

        $row = pg_fetch_assoc($result);
        if (isset($row)) {
            return new static($row);
        } else {
            return null;
        }



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

    public function setAuthKey($key)
    {
        $this->authKey = $key;
    }
    public function setAccessToken($key)
    {
        $this->accessToken = $key;
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
