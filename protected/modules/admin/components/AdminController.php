<?php
/**
 * Contains class for base Controller of Admin module
 *
 * @author      Serhiy Hlushko <serhiy.hlushko@gmail.com>
 * @copyright   Copyright 2013 Hlushko inc.
 * @company     Hlushko inc.
 */

/**
 * Describes common functionality for controllers of Admin module
 */
abstract class AdminController extends CController
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
     * @var array Breadcrumbs to current page
     */
    public $breadcrumbs = array();

    /**
     * @var string The title of the page
     */
    protected $_title = null;

    /**
     * @var int Count items per page
     */
    protected $_itemsPerPage = 20;

    /**
     * @var string Name of the model class
     */
    protected $_modelClass;

    /**
     * @var object The object of model
     */
    protected $_model = null;

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
                'actions' => array('admin', 'create', 'edit', 'delete', 'validate'),
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
        if ( ! $this->_modelClass) {
            $this->_modelClass = ucfirst($this->getId());
        }

        return $this->_modelClass;
    }

    /**
     * Returns the model object or null if there is no model with such identifier
     * @param bool 	 $create   Created new model object or return null
     * @param string $scenario The scenario for new model
     *
     * @return CModel|null
     */
    protected function loadModel($create = true, $scenario = 'insert')
    {
        $modelClass = $this->getModelClass();
        if ( ! class_exists($modelClass)) {
            return null;
        }

        if ($this->_model === null) {
            if ($id = (int) Yii::app()->input->get('id', 0)) {
                $this->_model = $modelClass::model()->findbyPk($id);
                if ($this->_model) {
                    $this->_model->setScenario($scenario);
                }
            } elseif ($create) {
                $this->_model = new $modelClass($scenario);
            }

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
            $this->_model = $this->loadModel(true, 'search');
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
     * 
     * @param string|null $returnUrl The URL address to redirect after successful item creation
     */
    public function actionCreate($returnUrl = null)
    {
        $sectionId = $this->getId();
        $request = Yii::app()->request;
        $returnUrl = $returnUrl ?: $request->getPost('returnUrl') ?: $this->createUrl($this->defaultAction);
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
                $this->redirect(array('edit', 'id' => $model->primaryKey));
            else 
                $this->redirect($returnUrl);
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

            $this->_title = Yii::t($sectionId, 'admin.form.title.newItem');

            $this->breadcrumbs = array(
                Yii::t('main', 'admin.section.' . $sectionId) => $returnUrl,
                $this->_title
            );
            
            $this->renderText($form);
        }
    }

    /**
     * Updates the selected item
     * 
     * @param string|null $returnUrl The URL address to redirect after successful item update
     */
    public function actionEdit($returnUrl = null)
    {
        $sectionId = $this->getId();
        $request = Yii::app()->request;
        $returnUrl = $returnUrl ?: $request->getPost('returnUrl') ?: $this->createUrl($this->defaultAction);
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
                $this->redirect($returnUrl);
            }
            else
            { 
                if ($canRedirect)
                    $model = $model->findByPk($model->primaryKey);
                
                $newItem = false;
                $editForm = Yii::getPathOfAlias('admin.views.' . $sectionId . '.form') . '.php';
                $config = require($editForm);
                $form = new CForm($config, $model);

                if (isset($model->title))
                {
                    $this->_title = $model->title;
                }
                else { 
                    $this->_title = $model->name;
                }
                $this->breadcrumbs = array(
                    Yii::t('main', 'admin.section.' . $sectionId) => $returnUrl,
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
                $r = $modelClass::model()->findByPk($id);
                if (!$r || !$r->delete())
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

        if (!$request->getIsAjaxRequest())
        {
            $returnUrl = $request->getPost('returnUrl') ?: $this->createUrl($this->defaultAction);
            Yii::app()->getRequest()->redirect($returnUrl);
        }
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
            '/admin' => array('label' => Yii::t('main', 'admin.menu.default')),
            '/admin/news' => array('label' => Yii::t('main', 'admin.menu.materials')),
            '/admin/participcats' => array('label' => Yii::t('main', 'admin.menu.participants')),
            '/admin/pollcats' => array('label' => Yii::t('main', 'admin.menu.poll')),
            '/admin/statistics' => array('label' => Yii::t('main', 'admin.menu.statistics')),
            '/admin/users' => array('label' => Yii::t('main', 'admin.menu.users')),
            '/admin/default/logout' => array(
                'label' => Yii::t('main', 'admin.menu.logOut') . ' (' . Yii::app()->user->email . ')', 
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
            'sectionTitle' => $this->getSubmenuTitle(),
            'items' => $this->getSubmenuItems(),
            'current' => 'admin/' . $this->getId()
        ));
    }
    
    /**
     * Returns title of submenu
     * 
     * @return string
     */
    protected function getSubmenuTitle()
    {
        return Yii::t('main', 'admin.menu.materials');
    }
    
    /**
     * Returns list of submenu items
     * 
     * @return array
     */
    protected function getSubmenuItems()
    {
        $sections = array('news', 'knowour', 'citystyle', 'tyca', 'pages');
        if (Yii::app()->user->id == 1)
        {
            $sections = array_merge($sections, array('categories', 'items'));
        }
        $sections = array_merge($sections, array('frontpage'));
        $items = array();
        foreach ($sections as $section)
        {
            $items['admin/' . $section] = Yii::t('main', 'admin.section.' . $section);
        }
        
        return $items;
    }

}
