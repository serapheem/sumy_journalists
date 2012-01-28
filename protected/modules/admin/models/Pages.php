<?php

/**
 * Pages Model class
 */
class Pages extends ModelBase
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
		return parent::model( $className );
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
			array( 'title, alias, body', 'safe' ),
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
			'title' => 'Назва',
			'body' => 'Текст',
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
		return '{{pages}}';
	}
	
	/**
	 * Returns array of relations with other tables
	 * 
	 * @access public
	 * 
	 * @return array 
	 */
    public function relations( )
    {
        return array( 
        	'author' => array( self::BELONGS_TO, 'Users', 'created_by'),
        	'updater' => array( self::BELONGS_TO, 'Users', 'modified_by')
		);
    }

}
