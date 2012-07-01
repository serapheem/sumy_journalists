<?php

/**
 * Default Controller Class
 */
class DefaultController extends AdminAbstractController 
{
	/**
	 * (non-PHPDoc)
	 * @see CController::filters
	 */
	public function accessRules()
	{
		return array( 
			array( 'allow',
				'actions' => array( 'login' ),
				'users' => array( '*' ),
			),
			array( 'allow',
				'actions' => array( 'logout' ),
				'users' => array( '@' ),
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
	 * Displays and saves change in site configuration
	 * 
	 * @access public
	 * 
	 * @return void
	 */
	public function actionIndex( ) 
	{
		$settingsFile = Yii::getPathOfAlias( 'application.config.settings' ) . '.php';
		$settings = require $settingsFile;

		if ( isset( $_POST['settings'] ) && is_array( $_POST['settings'] ) ) 
		{
			foreach ( $_POST['settings'] AS $key => $value ) 
			{
				if ( strpos( $_POST['settings'][$key], "\n" ) )
				{
					$_POST['settings'][$key] = nl2br($value);
				}
			}
			
			$settings = $_POST['settings'];
			file_put_contents( $settingsFile, '<?php return ' . var_export($settings, true) . ';', LOCK_EX );

			Yii::app( )->user->setFlash( 'info', Yii::t( 'main', 'SETTINGS_CHANGED' ) );
		}

		foreach ( $settings AS $key => $value ) 
		{
			if ( strpos( $settings[$key], "\n" ) )
			{
				$settings[$key] = strip_tags( $value );
			}
		}

		$this->render('index', $settings);
		return true;
	}

	/**
	 * Displays error page
	 * 
	 * @access public
	 * 
	 * @return void
	 */
	public function actionError( ) 
	{
		$error = Yii::app( )->errorHandler->error;
		if ( $error )
		{
			$this->render( 'error', $error );
		}
		return true;
	}
	
	/**
	 * Conducts the login user
	 * adn displays the login page
	 * 
	 * @access public
	 * 
	 * @return void
	 */
	public function actionLogin( ) 
	{
		$model = new Login( );

		if ( isset( $_POST['Login'] ) ) 
		{
			$model->attributes = $_POST['Login'];

			if ( $model->validate( ) && $model->login( ) )
			{
				$this->redirect('/admin');
			}
		}

		$this->renderPartial( 'login', array( 'model' => $model ) );
		return true;
	}
	
	/**
	 * Conducts the logout user
	 * 
	 * @access public
	 * 
	 * @return void
	 */
	public function actionLogout( ) 
	{
		Yii::app( )->user->logout( );
		$this->redirect( Yii::app( )->homeUrl . 'admin' );
		return true;
	}

}