<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */

    private $id;

	public function authenticate()
	{
        /** @var User $user */
        $user = User::model()->findByAttributes(array('login'=>$this->username));

        if($user===null)
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        else if($user->passwd !== crypt($this->password,$user->passwd))
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
        else
        {
            $this->id=$user->id;
            //$this->setState('title', $record->title);
            $this->errorCode=self::ERROR_NONE;
        }
        return !$this->errorCode;
	}

    public function getId()
    {
        return $this->id;
    }
}