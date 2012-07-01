<?php
/**
 * File for abstract model for admin module
 */

/**
 * Abstract Admin Model class
 */
abstract class AbstractAdminModel extends CActiveRecord 
{
	/**
	 * @see CActiveRecord::__construct
	 */
	public function __construct($scenario='insert')
	{
		parent::__construct( $scenario );
		
		// TODO : read more about that
		//$this->attachEventHandler( 'beforeSave', '' );
	}
	
	/**
	 * Returns array of rules for different properties
	 * @return array
	 */
	public function rules() 
	{
		return array(
			array( 'title, description', 'required' ),
			array( 'title, alias, description, parent_id, state, section, params, metakey, metadesc, metadata', 'safe' ),
		);
	}
	
	/**
	 * Returns labels for properties
	 * @return array
	 */
	public function attributeLabels() 
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
	 * Sets the created/modified time and user before save item
	 * @return boolean
	 */
	protected function beforeSave()
	{
		$allowedActions = array( 'insert', 'update' );
		if ( in_array( $this->getScenario(), $allowedActions ) )
		{
			$this->modified = date( 'Y-m-d H:i:s' );
			$this->modified_by = Yii::app()->user->id;
			
			if ( $this->isNewRecord || empty( $this->created ) ) 
			{
				$this->created = $this->modified;
			}
			if ( $this->isNewRecord || empty( $this->created_by ) ) 
			{
				$this->created_by = $this->modified_by;
			}
			
			// TODO : always need to use this class
			if ( !$this->alias )
			{
				$this->alias = TranslitHelper::perform( $this->title );
			}
			else {
				$this->alias = TranslitHelper::perform( $this->alias );
			}
		}
		
		return parent::beforeSave();
	}

}
