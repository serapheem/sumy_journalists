<?php

class Login extends CFormModel 
{
	public $username;
	public $password;
	public $rememberMe = false;
	private $_identity;

	public function rules() 
	{
		return array(
			array('username, password', 'required'),
			array('password', 'authenticate'),
			array('rememberMe', 'boolean'),
		);
	}

	public function attributeLabels() 
	{
		return array(
			'rememberMe' => 'Запам\'ятати мене',
			'username' => 'Логін',
			'password' => 'Пароль',
		);
	}

	public function authenticate($attribute, $params) 
	{
		if ( !$this->hasErrors() ) 
		{
			$this->_identity = new UserIdentity($this->username, $this->password);
			$this->_identity->authenticate();

			switch ($this->_identity->errorCode) {
				case UserIdentity::ERROR_USERNAME_INVALID:
					$this->addError('username', 'Ім\'я користувача неправильне.');
					break;
				case UserIdentity::ERROR_PASSWORD_INVALID:
					$this->addError('password', 'Невірний пароль.');
					break;
				default:
					break;
			}
		}
	}

	public function login() 
	{
		if ($this->_identity === null) 
		{
			$this->_identity = new UserIdentity($this->username, $this->password);
			$this->_identity->authenticate();
		}

		if ($this->_identity->errorCode === UserIdentity::ERROR_NONE) 
		{
			Yii::app()->user->login($this->_identity, 3600 * 24 * 30);
			return true;
		}
		else
			return false;
	}

}
