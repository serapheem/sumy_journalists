<?php

/**
 * Frontpage Model class
 */
class Frontpage extends CActiveRecord 
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
	public static function model($className = __CLASS__) 
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
	public function rules() 
	{
		return array(
			array( 'section, item_id', 'required' ),
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
		return '{{frontpage}}';
	}

}