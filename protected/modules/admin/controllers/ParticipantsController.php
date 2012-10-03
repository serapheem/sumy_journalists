<?php
/**
 * Contains controller class of Participants
 */

/**
 * Participants Controller Class
 */
class ParticipantsController extends AdminCustomItemsController
{
    /**
     * {@inheritdoc}
     */
    protected $_catid = 4;
    
    /**
     * Returns list of submenu items
     * 
     * @return array
     */
    protected function getSubmenuItems()
    {
        $sections = array('participants', 'participcats');
        $items = array();
        foreach ($sections as $section)
        {
            $items['admin/' . $section] = Yii::t('main', 'admin.section.' . $section);
        }
        
        return $items;
    }

}
