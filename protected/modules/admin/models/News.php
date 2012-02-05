<?php

/**
 * News Model class
 */
class News extends ModelBase 
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
            array( 'title, alias, body, publish, frontpage', 'safe' ),
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
            'alias' => Yii::t( 'main', 'ALIAS' ),
            'body' => Yii::t( 'main', 'TEXT' ),
            'publish' => Yii::t( 'main', 'PUBLISH' ),
            'frontpage' => Yii::t( 'main', 'FEATURED' ),
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
        return '{{news}}';
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
            'frontpage' => array( self::HAS_ONE, 'Frontpage', 'item_id', 'condition' => "frontpage.section='News'" ),
        );
    }
	
}