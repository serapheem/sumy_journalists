<?php
/**
 * Contains CleanBehavior class
 *
 * @author      Serhiy Hlushko <serhiy.hlushko@gmail.com>
 * @copyright   Copyright 2013 Hlushko inc.
 * @company     Hlushko inc.
 */

/**
 * CleanBehavior will automatically clean selected attributes
 */
class CleanBehavior extends CActiveRecordBehavior
{
    /**
     * @var array The list of the attributes to clean.
     */
    public $attributes = array();

    /**
     * Responds to {@link CActiveRecord::onBeforeValidate} event.
     * Cleans the attributes from the list
     *
     * @param CModelEvent $event event parameter
     */
    public function beforeValidate(CModelEvent $event)
    {
        $owner = $this->getOwner();
        foreach ($this->attributes as $attr) {
            $owner->$attr = trim($owner->$attr);
        }
    }

}