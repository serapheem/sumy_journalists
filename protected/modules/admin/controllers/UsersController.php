<?php

/**
 * Users Controller Class
 */
class UsersController extends AdminController 
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
		$model = $this->loadModel();
		$form = new CForm('admin.views.users.form', $model);

		$this->breadcrumbs = array(
			'Користувачі' => '/admin/users',
			'Новий користувач'
		);
		
		if ( isset( $_POST['Users'] ) ) 
		{
			$model->attributes = $_POST['Users'];
			
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
				Yii::app()->user->setFlash('info', 'Користувач доданий.');
				
				if ( !empty( $_POST['save'] ) || ( empty( $_POST['save'] ) && empty( $_POST['apply'] ) ) )
				{
					Yii::app( )
						->getRequest( )
						->redirect( '/admin/users' );
				}
				else {
					Yii::app( )
						->getRequest( )
						->redirect( '/admin/users/edit?id=' . $model->id );
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
		$model = $this->loadModel();
		$old_model = clone $model;
		$form = new CForm('admin.views.users.edit_form', $model);

		$this->breadcrumbs = array(
			'Користувачі' => '/admin/users',
			$model->username
		);
		
		if ( isset( $_POST['Users'] ) ) 
		{
			$model->attributes = $_POST['Users'];
			
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
				Yii::app()->user->setFlash('info', 'Дані користувача успішно змінені.');
				
				if ( !empty( $_POST['save'] ) || ( empty( $_POST['save'] ) && empty( $_POST['apply'] ) ) )
				{
					Yii::app( )
						->getRequest( )
						->redirect( '/admin/users' );
				}
				else {
					Yii::app( )
						->getRequest( )
						->redirect( '/admin/users/edit?id=' . $model->id );
				}
			}
		}

		$this->renderText($form);
		return true;
	}

}