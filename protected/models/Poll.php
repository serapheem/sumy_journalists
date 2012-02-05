<?php

/**
 * Poll model class
 */
class Poll extends ModelBase 
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
        return '{{poll}}';
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
            'items' => array( self::HAS_MANY, 'PollItems', 'poll_id', 'order' => 'ordering ASC' ),
        );
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
            'published' => array(
                'condition' => 'publish=1',
                'order' => 'RAND() ASC',
                'limit' => 1,
            ),
        );
    }

}