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

}