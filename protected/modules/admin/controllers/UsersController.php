<?php
/**
 * Contains controller class of users
 */

/**
 * Users Controller Class
 */
class UsersController extends AdminAbstractController 
{
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
	 * Displays add form and save changes
	 * 
	 * @return void
	 */
	public function actionCreate1() 
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
	public function actionEdit1() 
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