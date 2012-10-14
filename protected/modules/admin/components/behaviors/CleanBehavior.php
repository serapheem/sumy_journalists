<?php
/**
 * CleanBehavior class file.
 */

/**
 * CleanBehavior will automatically clean selected atributes.
 */
class CleanBehavior extends CActiveRecordBehavior
{
    /**
     * @var array The list of the attributes to clean.
     */
    public $attributes = array();

    /**
     * Responds to {@link CModel::onBeforeValidate} event.
     * Cleans the attributes from the list
     *
     * @param CModelEvent $event event parameter
     */
    public function beforeValidate(CModelEvent $event)
    {
        $owner = $this->getOwner();
        foreach ($this->attributes as $attr)
        {
            $owner->$attr = trim($owner->$attr);
        }
    }

}