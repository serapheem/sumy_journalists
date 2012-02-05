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
	 * Returns array of rules for different properties
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
			'title' => Yii::t( 'main', 'NAME' ),
			'alias' => Yii::t( 'main', 'ALIAS' ),
			'body' => Yii::t( 'main', 'CHARACTERISTIC' ),
			'publish' => Yii::t( 'main', 'PUBLISH' ),
			'top10' => Yii::t( 'main', 'FEATURED' ),
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
