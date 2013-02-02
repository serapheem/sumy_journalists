<?php
/**
 * Contains base controller of the site
 */

/**
 * Controller Abstract Class
 */
abstract class AbstractController extends Controller
{
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
            array('allow', // allow all users to perform 'index' and 'show' actions
                'actions' => array('index', 'show'),
                'users' => array('*'),
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
     * 
     * @return CActiveRecord|null
     */
    protected function loadModel($create = true, $scenario = 'insert')
    {
        $modelClass = $this->getModelClass();
        if (!class_exists($modelClass))
            return null;

        if ($this->_model === null)
        {
            if ($id = (int) Yii::app()->request->getParam('id', 0))
            {
                $this->_model = $modelClass::model()->findbyPk($id);
                if ($this->_model)
                    $this->_model->setScenario('update');
            }
            elseif ($create) 
            {
                $this->_model = new $modelClass($scenario);
            }

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
     * Displays all items
     */
    public function actionIndex()
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
     * Shows the selected item
     * 
     * @param string|null $returnUrl The URL address to redirect after successful item update
     */
    public function actionShow($returnUrl = null)
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

}
