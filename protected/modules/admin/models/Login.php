<?php

/**
 * Login Model class
 */
class Login extends CFormModel 
{
	/**
	 * Name of user
	 * 
	 * @access public
	 * @var string
	 */
	public $username;
	
	/**
	 * User password
	 * 
	 * @access public
	 * @var string
	 */
	public $password;
	
	/**
	 * Need to remember user
	 * 
	 * @access public
	 * @var boolean
	 */
	public $rememberMe = false;
	
	private $_identity;
	
	/**
	 * Returns array of rules for different properties
	 * 
	 * @access public
	 * 
	 * @return array
	 */
	public function rules( ) 
	{
		return array(
			array( 'username, password', 'required' ),
			array( 'password', 'authenticate' ),
			array( 'rememberMe', 'boolean' ),
		);
	}
	
	/**
	 * Returns labels for properties
	 * 
	 * @access public
	 * 
	 * @return array
	 */
	public function attributeLabels( ) 
	{
		return array(
			'username' => Yii::t( 'main', 'LOGIN' ),
			'password' => Yii::t( 'main', 'PASSWORD' ),
			'rememberMe' => Yii::t( 'main', 'REMEMBER_ME' ),
		);
	}
	
	/**
	 * Processes the authenticate of user
	 * 
	 * @access public
	 */
	public function authenticate( $attribute, $params ) 
	{
		if ( !$this->hasErrors( ) ) 
		{
			$this->_identity = new UserIdentity( $this->username, $this->password );
			$this->_identity->authenticate( );

			switch ( $this->_identity->errorCode ) 
			{
				case UserIdentity::ERROR_USERNAME_INVALID:
					$this->addError( 'username', Yii::t( 'main', 'LOGIN_INCORRECT' ) );
					break;
					
				case UserIdentity::ERROR_PASSWORD_INVALID:
					$this->addError( 'password', Yii::t( 'main', 'PASSWORD_INCORRECT' ) );
					break;
					
				default:
					break;
			}
		}
	}
	
	/**
	 * Processes the login of user
	 * 
	 * @access public
	 * 
	 * @return boolean
	 */
	public function login( ) 
	{
		if ( $this->_identity === null ) 
		{
			$this->_identity = new UserIdentity( $this->username, $this->password );
			$this->_identity->authenticate( );
		}

		if ( $this->_identity->errorCode === UserIdentity::ERROR_NONE ) 
		{
			Yii::app( )->user->login( $this->_identity, 3600 * 24 * 30 );
			return true;
		}
		else {
			return false;
		}
	}

}
