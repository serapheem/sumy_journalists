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
            'published' => array(
                'condition' => 'publish=1',
                'order' => 'ordering ASC',
            ),
        );
    }
	
}