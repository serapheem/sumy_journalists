<?php
/**
 * File for controller of categories
 */

/**
 * Categories Controller Class
 */
class CategoriesController extends AdminAbstractController 
{
	/**
	 * (non-PHPDoc)
	 * @see CController::filters
	 */
	public function accessRules()
	{
		//$rules = parent::accessRules();
		
		return array( 
			array( 'allow',  // allow authenticated users to perform 'view' actions
				'actions' => array( 'admin', 'create', 'update', 'validate', 'delete' ),
				'expression' => '$user->id == 1',
			),
			/*array('allow', // allow admin role to perform 'admin', 'update' and 'delete' actions
				'actions'=>array('admin','delete','update'),
				'roles'=>array(User::ROLE_ADMIN),
			),*/
			array( 'deny',  // deny all users
				'users' => array( '*' ),
			) 
		);
	}
	
	/**
	 * Manages all items
	 * @return void
	 */
	public function actionAdmin()
	{
		$model_class = ucfirst( $this->getId() );
		if ( !class_exists( $model_class ) )
		{
			$this->_model = null;
			$dataProvider = null;
		}
		else {
			$this->_model = new $model_class( 'search' );
			$this->_model->unsetAttributes(); // clear any default values
			if( $attributes = Yii::app()->request->getQuery($model_class) )
				$this->_model->attributes = $attributes;
			
			$dataProvider = $this->_model->search( $this->_itemsPerPage );
		}
		
		$this->render( 'list', array( 
			'section_id' => $this->getId(),
			'itemPerPage' => $this->_itemsPerPage, 
			'model' => $this->_model, 
			'dataProvider' => $dataProvider 
		) );
	}
	
	/**
	 * Creates the new item
	 * @return void
	 */
	public function actionCreate()
	{
		$section_id = $this->getId();
		$request = Yii::app()->request;
		$model = $this->loadModel();
		
		if ( !$model )
		{
			Yii::app()->user->setFlash( 'error', Yii::t( $this->getId(), "Can't create new item." ) );
			$this->redirect( array( '/admin/' . $this->getId() ) );
		}
		
		$redirect = false;
		if ( ($apply = $request->getParam( 'apply', false )) || $request->getParam( 'save', false ) )
		{
			$model_class = ucfirst( $this->getId() );
			if ( $attributes = $request->getPost($model_class) ) 
			{
				$model->attributes = $attributes;
				if ( $model->save() )
				{ 
					Yii::app()->user->setFlash( 'success', Yii::t( $this->getId(), 'ITEM_UPDATED' ) );
					$redirect = true;
				}
			}
			else
				Yii::app()->user->setFlash( 'error', Yii::t( $this->getId(), 'The attributes for item were not set.' ) );
		}
		
		if ( $redirect )
		{
			// TODO : need to use returnUrl parameter of user object
			if ( $apply )
				$this->redirect( array( '/admin/' . $this->getId() . '/update?id=' . $model->id ) );
			else 
				$this->redirect( array( '/admin/' . $this->getId() ) );
		}
		else {
			$config = require( Yii::getPathOfAlias( "admin.views.{$section_id}.form" ) .'.php' );
			$form = new CForm( $config, $model );
			
			if ( isset( $model->id ) ) 
				$this->_title = $model->title;
			else 
				$this->_title = Yii::t( $section_id, 'NEW_ITEM' );
			
			$this->breadcrumbs = array(
				Yii::t( $section_id, 'SECTION_NAME' ) => '/admin/' . $section_id,
				$this->_title
			);
			
			$this->renderText( $form );
		}
	}
	
	/**
	 * Updates the selected item
	 * @return void
	 */
	public function actionUpdate()
	{
		$section_id = $this->getId();
		$request = Yii::app()->request;
		$model = $this->loadModel( false );
		
		if ( !$model )
		{
			// FIXME : need to throw an exception
			Yii::app()->user->setFlash( 'error', Yii::t( $this->getId(), "Can\'t find item with such identifier." ) );
			$this->redirect( array( '/admin/' . $this->getId() ) );
		}
		
		$success = false;
		if ( ($apply = $request->getParam( 'apply', false )) || $request->getParam( 'save', false ) || $request->isAjaxRequest )
		{
			$model_class = ucfirst( $this->getId() );
			if ( $attributes = $request->getPost($model_class) ) 
			{
				$model->attributes = $attributes;
				if ( $success = $model->save() )
				{ 
					Yii::app()->user->setFlash( 'success', Yii::t( $this->getId(), 'ITEM_UPDATED' ) );
				}
			}
			else
				Yii::app()->user->setFlash( 'error', Yii::t( $this->getId(), 'The new attributes for item were not set.' ) );
		}
		
		if ( $request->isAjaxRequest )
		{
			if ( $model->hasErrors() )
				// FIXME : create better message for this
				Yii::app()->user->setFlash( 'error', Yii::t( $this->getId(), 'There were some errors during update.' ) );
		}
		else {
			if ( $success && !$apply )
			{
				// TODO : need to use returnUrl parameter of user object
				$this->redirect( array( '/admin/' . $this->getId() ) );
			}
			else {
				$config = require( Yii::getPathOfAlias( "admin.views.{$section_id}.form" ) .'.php' );
				$form = new CForm( $config, $model );
				
				$this->_title = $model->title;
				$this->breadcrumbs = array(
					Yii::t( $section_id, 'SECTION_NAME' ) => '/admin/' . $section_id,
					$this->_title
				);
				
				$this->renderText( $form );
			}
		}
	}

	/**
	 * Performs Ajax validation
	 * @return void
	 */
	public function actionValidate()
	{
		$request = Yii::app()->getRequest();
		// we only allow validate via Ajax request and POST data
		if ( !$request->getIsAjaxRequest() || !$request->getIsPostRequest() )
		{
			throw new CHttpException( 400, 'Invalid request. Please do not repeat this request again.' );
		}
		
		$model = $this->loadModel();
		$model_class = ucfirst( $this->getId() );
		if ( $attributes = $request->getPost($model_class) ) 
			$model->attributes = $attributes;
		
		if( $request->getParam('ajax') == ($this->getId() . '-form') )
		{
			echo CActiveForm::validate( $model );
			Yii::app()->end();
		}
	}

	/**
	 * Deletes the selected items
	 * @return void
	 */
	public function actionDelete() 
	{
		$request = Yii::app()->getRequest();
		// we only allow update via POST request
		if ( !$request->getIsPostRequest() )
		{
			throw new CHttpException( 400, 'Invalid request. Please do not repeat this request again.' );
			//Yii::app()->user->setFlash( 'error', Yii::t( $this->getId(), 'DELETE_BAD_REQUEST_TYPE_ERROR' ) );
		}
				 
		$model_class = ucfirst( $this->getId() );
		$success = true;
		
		if ( $total = count( $request->getPost('items') ) ) 
		{
			$items = ( array ) $request->getPost('items');
			foreach ( $items as $key => $id )
			{
				if ( !$model_class::model()->deleteByPk( $id ) )
				{
					$total--;
					$success = false;
				}
			}

			if ( $total )
				Yii::app()->user->setFlash( 'success', Yii::t( $this->getId(), '1#ITEM_DELETED|n>1#ITEMS_DELETED', $total ) );
			if ( !$success )
				Yii::app()->user->setFlash( 'error', Yii::t( $this->getId(), 'DELETE_ITEMS_PARTIAL_ERROR' ) );
		}
		else {
			Yii::app()->user->setFlash( 'warning', Yii::t( $this->getId(), 'DELETE_NO_ITEMS_ERROR' ) );
		}
		
		// TODO : need to use returnUrl parameter of user object
		if ( !$request->getIsAjaxRequest() )
			Yii::app()->getRequest()->redirect( '/admin/' . $this->getId() );
	}
	
}
