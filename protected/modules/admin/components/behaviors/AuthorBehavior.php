<?php
/**
 * Contains AuthorBehavior class
 *
 * @author      Serhiy Hlushko <serhiy.hlushko@gmail.com>
 * @copyright   Copyright 2013 Hlushko inc.
 * @company     Hlushko inc.
 */

/**
 * AuthorBehavior will automatically fill user identifier related atributes.
 */
class AuthorBehavior extends CActiveRecordBehavior
{
    /**
     * @var mixed The name of the attribute to store the creation user.  Set to null to not
     * use a identifier for the creation attribute.  Defaults to 'created_by'
     */
    public $createAttribute = 'created_by';

    /**
     * @var mixed The name of the attribute to store the modification user.  Set to null to not
     * use a identifier for the update attribute.  Defaults to 'modified_by'
     */
    public $updateAttribute = 'modified_by';

    /**
     * @var bool Whether to set the update attribute to the creation user upon creation.
     * Otherwise it will be left alone.  Defaults to true.
     */
    public $setUpdateOnCreate = true;

    /**
     * Responds to {@link CActiveRecord::onBeforeSave} event.
     * Sets the values of the creation or modified attributes as configured
     *
     * @param CModelEvent $event event parameter
     */
    public function beforeSave(CModelEvent $event)
    {
        if ($this->getOwner()->getIsNewRecord() && ($this->createAttribute !== null)) {
            $this->getOwner()->{$this->createAttribute} = Yii::app()->user->id;
        }
        if (( ! $this->getOwner()->getIsNewRecord() || $this->setUpdateOnCreate)
            && ($this->updateAttribute !== null)) {
            $this->getOwner()->{$this->updateAttribute} = Yii::app()->user->id;
        }
    }

}