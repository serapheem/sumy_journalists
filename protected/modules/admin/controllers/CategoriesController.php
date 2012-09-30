<?php
/**
 * Contains controller class of categories
 */

/**
 * Categories Controller Class
 */
class CategoriesController extends AdminAbstractController
{
    /**
     * {@inheritdoc}
     */
    public function accessRules()
    {
        //$rules = parent::accessRules();

        return array(
            array('allow', // allow authenticated users to perform 'view' actions
                'actions' => array('admin', 'create', 'edit', 'validate', 'delete'),
                'expression' => '$user->id == 1',
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
     * Manages all items
     */
    public function actionAdmin()
    {
        $model_class = ucfirst($this->getId());
        if (!class_exists($model_class))
        {
            $this->_model = null;
            $dataProvider = null;
        }
        else
        {
            $this->_model = new $model_class('search');
            $this->_model->unsetAttributes(); // clear any default values
            if ($attributes = Yii::app()->request->getQuery($model_class))
                $this->_model->attributes = $attributes;

            $dataProvider = $this->_model->search($this->_itemsPerPage);
        }

        $this->render('list', array(
            'sectionId' => $this->getId(),
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
            $attributes = $request->getPost(ucfirst($sectionId));
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
                Yii::app()->user->setFlash('error', Yii::t($this->getId(), 'admin.form.message.error.noAttrs'));
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
            $config = require( Yii::getPathOfAlias("admin.views.{$sectionId}.form") . '.php' );
            $form = new CForm($config, $model);

            $this->_title = isset($model->id) 
                ? $model->title 
                : Yii::t($sectionId, 'admin.form.title.newItem');

            $this->breadcrumbs = array(
                Yii::t($sectionId, 'admin.sectionName') => $this->createUrl($this->defaultAction),
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
            $attributes = $request->getPost(ucfirst($sectionId));
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
                $config = require( Yii::getPathOfAlias("admin.views.{$sectionId}.form") . '.php' );
                $form = new CForm($config, $model);

                $this->_title = $model->title;
                $this->breadcrumbs = array(
                    Yii::t($sectionId, 'admin.sectionName') => $this->createUrl($this->defaultAction),
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

        $sectionId = $this->getId();
        $model = $this->loadModel();
        $attributes = $request->getPost(ucfirst($sectionId));
        if ($attributes)
            $model->attributes = $attributes;

        if ($request->getParam('ajax') == ($sectionId . '-form'))
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
        $items = (array) $request->getPost('items', array());
        if ($total = count($items))
        {
            $modelClass = ucfirst($sectionId);
            $error = 0;
            foreach ($items as $key => $id)
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

}
