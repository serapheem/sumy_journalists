<?php
/**
 * Contains controller for poll items
 */

/**
 * Poll Items Controller Class
 */
class PollitemsController extends AdminAbstractController
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

    /**
     * {@inheritdoc}
     */
    public function actionAdmin()
    {
        $r = Yii::app()->request;
        $modelClass = $this->getModelClass();
        $attributes = $r->getQuery($modelClass);
        
        if (!$attributes && ($catid = $r->getQuery('catid')))
        {
            $_GET[$modelClass] = array('poll_id' => $catid);
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