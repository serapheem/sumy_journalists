<?php

/**
 * Users Model class
 */
class Users extends CActiveRecord 
{
	/**
	 * Repeat password data
	 * 
	 * @access public
	 * @var string
	 */
	public $password2;
	
	/**
	 * Returns the model object
	 * 
	 * @static
	 * @access public
	 * @param string $className 
	 * 
	 * @return object
	 */
	public static function model( $className = __CLASS__ ) 
	{
	   return parent::model($className);
	}
	
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
			array( 'name, username, email, password, password2', 'required' ),
			array( 'password', 'compare', 'compareAttribute' => 'password2' ),
			array( 'email', 'email' ),
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
			'name' => Yii::t( 'main', 'USER_NAME' ),
			'username' => Yii::t( 'main', 'LOGIN' ),
			'email' => Yii::t( 'main', 'EMAIL' ),
			'password' => Yii::t( 'main', 'PASSWORD' ),
			'password2' => Yii::t( 'main', 'REPEAT_PASSWORD' ),
		);
	}

	/**
	 * Returns the name of table
	 * 
	 * @access public
	 * 
	 * @return string
	 */
	public function tableName( ) 
	{
		return '{{users}}';
	}

}