<?php

class UserIdentity extends CUserIdentity 
{
	/**
	 * Identifier of user
	 * 
	 * @var integer
	 */
	private $_id;
	
	public function authenticate() 
	{
		$record = Users::model()->findByAttributes( array( 'username' => $this->username ) );

		if ($record === null)
		{
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		}
		else if ($record->password !== sha1( $record->email . $this->password ) )
		{
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
		}
		else {
			Users::model()->updateByPk(
				$record->id, array(
					'ip' => Yii::app()->request->getUserHostAddress(),
					'lasttime' => date('Y-m-d H:i:s'),
				)
			);

			$this->_id = $record->id;
			$this->setState('username', $record->username);
			$this->errorCode = self::ERROR_NONE;
		}
		return !$this->errorCode;
	}

	public function getId() 
	{
		return $this->_id;
	}

}