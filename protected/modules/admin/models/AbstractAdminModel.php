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

}
