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
    public function accessRules()
    {
        return array(
            array('allow', // allow authenticated users to perform 'view' actions
                'actions' => array('admin', 'create', 'edit', 'validate', 'delete'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            )
        );
    }
    
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
    public function actionCreate()
    {
        if (!$this->_parentId)
            throw new BadMethodCallException('Identifier of the parent category wasn\'t set!');
        
        $className = $this->getModelClass();
        $_POST[$className]['parent_id'] = $this->_parentId;
        
        parent::actionCreate();
    }
    
    /**
     * {@inheritdoc}
     */
    public function actionEdit()
    {
        if (!$this->_parentId)
            throw new BadMethodCallException('Identifier of the parent category wasn\'t set!');
        
        $className = $this->getModelClass();
        $_POST[$className]['parent_id'] = $this->_parentId;
        
        parent::actionEdit();
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
