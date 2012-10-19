<?php
/**
 * Contains controller for poll categories
 */

/**
 * Poll Categories Controller Class
 */
class PollcatsController extends AdminAbstractController
{
    /**
     * Returns title of submenu
     * 
     * @return string
     */
    protected function getSubmenuTitle()
    {
        return Yii::t('main', 'admin.menu.poll');
    }
    
    /**
     * {@inheritdoc}
     */
    protected function getSubmenuItems()
    {
        $sections = array('pollcats', 'pollitems');
        $items = array();
        foreach ($sections as $section)
        {
            $items['admin/' . $section] = Yii::t('main', 'admin.section.' . $section);
        }
        
        return $items;
    }
	
}