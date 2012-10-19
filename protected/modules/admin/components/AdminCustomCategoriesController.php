<?php
/**
 * Contains controller class of custom categories for admin
 */

/**
 * Custom Categories Controller Class
 */
abstract class AdminCustomCategoriesController extends AdminAbstractController
{
    /**
     * {@inheritdoc}
     */
    protected $_modelClass = 'Categories';
    
    /**
     * Identifier of the parent category
     * @var int
     */
    protected $_parentId;
    
    
    /**
     * {@inheritdoc}
     */
    public function actionAdmin()
    {
        if (!$this->_parentId)
            throw new BadMethodCallException('Identifier of the parent category wasn\'t set!');
        
        $className = $this->getModelClass();
        $_GET[$className]['parent_id'] = $this->_parentId;
        
        parent::actionAdmin();
    }
    
    /**
     * {@inheritdoc}
     */
    public function actionCreate($returnUrl = null)
    {
        if (!$this->_parentId)
            throw new BadMethodCallException('Identifier of the parent category wasn\'t set!');
        
        $className = $this->getModelClass();
        $_POST[$className]['parent_id'] = $this->_parentId;
        
        parent::actionCreate($returnUrl);
    }
    
    /**
     * {@inheritdoc}
     */
    public function actionEdit($returnUrl = null)
    {
        if (!$this->_parentId)
            throw new BadMethodCallException('Identifier of the parent category wasn\'t set!');
        
        $className = $this->getModelClass();
        $_POST[$className]['parent_id'] = $this->_parentId;
        
        parent::actionEdit($returnUrl);
    }
    
    /**
     * {@inheritdoc}
     */
    public function actionValidate()
    {
        if (!$this->_parentId)
            throw new BadMethodCallException('Identifier of the parent category wasn\'t set!');
        
        $className = $this->getModelClass();
        $_POST[$className]['parent_id'] = $this->_parentId;
        
        parent::actionValidate();
    }

}
