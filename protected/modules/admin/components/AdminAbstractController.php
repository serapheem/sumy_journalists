<?php
/**
 * File for base controller of admin module
 */

/**
 * Admin Controller Abstract Class
 */
abstract class AdminAbstractController extends CController
{
	/**
	 * @see CController
	 */
	public $defaultAction = 'admin';
	
	/**
	 * Shows the main layout file
	 * @var string
	 */
	public $layout = 'admin.views.layouts.main';

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
	protected $_itemsPerPage = 25;

	/**
	 * Updates the last visited date before initialize application
	 * @return void
	 */
	public function init()
	{
		Users::model()->updateByPk( Yii::app()->user->getId(), 
			array( 'lasttime' => date( 'Y-m-d H:i:s' ) ) 
		);

		parent::init();
	}

	/**
	 * @see CController::filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * @see CController::filters
	 */
	public function accessRules()
	{
		return array(
			array( 'allow',  // allow authenticated users to perform 'view' actions
				'actions' => array( 'admin', 'delete', 'update', 'index', 'view' ),
				'users' => array( '@' ),
			),
			array( 'deny',  // deny all users
				'users' => array( '*' ),
			),
		);
	}
	
	/**
	 * Returns the model object or null if there is no model with such identifier
	 *
	 * @param boolean 	$create 	Created new model object or return null
	 * @param string 	$scenario 	The new scenario for model
	 * @return CActiveRecord|null
	 */
	protected function loadModel( $create = true, $scenario = '' )
	{
		$model_class = ucfirst( $this->getId() );
		if ( !class_exists( $model_class ) )
			return null;

		if ( $this->_model === null )
		{
			if ( $id = Yii::app()->request->getParam('id', 0) )
				$this->_model = $model_class::model()->findbyPk( $id );
			else 
				$this->_model = new $model_class();
			
			if ( $scenario && $this->_model )
				$this->_model->setScenario( $scenario );

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
	 * Validates the identifier
	 * if not valid redirect to admin index page
	 *
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
				Yii::app()->getRequest()->redirect( '/admin' );
			}
			return false;
		}

		return true;
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
			if( isset( $_GET[$model_class] ) )
				$this->_model->attributes = $_GET[$model_class];
			
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
	 * Displays the list of items
	 * @return void
	 */
	public function actionIndex() 
	{
		$model = $this->model;
		$rows = $model::model()->ordering()->findAll();
		
		$this->render( 'list', array( 'rows' => $rows ) );
	}
	
	/**
	 * Displays edit form and save changes
	 * @return void
	 */
	public function actionEdit() 
	{
		$model_name = strtolower( $this->model );
		
		$model = $this->loadModel();
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
			
			if ( $model->validate() && $model->save() ) 
			{
				if ( isset( $_REQUEST['id'] ) && $_REQUEST['id'] ) 
				{
					$msg = Yii::t( $model_name, 'ITEM_UPDATED' );
				} 
				else {
					$msg = Yii::t( $model_name, 'ITEM_ADDED' );
				}
				Yii::app()->user->setFlash( 'info', $msg );
				
				if ( !empty( $_POST['save'] ) || ( empty( $_POST['save'] ) && empty( $_POST['apply'] ) ) )
				{
					Yii::app()
						->getRequest()
						->redirect( '/admin/' . $model_name );
				}
				else {
					Yii::app()
						->getRequest()
						->redirect( "/admin/{$model_name}/edit?id=" . $model->id );
				}
			}
		}
		
		$this->renderText( $form );
	}
	
	/**
	 * Deletes the selected items
	 * @return void
	 */
	public function actionDelete() 
	{
		$model = $this->model;
		$model_name = strtolower( $model );
		
		if ( isset( $_POST['items'] ) && count( $_POST['items'] ) ) 
		{
			$items = ( array ) $_POST['items'];
			foreach ( $items AS $id )
			{
				$model::model()->deleteByPk( $id );
			}

			Yii::app()->user->setFlash( 'info', Yii::t( $model_name, '1#ITEM_DELETED|n>1#ITEMS_DELETED', count( $_POST['items'] ) ) );
		}

		Yii::app()->getRequest()->redirect( '/admin/' . $model_name );
	}

	/**
	 * Saves order of items
	 * @return void
	 */
	public function actionSaveOrder()
	{
		$model = $this->model;
		$model_name = strtolower( $model );
		
		if ( isset( $_POST['order'] ) && count( $_POST['order'] ) )
		{
			$order = ( array ) $_POST['order'];
			
			foreach ( $order AS $key => $value )
			{
				$record = $model::model()->findByPk( $key );

				if ( $record->ordering != $value )
				{
					$record->ordering = $value;
					$record->save();
				}
			}
		}

		$this->reorder();

		Yii::app()->user->setFlash( 'info', Yii::t( 'main', 'NEW_ORDER_SAVED' ) );
		Yii::app()->getRequest()->redirect( '/admin/' . $model_name );
	}
	
	/**
	 * Changes order of selected element
	 * @return void
	 */
	public function actionChangeOrder()
	{
		$id = $_POST['id'];
		$type = $_POST['type'];
		$model = $this->model;
		$model_name = strtolower( $model );

		if ( !empty( $type ) && $this->validateID( $id ) )
		{
			$record = $model::model()->findByPk( $id );

			if ( $type == 'up' && ($record->ordering > 1) )
			{
				$record->ordering -= 2;
				$record->save();
			}
			elseif ( $type == 'down' )
			{
				$record->ordering += 2;
				$record->save();
			}
		}

		$this->reorder();
		
		Yii::app()->user->setFlash( 'info', Yii::t( $model_name, 'ITEM_ORDER_CHANGED' ) );
		Yii::app()->getRequest()->redirect( '/admin/' . $model_name );
	}

	/**
	 * Reorders all elements in the table
	 * @return void
	 */
	protected function reorder()
	{
		$model = $this->model;
		$rows = $model::model()->ordering()->findAll();

		if ( !empty( $rows ) )
		{
			for ( $i = 0, $n = count( $rows ); $i < $n; $i++ )
			{
				if ( $rows[$i]->ordering != $i + 1 )
				{
					$rows[$i]->ordering = $i + 1;
					$rows[$i]->save();
				}
			}
		}
	}
	
	/**
	 * Renders the submenu of current page
	 * @return void
	 */
	protected function renderSubMenu()
	{
		$id = $this->getId();
		
		$page_title = Yii::t( 'main', 'MATERIALS' );

		$menu_items = array( 
			'news' => Yii::t( 'news', 'SECTION_NAME' ), 
			'citystyle' => Yii::t( 'citystyle', 'SECTION_NAME' ), 
			'knowour' => Yii::t( 'knowour', 'SECTION_NAME' ), 
			'tyca' => Yii::t( 'tyca', 'SECTION_NAME' ), 
			'participants' => Yii::t( 'participants', 'SECTION_NAME' ),
			'frontpage' => Yii::t( 'frontpage', 'SECTION_NAME' ),
			'categories' => Yii::t( 'categories', 'SECTION_NAME' )
		);
		
		$this->renderPartial( '/html/submenu', array( 
			'items' => $menu_items, 
			'current' => $id
		) ); 
	}
	
}
