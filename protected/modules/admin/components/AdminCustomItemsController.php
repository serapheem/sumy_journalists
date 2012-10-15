<?php
/**
 * Contains controller class of custom items for admin
 */

/**
 * Custom Items Controller Class
 */
abstract class AdminCustomItemsController extends AdminAbstractController
{
    /**
     * {@inheritdoc}
     */
    protected $_modelClass = 'Items';
    
    /**
     * Identifier of the current category
     * @var int
     */
    protected $_catid;
    
    
    /**
     * {@inheritdoc}
     */
    public function actionAdmin()
    {
        if (!$this->_catid)
            throw new BadMethodCallException('Identifier of the category wasn\'t set!');
        
        $className = $this->getModelClass();
        if (empty($_GET[$className]['catid']))
            $_GET[$className]['catid'] = $this->_catid;
        
        parent::actionAdmin();
    }
    
    /**
     * {@inheritdoc}
     */
    public function actionCreate($returnUrl = null)
    {
        if (!$this->_catid)
            throw new BadMethodCallException('Identifier of the category wasn\'t set!');
        
        $className = $this->getModelClass();
        if (empty($_POST[$className]['catid']))
            $_POST[$className]['catid'] = $this->_catid;
        
        parent::actionCreate($returnUrl);
    }
    
    /**
     * {@inheritdoc}
     */
    public function actionEdit($returnUrl = null)
    {
        if (!$this->_catid)
            throw new BadMethodCallException('Identifier of the category wasn\'t set!');
        
        $className = $this->getModelClass();
        if (empty($_POST[$className]['catid']))
            $_POST[$className]['catid'] = $this->_catid;
        
        parent::actionEdit($returnUrl);
    }
    
    /**
     * {@inheritdoc}
     */
    public function actionValidate()
    {
        if (!$this->_catid)
            throw new BadMethodCallException('Identifier of the category wasn\'t set!');
        
        $className = $this->getModelClass();
        if (empty($_POST[$className]['catid']))
            $_POST[$className]['catid'] = $this->_catid;
        
        parent::actionValidate();
    }

}
