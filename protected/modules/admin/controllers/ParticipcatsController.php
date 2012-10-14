<?php
/**
 * Contains controller class of Participants Categories
 */

/**
 * Participants Categories Controller Class
 */
class ParticipcatsController extends AdminCustomCategoriesController
{
    /**
     * {@inheritdoc}
     */
    protected $_parentId = 4;
    
    /**
     * {@inheritdoc}
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
