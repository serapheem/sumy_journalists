<?php

/**
 * Base Model class
 */
class ModelBase extends CActiveRecord 
{
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
            'ordering' => array(
                'order' => 'ordering ASC',
            ),
        );
    }
	
	/**
	 * Sets the created/modified time and user before save item
	 * 
	 * @access protected
	 * 
	 * @return boolean
	 */
	protected function beforeSave()
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
		
		if ( !$this->alias )
		{
			$this->alias = Helper::translit( $this->title );
		}
		else {
			$this->alias = Helper::translit( $this->alias );
		}
		
		return parent::beforeSave();
	}

}