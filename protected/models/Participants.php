<?php

/**
 * Participants model class
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
        return '{{participants}}';
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
                'order' => 'ordering ASC',
            ),
            'top10' => array(
                'condition' => 'top10=1',
            ),
            'results' => array(
                'condition' => 'publish=1 AND top10=1',
                'order' => 'rating DESC',
            ),
        );
    }

}