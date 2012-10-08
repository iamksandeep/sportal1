<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;

	/**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$validUser = User::model()->findByAttributes(array(
			'email' => $this->username,
		));

		// check for valid username
		if($validUser === null)
			$this->errorCode=self::ERROR_USERNAME_INVALID;

		// check for valid password
		elseif(!$validUser->checkPassword($this->password))
				$this->errorCode=self::ERROR_PASSWORD_INVALID;

		// success
		else {
			$this->_id = $validUser->id;
			$this->setState('name', $validUser->name);
			$this->setState('type', $validUser->type0);
			$this->setState('gravatarAndName', $validUser->getGravatarAndName());
			$this->errorCode=self::ERROR_NONE;
		}

		return !$this->errorCode;
	}

	/**
	 * @return int user id
	 */
	public function getId()	{
		return $this->_id;
	}
}
