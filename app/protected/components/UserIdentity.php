<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $id;
    /**
     * Authenticates a user.
     * @return boolean whether authentication succeeds.
     */
    public function authenticate()
    {
        $user = User::model()->findByAttributes(['username' => $this->username]);

        if ($user === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } elseif (!CPasswordHelper::verifyPassword($this->password, $user->password)) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        } else {
            $this->id = $user->id;
            $isAdmin = $user->role === 'admin';
            $this->setState('isAdmin', $isAdmin);
            $this->errorCode = self::ERROR_NONE;
        }
        return !$this->errorCode;
    }

    public function getId()
    {
        return $this->id;
    }
}
