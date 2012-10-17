<?php
/**
 * FeaturedBehavior class file.
 */

/**
 * FeaturedBehavior will implements possibility to add items to front page.
 */
class FeaturedBehavior extends CActiveRecordBehavior
{
    /**
     * @var string The name of the attribute to store the featured status. 
     * Defaults to 'featured'
     */
    public $featuredAttribute = 'featured';
    
    /**
     * @var bool The default value for featured status. Defaults to 'true'
     */
    public $defaultValue = 1;
    
    /**
     * Responds to {@link CModel::onAfterConstruct} event.
     * Sets default attribute value to model instance
     * 
     * @param CEvent $event event parameter
     */
    public function afterConstruct(CEvent $event)
    {
        if (empty($this->featuredAttribute))
            throw new BadMethodCallException('Name of featured attribute was\'nt set!');
        if (is_null($this->defaultValue))
            throw new BadMethodCallException('Default value for "' . $this->featuredAttribute 
                . '" attribute was\'nt set!');
        
        if ($this->getOwner()->getScenario() != 'search')
        {
            $this->getOwner()->{$this->featuredAttribute} = $this->defaultValue;
        }
    }

    /**
     * Responds to {@link CActiveRecord::onAfterSave} event.
     * Adds item to the front page or removes it
     * 
     * @param CEvent $event event parameter
     */
    public function afterSave(CEvent $event)
    {
        $owner = $this->getOwner();
        $sectionId = strtolower(get_class($owner));
        $attrs = array(
            'section' => $sectionId,
            'item_id' => $owner->primaryKey
        );
        if ($owner->{$this->featuredAttribute})
        {
            $record = Frontpage::model()->findByAttributes($attrs);
            if (!$record)
            {
                $m = Frontpage::model();
                $m->isNewRecord = true;
                $m->attributes = $attrs;
                if (!$m->save())
                {
                    Yii::app()->user->setFlash('error', 
                        Yii::t($sectionId, 'admin.list.message.error.featureItem'));
                }
            }
        }
        else {
            $record = Frontpage::model()->findByAttributes($attrs);
            if ($record && !$record->delete())
            {
                Yii::app()->user->setFlash('error', 
                    Yii::t($sectionId, 'admin.list.message.error.unfeatureItem'));
            }
        }
    }

    /**
     * Responds to {@link CActiveRecord::onAfterDelete} event.
     * Removes item from the front page
     * 
     * @param CEvent $event event parameter
     */
    public function afterDelete(CEvent $event)
    {
        $owner = $this->getOwner();
        $sectionId = strtolower(get_class($owner));
        $record = Frontpage::model()->findByAttributes(array(
            'section' => $sectionId,
            'item_id' => $owner->primaryKey
        ));
        if ($record && !$record->delete())
        {
            Yii::app()->user->setFlash('error', 
                Yii::t($sectionId, 'admin.list.message.error.unfeatureItem'));
        }
    }

    /**
     * Responds to {@link CActiveRecord::onAfterFind} event.
     * Sets int value instead of object as attribute value
     * 
     * @param CEvent $event event parameter
     */
    public function afterFind(CEvent $event)
    {
        $this->getOwner()->featured = (int) !empty($this->getOwner()->featured);
    }

}