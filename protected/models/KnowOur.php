<?php

/**
 * Know Our model class
 */
class KnowOur extends ModelBase 
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
        return '{{know_our}}';
    }

}