<?php

/**
 * News Model class
 */
class Participants extends ModelBase 
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
	public function rules( ) 
	{
		return array(
			array( 'title, body', 'required' ),
			array( 'title, alias, body, publish, top10', 'safe' ),
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
			'title' => "Ім'я",
			'alias' => 'Посилання',
			'body' => 'Характеристика',
			'publish' => 'Опублікувати',
			'top10' => 'На головній',
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
		return '{{participants}}';
	}
	
}
