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
    protected function getSubmenuTitle()
    {
        return Yii::t('main', 'admin.menu.participants');
    }
    
    /**
     * {@inheritdoc}
     */
    protected function getSubmenuItems()
    {
        $sections = array('participcats', 'participants');
        $items = array();
        foreach ($sections as $section)
        {
            $items['admin/' . $section] = Yii::t('main', 'admin.section.' . $section);
        }
        
        return $items;
    }
    
    /**
     * {@inheritdoc}
     */
    public function actionAdmin()
    {
        if (!$this->_catid)
            throw new BadMethodCallException('Identifier of the category wasn\'t set!');
        
        $r = Yii::app()->request;
        $modelClass = $this->getModelClass();
        $attributes = $r->getQuery($modelClass);
        
        if (!$attributes && ($catid = $r->getQuery('catid')))
        {
            $_GET[$modelClass] = array('catid' => $catid);
        }
        
        parent::actionAdmin();
    }

    /**
     * {@inheritdoc}
     */
    public function actionCreate($returnUrl = null)
    {
        $r = Yii::app()->request;
        if (!$r->getPost('returnUrl') && ($catid = Yii::app()->request->getQuery('catid')))
        {
            $returnUrl = $this->createUrl('admin', array('catid' => $catid));
        }
        
        parent::actionCreate($returnUrl);
    }

    /**
     * {@inheritdoc}
     */
    public function actionEdit($returnUrl = null)
    {
        $r = Yii::app()->request;
        if (!$r->getPost('returnUrl') && ($catid = Yii::app()->request->getQuery('catid')))
        {
            $returnUrl = $this->createUrl('admin', array('catid' => $catid));
        }
        
        parent::actionEdit($returnUrl);
	}

}
