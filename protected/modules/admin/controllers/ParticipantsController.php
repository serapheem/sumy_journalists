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
     * {@inheritdoc}
     */
    public function actionAdmin()
    {
        if (!$this->_catid)
            throw new BadMethodCallException('Identifier of the category wasn\'t set!');
        
//        $className = $this->getModelClass();
//        if (empty($_GET[$className]['catid']))
//        {
//            $result = array($this->_catid);
//            $items = Categories::model()
//                ->findAllByAttributes(array('parent_id' => $this->_catid));
//            foreach ($items as $item)
//            {
//                $result[] = $item->primaryKey;
//            }
//            $_GET[$className]['catid'] = $result;
//        }
        
        parent::actionAdmin();
    }
    
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
