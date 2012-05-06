<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

/**
 * Admin Controller Class
 */
class AdminController extends CController
{
	/**
	 * Shows the main layout file
	 *
	 * @access public
	 * @var string
	 */
	public $layout = 'admin.views.layouts.main';

	/**
	 * The object of model
	 *
	 * @access public
	 * @var object
	 */
	public $_model = null;

	/**
	 * The name of model
	 *
	 * @access public
	 * @var string
	 */
	public $model = null;

	/**
	 * Breadcrumbs to current page
	 *
	 * @access public
	 * @var array
	 */
	public $breadcrumbs = array( );

	/**
	 * Updates the last visited date before initialize application
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function init( )
	{
		Users::model( )
			->updateByPk( 
				Yii::app( )->user->getId( ), 
				array( 'lasttime' => date( 'Y-m-d H:i:s' ) ) 
			);

		parent::init( );
	}

	/**
	 * Loads the model object
	 *
	 * @access public
	 * @param boolean $create
	 *
	 * @return object
	 */
	public function loadModel( $create = true )
	{
		if ( $this->model === null )
		{
			return null;
		}
		
		if ( $this->_model === null )
		{
			$modelClass = $this->model;
			if ( isset( $_REQUEST['id'] ) && ( $_REQUEST['id'] > 0 ) )
			{
				$model = new $modelClass( );
				$this->_model = $model->findbyPk( $_REQUEST['id'] );
			}
			elseif ( $create )
			{
				$this->_model = new $modelClass( );
			}

			if ( $this->_model === null )
			{
				$model_name = strtolower( $this->model );
				
				Yii::app( )->user->setFlash( 'info', Yii::t( $model_name, 'NEW_ITEM' ) );
				Yii::app( )
					->getRequest( )
					->redirect( '/admin' );
			}
		}

		return $this->_model;
	}

	/**
	 * Validates the identifier
	 * if not valid redirect to admin index page
	 *
	 * @access protected
	 * @param integer $id
	 * @param boolean $redirect
	 *
	 * @return boolean, or void if no valid
	 */
	protected function validateID( $id, $redirect = true )
	{
		if ( !is_numeric( $id ) || ($id == 0) )
		{
			if ( $redirect )
			{
				Yii::app( )
					->getRequest( )
					->redirect( '/admin' );
			}
			return false;
		}

		return true;
	}
	
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
			->ordering( )
			->findAll( );
		
		$this->render( 'list', array( 'rows' => $rows ) );
		return true;
	}
	
	/**
	 * Displays edit form and save changes
	 * 
	 * @access public
	 * 
	 * @return void
	 */
	public function actionEdit( ) 
	{
		$model_name = strtolower( $this->model );
		
		$model = $this->loadModel( );
		$form = new CForm( "admin.views.{$model_name}.form", $model );
		
		if ( is_null( $model->id ) ) 
		{
			$title = Yii::t( $model_name, 'NEW_ITEM' );
		} 
		else {
			$title = $model->title;
		}
		$this->breadcrumbs = array(
			Yii::t( $model_name, 'SECTION_NAME' ) => '/admin/' . $model_name,
			$title
		);
		
		if ( isset( $_POST[$this->model] ) ) 
		{
			$model->attributes = $_POST[$this->model];
			
			if ( $model->validate( ) && $model->save( ) ) 
			{
				if ( isset( $_REQUEST['id'] ) && $_REQUEST['id'] ) 
				{
					$msg = Yii::t( $model_name, 'ITEM_UPDATED' );
				} 
				else {
					$msg = Yii::t( $model_name, 'ITEM_ADDED' );
				}
				Yii::app( )->user->setFlash( 'info', $msg );
				
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
		
		$this->renderText( $form );
		return true;
	}
	
	/**
	 * Deletes the selected items
	 * 
	 * @access public
	 * 
	 * @return void
	 */
	public function actionDelete( ) 
	{
		$model = $this->model;
		$model_name = strtolower( $model );
		
		if ( isset( $_POST['items'] ) && count( $_POST['items'] ) ) 
		{
			$items = ( array ) $_POST['items'];
			foreach ( $items AS $id )
			{
				$model::model( )->deleteByPk( $id );
			}

			Yii::app( )->user->setFlash( 'info', Yii::t( $model_name, '1#ITEM_DELETED|n>1#ITEMS_DELETED', count( $_POST['items'] ) ) );
		}

		Yii::app( )
			->getRequest( )
			->redirect( '/admin/' . $model_name );
		return true;
	}

	/**
	 * Saves order of items
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function actionSaveOrder( )
	{
		$model = $this->model;
		$model_name = strtolower( $model );
		
		if ( isset( $_POST['order'] ) && count( $_POST['order'] ) )
		{
			$order = ( array ) $_POST['order'];
			
			foreach ( $order AS $key => $value )
			{
				$record = $model::model( )->findByPk( $key );

				if ( $record->ordering != $value )
				{
					$record->ordering = $value;
					$record->save( );
				}
			}
		}

		$this->reorder( );

		Yii::app( )->user->setFlash( 'info', Yii::t( 'main', 'NEW_ORDER_SAVED' ) );
		Yii::app( )
			->getRequest( )
			->redirect( '/admin/' . $model_name );
		
		return true;
	}
	
	/**
	 * Changes order of selected element
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function actionChangeOrder( )
	{
		$id = $_POST['id'];
		$type = $_POST['type'];
		$model = $this->model;
		$model_name = strtolower( $model );

		if ( !empty( $type ) && $this->validateID( $id ) )
		{
			$record = $model::model( )
				->findByPk( $id );

			if ( $type == 'up' && ($record->ordering > 1) )
			{
				$record->ordering -= 2;
				$record->save( );
			}
			elseif ( $type == 'down' )
			{
				$record->ordering += 2;
				$record->save( );
			}
		}

		$this->reorder( );
		
		Yii::app( )->user->setFlash( 'info', Yii::t( $model_name, 'ITEM_ORDER_CHANGED' ) );
		Yii::app( )
			->getRequest( )
			->redirect( '/admin/' . $model_name );
		return true;
	}

	/**
	 * Reorders all elements in the table
	 * 
	 * @access protected
	 * 
	 * @return void
	 */
	protected function reorder( )
	{
		$model = $this->model;
		$rows = $model::model( )
			->ordering( )
			->findAll( );

		if ( !empty( $rows ) )
		{
			for ( $i = 0, $n = count( $rows ); $i < $n; $i++ )
			{
				if ( $rows[$i]->ordering != $i + 1 )
				{
					$rows[$i]->ordering = $i + 1;
					$rows[$i]->save( );
				}
			}
		}

		return true;
	}

}
