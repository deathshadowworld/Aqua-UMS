<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return 'user';
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // Not implemented for simplicity
        return null;
    }

    /**
     * Finds user by username.
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * Finds user by password reset token.
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        // Not implemented for simplicity
        return null;
    }

    /**
     * Returns the user's ID.
     *
     * @return int|string the user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the user's authentication key.
     *
     * @return string the authentication key
     */
    public function getAuthKey()
    {
        // Not implemented for simplicity
        return null;
    }

    /**
     * Validates the given authentication key.
     *
     * @param string $authKey the given authentication key
     * @return bool whether the given authentication key is valid
     */
    public function validateAuthKey($authKey)
    {
        // Not implemented for simplicity
        return false;
    }

    /**
     * Validates the password.
     *
     * @param string $password the password to validate
     * @return bool whether the password is valid
     */
    public function validatePassword($password)
    {
        return password_verify($password, $this->password);
    }
}
