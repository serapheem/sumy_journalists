<?php

/**
 * CityStyle Model class
 */
class CityStyle extends ModelBase 
{
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
	 * Returns array of rules for diferent properties
	 * 
	 * @access public
	 * 
	 * @return array
	 */
	public function rules() 
	{
		return array(
			array( 'title, body', 'required' ),
			array( 'title, alias, body, publish', 'safe' ),
		);
	}

	/**
	 * Returns labels for properties
	 * 
	 * @access public
	 * 
	 * @return array
	 */
	public function attributeLabels() 
	{
		return array(
			'title' => 'Назва',
			'alias' => 'Посилання',
			'body' => 'Текст',
			'publish' => 'Опублікувати',
		);
	}

	/**
	 * Returns the name of table
	 * 
	 * @access public
	 * 
	 * @return string
	 */
	public function tableName() 
	{
		return '{{city_style}}';
	}
	
}
