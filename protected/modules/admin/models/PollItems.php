<?php

/**
 * PollItems Model class
 */
class PollItems extends CActiveRecord 
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
			array( 'title, poll_id', 'required' ),
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
		return '{{poll_items}}';
	}
	
	/**
	 * Returns the array with different rules for selection items
	 * 
	 * @access public
	 * 
	 * @return array
	 */
	public function scopes( ) 
	{
		return array(
			'ordering' => array( 'order' => 'ordering ASC' ),
		);
	}

}