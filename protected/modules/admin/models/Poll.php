<?php

/**
 * CityStyle Model class
 */
class Poll extends CActiveRecord 
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
	 * Returns array of rules for different properties
	 * 
	 * @access public
	 * 
	 * @return array
	 */
	public function rules( ) 
	{
		return array(
			array( 'title, publish', 'required' ),
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
			'title' => Yii::t( 'main', 'TITLE' ),
			'publish' => Yii::t( 'main', 'PUBLISH' ),
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
		return '{{poll}}';
	}

}