<?php
/**
 * Contains base controller of admin module
 */

/**
 * Admin Controller Abstract Class
 */
abstract class AdminAbstractController extends CController
{
    /**
     * {@inheritdoc}
     */
    public $defaultAction = 'admin';

    /**
     * {@inheritdoc}
     */
    public $layout = 'admin.views.layouts.main';
    
    /**
     * Name of the model class
     * @var string
     */
    protected $_modelClass;
    
    /**
     * The object of model
     * @var object
     */
    protected $_model = null;

    /**
     * @var string The title of the page
     */
    protected $_title = null;

    /**
     * Breadcrumbs to current page
     * @var array
     */
    public $breadcrumbs = array();

    /**
     * Count items per page
     * @var integer
     */
    protected $_itemsPerPage = 20;

    /**
     * Updates the last visited date before initialize application
     * @return void
     */
    public function init()
    {
        Users::model()->updateByPk(Yii::app()->user->getId(), 
            array('lasttime' => date('Y-m-d H:i:s'))
        );

        parent::init();
    }

    /**
     * {@inheritdoc}
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * {@inheritdoc}
     */
    public function accessRules()
    {
        return array(
            array('allow', // allow authenticated users to perform 'view' actions
                'actions' => array('admin', 'delete', 'update', 'index', 'view'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }
    
    /**
     * Gets name of the model class
     * 
     * @return string
     */
    protected function getModelClass()
    {
        if (!$this->_modelClass)
        {
            $this->_modelClass = ucfirst($this->getId());
        }
        return $this->_modelClass;
    }
    
    /**
     * Returns the model object or null if there is no model with such identifier
     *
     * @param boolean 	$create 	Created new model object or return null
     * @param string 	$scenario 	The new scenario for model
     * @return CActiveRecord|null
     */
    protected function loadModel($create = true, $scenario = '')
    {
        $modelClass = $this->getModelClass();
        if (!class_exists($modelClass))
            return null;

        if ($this->_model === null)
        {
            if ($id = (int) Yii::app()->request->getParam('id', 0))
                $this->_model = $modelClass::model()->findbyPk($id);
            else
                $this->_model = new $modelClass();

            if ($scenario && $this->_model)
                $this->_model->setScenario($scenario);

            // TODO : Check for correct work with other controllers
            /*
              if ( $this->_model === null )
              {
              Yii::app()->user->setFlash( 'info', Yii::t( $this->getId(), 'NEW_ITEM' ) );
              Yii::app()->getRequest()->redirect( '/admin' );
              } */
        }

        return $this->_model;
    }

    /**
     * Manages all items
     */
    public function actionAdmin()
    {
        $modelClass = $this->getModelClass();
        if (!class_exists($modelClass))
        {
            $this->_model = null;
            $dataProvider = null;
        }
        else
        {
            $this->_model = new $modelClass('search');
            $this->_model->unsetAttributes(); // clear any default values
            if ($attributes = Yii::app()->request->getQuery($modelClass))
                $this->_model->attributes = $attributes;

            $dataProvider = $this->_model->search($this->_itemsPerPage);
        }

        $this->render('list', array(
            'sectionId' => $this->getId(),
            'modelClass' => $modelClass,
            'itemPerPage' => $this->_itemsPerPage,
            'model' => $this->_model,
            'dataProvider' => $dataProvider
        ));
    }

    /**
     * Creates the new item
     */
    public function actionCreate()
    {
        $sectionId = $this->getId();
        $request = Yii::app()->request;
        $model = $this->loadModel();

        if (!$model)
        {
            Yii::app()->user->setFlash('error', Yii::t($sectionId, 'admin.form.message.error.createItem'));
            $this->redirect($this->createUrl($this->defaultAction));
        }

        $canRedirect = false;
        if (($apply = $request->getParam('apply', false)) || $request->getParam('save', false))
        {
            $attributes = $request->getPost($this->getModelClass());
            if ($attributes)
            {
                $model->attributes = $attributes;
                if ($model->save())
                {
                    Yii::app()->user->setFlash('success', Yii::t($sectionId, 'admin.form.message.success.createItem'));
                    $canRedirect = true;
                }
            }
            else
                Yii::app()->user->setFlash('error', Yii::t($sectionId, 'admin.form.message.error.noAttrs'));
        }

        if ($canRedirect)
        {
            // TODO : need to use returnUrl parameter of user object
            if ($apply)
                $this->redirect(array('edit', 'id' => $model->id));
            else
                $this->redirect($this->createUrl($this->defaultAction));
        }
        else
        {
            $newItem = true;
            if (!file_exists($createForm = Yii::getPathOfAlias("admin.views.{$sectionId}.form") . '.php'))
            {
                $createForm = Yii::getPathOfAlias('admin.views.' . $this->getId() . '.form') . '.php';
            }
            $config = require($createForm);
            $form = new CForm($config, $model);

            $this->_title = isset($model->id) 
                ? $model->title 
                : Yii::t($sectionId, 'admin.form.title.newItem');

            $this->breadcrumbs = array(
                Yii::t('main', 'admin.section.' . $sectionId) => $this->createUrl($this->defaultAction),
                $this->_title
            );
            
            $this->renderText($form);
        }
    }

    /**
     * Updates the selected item
     */
    public function actionEdit()
    {
        $sectionId = $this->getId();
        $request = Yii::app()->request;
        $model = $this->loadModel(false);

        if (!$model)
        {
            Yii::app()->user->setFlash('error', Yii::t($sectionId, 'admin.form.message.error.noItem'));
            $this->redirect($this->createUrl($this->defaultAction));
        }

        $canRedirect = false;
        if (($apply = $request->getParam('apply', false)) || $request->getParam('save', false) || $request->isAjaxRequest)
        {
            $attributes = $request->getPost($this->getModelClass());
            if ($attributes)
            {
                $model->attributes = $attributes;
                if ($model->save())
                {
                    Yii::app()->user->setFlash('success', Yii::t($sectionId, 'admin.form.message.success.editItem'));
                    $canRedirect = true;
                }
            }
            else
                Yii::app()->user->setFlash('error', Yii::t($sectionId, 'admin.form.message.error.noAttrs'));
        }

        if ($request->isAjaxRequest)
        {
            if ($model->hasErrors())
                // FIXME : create better message for this
                Yii::app()->user->setFlash('error', Yii::t($sectionId, 'There were some errors during update.'));
        }
        else
        {
            if ($canRedirect && !$apply)
            {
                // TODO : need to use returnUrl parameter of user object
                $this->redirect($this->createUrl($this->defaultAction));
            }
            else
            {
                $newItem = false;
                if (!file_exists($editForm = Yii::getPathOfAlias("admin.views.{$sectionId}.form") . '.php'))
                {
                    $editForm = Yii::getPathOfAlias('admin.views.' . $this->getId() . '.form') . '.php';
                }
                $config = require($editForm);
                $form = new CForm($config, $model);

                $this->_title = $model->title;
                $this->breadcrumbs = array(
                    Yii::t('main', 'admin.section.' . $sectionId) => $this->createUrl($this->defaultAction),
                    $this->_title
                );

                $this->renderText($form);
            }
        }
    }

    /**
     * Performs Ajax validation during create and edit item
     */
    public function actionValidate()
    {
        $request = Yii::app()->getRequest();
        // we only allow validate via Ajax request and POST data
        if (!$request->getIsAjaxRequest() || !$request->getIsPostRequest())
        {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }

        $model = $this->loadModel();
        $attributes = $request->getPost($this->getModelClass());
        if ($attributes)
            $model->attributes = $attributes;

        if ($request->getParam('ajax') == ($this->getId() . '-form'))
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Deletes the selected items
     */
    public function actionDelete()
    {
        $request = Yii::app()->getRequest();
        // we only allow update via POST request
        if (!$request->getIsPostRequest())
        {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }

        $sectionId = $this->getId();
        $ids = (array) $request->getPost('ids', array());
        if ($total = count($ids))
        {
            $modelClass = $this->getModelClass();
            $error = 0;
            foreach ($ids as $id)
            {
                if (!$modelClass::model()->deleteByPk($id))
                {
                    $error++;
                }
            }

            if ($error != $total)
                Yii::app()->user->setFlash('success', Yii::t($sectionId, 
                    '1#admin.list.message.success.deleteItem|n>1#admin.list.message.success.deleteItems', $total)
                );
            if ($error)
            {
                if ($error != $total)
                    Yii::app()->user->setFlash('error', Yii::t($sectionId, 'admin.list.message.error.deleteSomeItems'));
                else 
                    Yii::app()->user->setFlash('error', Yii::t($sectionId, 'admin.list.message.error.deleteItems'));
            }
        }
        else
        {
            Yii::app()->user->setFlash('warning', Yii::t($sectionId, 'admin.list.message.warning.deleteNoItems'));
        }

        // TODO : need to use returnUrl parameter of user object
        if (!$request->getIsAjaxRequest())
            Yii::app()->getRequest()->redirect($this->createUrl($this->defaultAction));
    }

    /**
     * Saves order of items
     */
    public function actionSaveOrder()
    {
        $model = $this->model;
        $model_name = strtolower($model);

        if (isset($_POST['order']) && count($_POST['order']))
        {
            $order = (array) $_POST['order'];

            foreach ($order AS $key => $value)
            {
                $record = $model::model()->findByPk($key);

                if ($record->ordering != $value)
                {
                    $record->ordering = $value;
                    $record->save();
                }
            }
        }

        $this->reorder();

        Yii::app()->user->setFlash('info', Yii::t('main', 'NEW_ORDER_SAVED'));
        Yii::app()->getRequest()->redirect('/admin/' . $model_name);
    }

    /**
     * Changes order of selected element
     */
    public function actionChangeOrder()
    {
        $id = $_POST['id'];
        $type = $_POST['type'];
        $model = $this->model;
        $model_name = strtolower($model);

        if (!empty($type) && $this->validateID($id))
        {
            $record = $model::model()->findByPk($id);

            if ($type == 'up' && ($record->ordering > 1))
            {
                $record->ordering -= 2;
                $record->save();
            }
            elseif ($type == 'down')
            {
                $record->ordering += 2;
                $record->save();
            }
        }

        $this->reorder();

        Yii::app()->user->setFlash('info', Yii::t($model_name, 'ITEM_ORDER_CHANGED'));
        Yii::app()->getRequest()->redirect('/admin/' . $model_name);
    }

    /**
     * Reorders all elements in the table
     */
    protected function reorder()
    {
        $model = $this->model;
        $rows = $model::model()->ordering()->findAll();

        if (!empty($rows))
        {
            for ($i = 0, $n = count($rows); $i < $n; $i++)
            {
                if ($rows[$i]->ordering != $i + 1)
                {
                    $rows[$i]->ordering = $i + 1;
                    $rows[$i]->save();
                }
            }
        }
    }
    
    /**
     * Returns list of main menu items
     * 
     * @return array
     */
    protected function getMainMenuItems()
    {
        return array(
            '/admin' => array('label' => Yii::t('main', 'admin.menu.settings')),
            '/admin/news' => array('label' => Yii::t('main', 'admin.menu.materials')),
            '/admin/participants' => array('label' => Yii::t('main', 'admin.menu.participants')),
            '/admin/poll' => array('label' => Yii::t('main', 'admin.menu.poll')),
            '/admin/statistics' => array('label' => Yii::t('main', 'admin.menu.statistics')),
            '/admin/users' => array('label' => Yii::t('main', 'admin.menu.users')),
            '/admin/default/logout' => array(
                'label' => Yii::t('main', 'admin.menu.logOut'), 
                'htmlOptions' => array('class' => 'right')
            ),
            '/' => array(
                'label' => Yii::t('main', 'admin.menu.viewSite'), 
                'htmlOptions' => array('class' => 'right'), 
                'linkHtmlOptions' => array('rel' => 'external')
            ),
        );
    }

    /**
     * Renders the submenu of current page
     */
    protected function renderSubmenu()
    {
        $this->renderPartial('/html/submenu', array(
            'sectionTitle' => Yii::t('main', 'admin.menu.materials'),
            'items' => $this->getSubmenuItems(),
            'current' => 'admin/' . $this->getId()
        ));
    }
    
    /**
     * Returns list of submenu items
     * 
     * @return array
     */
    protected function getSubmenuItems()
    {
        $sections = array(
            'news', 'knowour', 'citystyle', 'tyca', 
            'pages', 'categories', 'items', 'frontpage'
        );
        $items = array();
        foreach ($sections as $section)
        {
            $items['admin/' . $section] = Yii::t('main', 'admin.section.' . $section);
        }
        
        return $items;
    }

}
