<?php

/**
 * Front page Model class
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
	public static function model( $className = __CLASS__ ) 
	{
		return parent::model( $className );
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
		return '{{frontpage}}';
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
			array( 'section, item_id', 'required' ),
		);
	}
	
	/**
	 * Returns the array with different rules for selection items
	 * 
	 * @access public
	 * 
	 * @return array
	 */
	public function scopes() 
    {
        return array(
            'ordering' => array( 'order' => 'ordering ASC' ),
        );
    }
	
	/**
	 * Returns the list of items on front page
	 * 
	 * @return array of items
	 */
	public function getList( )
	{
		// Get published news
    	$command = Yii::app( )->db->createCommand( );
		
		$fields = array( 'f.*' );
		$fields_name = array( 'title', 'alias', 'body', 'created', 'modified', 'ordering' => 'item_ordering' );
		
		// Get fields from other tables
		foreach ( $fields_name AS $index => $name )
		{
			if ( is_numeric( $index ) )
			{
				$index = $name;
			}
			
			$fields[] = "CASE f.section"
						. " WHEN 'KnowOur' THEN (SELECT ko.{$index} FROM know_our AS ko WHERE ko.id = f.item_id )"
						. " WHEN 'News' THEN (SELECT n.{$index} FROM news AS n WHERE n.id = f.item_id )"
						. " ELSE null"
						. " END AS '{$name}'";
		}
		
		$rows = $command->selectDistinct( $fields )
			->from( 'frontpage AS f' )
			->order( 'f.ordering ASC, modified DESC' )
			->queryAll( );
			
		foreach ( $rows AS &$row )
		{
			$row = (object) $row;
		}
		
		return $rows;
	}

}