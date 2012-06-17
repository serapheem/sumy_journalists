<?php

/**
 * Users Controller Class
 */
class UsersController extends AdminAbstractController 
{
	/**
	 * Name of default model
	 * 
	 * @access public
	 * @var string
	 */
	public $model = 'Users';
	
	/**
	 * Displays the list of items
	 * 
	 * @access public
	 * 
	 * @return void
	 */
	public function actionIndex( ) 
	{
		$model = $this->model;
		$rows = $model::model( )
			->findAll( );
		
		$this->render( 'list', array( 'rows' => $rows ) );
		return true;
	}
	
	/**
	 * Displays add form and save changes
	 * 
	 * @access public
	 * 
	 * @return void
	 */
	public function actionAdd() 
	{
		$model_name = strtolower( $this->model );
		
		$model = $this->loadModel();
		$form = new CForm('admin.views.users.form', $model);

		$this->breadcrumbs = array(
			Yii::t( $model_name, 'SECTION_NAME' ) => '/admin/' . $model_name,
			Yii::t( $model_name, 'NEW_ITEM' )
		);
		
		if ( isset( $_POST[$this->model] ) ) 
		{
			$model->attributes = $_POST[$this->model];
			
			if ( $model->password )
			{
				$model->password = sha1( $model->email . $model->password );
			}
			if ( $model->password2 )
			{
				$model->password2 = sha1( $model->email . $model->password2 );
			}

			if ( $model->validate( ) && $model->save( ) ) 
			{
				Yii::app( )->user->setFlash( 'info', Yii::t( $model_name, 'ITEM_ADDED' ) );
				
				if ( !empty( $_POST['save'] ) || ( empty( $_POST['save'] ) && empty( $_POST['apply'] ) ) )
				{
					Yii::app( )
						->getRequest( )
						->redirect( '/admin/' . $model_name );
				}
				else {
					Yii::app( )
						->getRequest( )
						->redirect( "/admin/{$model_name}/edit?id=" . $model->id );
				}
			}
		}

		$this->renderText($form);
		return true;
	}
	
	/**
	 * Displays edit form and save changes
	 * 
	 * @access public
	 * 
	 * @return void
	 */
	public function actionEdit() 
	{
		$model_name = strtolower( $this->model );
		
		$model = $this->loadModel();
		$old_model = clone $model;
		$form = new CForm('admin.views.users.edit_form', $model);

		$this->breadcrumbs = array(
			Yii::t( $model_name, 'SECTION_NAME' ) => '/admin/' . $model_name,
			$model->username
		);
		
		if ( isset( $_POST[$this->model] ) ) 
		{
			$model->attributes = $_POST[$this->model];
			
			if ( empty( $model->password ) || empty( $model->password2 ) )
			{
				$model->password = $old_model->password;
				$model->password2 = $old_model->password;
			}
			else {
				$model->password = sha1( $model->email . $model->password );
				$model->password2 = sha1( $model->email . $model->password2 );
			}
			$model->username = $old_model->username;
			
			if ( $model->validate( ) && $model->save( ) ) 
			{
				Yii::app()->user->setFlash( 'info', Yii::t( $model_name, 'ITEM_UPDATED' ) );
				
				if ( !empty( $_POST['save'] ) || ( empty( $_POST['save'] ) && empty( $_POST['apply'] ) ) )
				{
					Yii::app( )
						->getRequest( )
						->redirect( '/admin/' . $model_name );
				}
				else {
					Yii::app( )
						->getRequest( )
						->redirect( "/admin/{$model_name}/edit?id=" . $model->id );
				}
			}
		}

		$this->renderText($form);
		return true;
	}

}