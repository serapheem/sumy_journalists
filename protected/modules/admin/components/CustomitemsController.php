<?php
/**
 * Contains controller class of custom items
 */

/**
 * Custom Items Controller Class
 */
abstract class CustomitemsController extends AdminAbstractController
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
    public function accessRules()
    {
        return array(
            array('allow', // allow authenticated users to perform 'view' actions
                'actions' => array('admin', 'create', 'edit', 'validate', 'delete'),
                'users' => array('@'),
            ),
            /* array('allow', // allow admin role to perform 'admin', 'update' and 'delete' actions
              'actions'=>array('admin','delete','update'),
              'roles'=>array(User::ROLE_ADMIN),
              ), */
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
        if (!$this->_catid)
            throw new BadMethodCallException('Identifier of the category wasn\'t set!');
        
        $className = $this->getModelClass();
        $_GET[$className]['catid'] = $this->_catid;
        
        parent::actionAdmin();
    }
    
    /**
     * {@inheritdoc}
     */
    public function actionCreate()
    {
        if (!$this->_catid)
            throw new BadMethodCallException('Identifier of the category wasn\'t set!');
        
        $className = $this->getModelClass();
        $_POST[$className]['catid'] = $this->_catid;
        
        parent::actionCreate();
    }
    
    /**
     * {@inheritdoc}
     */
    public function actionEdit()
    {
        if (!$this->_catid)
            throw new BadMethodCallException('Identifier of the category wasn\'t set!');
        
        $className = $this->getModelClass();
        $_POST[$className]['catid'] = $this->_catid;
        
        parent::actionEdit();
    }
    
    /**
     * {@inheritdoc}
     */
    public function actionValidate()
    {
        if (!$this->_catid)
            throw new BadMethodCallException('Identifier of the category wasn\'t set!');
        
        $className = $this->getModelClass();
        $_POST[$className]['catid'] = $this->_catid;
        
        parent::actionValidate();
    }

}
