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
	 * @see CController::filters
	 */
	public function accessRules()
	{
		$rules = parent::accessRules();
		
		return array_merge_recursive( array( 
			array( 'allow',  // allow authenticated users to perform 'view' actions
				'actions' => array( 'admin', 'delete', 'update', 'index', 'view' ),
				'expression' => '$user->id == 1',
			),
			/*array('allow', // allow admin role to perform 'admin', 'update' and 'delete' actions
				'actions'=>array('admin','delete','update'),
				'roles'=>array(User::ROLE_ADMIN),
			),*/
			array( 'deny',  // deny all users
				'users' => array( '*' ),
			) 
		), $rules );
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
	 * Deletes the selected items
	 * @return void
	 */
	public function actionDelete() 
	{ 
		$model_class = ucfirst( $this->getId() );
		$success = true;
		
		if ( Yii::app()->request->isPostRequest )
		{
			if ( isset( $_POST['items'] ) && ($total = count( $_POST['items'] )) ) 
			{
				$items = ( array ) $_POST['items'];
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
		}
		else {
			Yii::app()->user->setFlash( 'error', Yii::t( $this->getId(), 'DELETE_BAD_REQUEST_TYPE_ERROR' ) );
		}

		if ( !isset( $_GET['ajax'] ) )
			Yii::app()->getRequest()->redirect( '/admin/' . $this->getId() );
	}
	
	/**
	 * Updates the selected item
	 * @return void
	 */
	public function actionUpdate()
	{
		if ( Yii::app()->request->isPostRequest )
		{
			// we only allow update via POST request
			$model = $this->loadModel( false );
			if ( $model )
			{
				$model_class = ucfirst( $this->getId() );
				if ( isset( $_POST[$model_class] ) ) 
				{
					$model->attributes = $_POST[$model_class];
					if ( $model->validate() && $model->save() ) 
					{
						Yii::app()->user->setFlash( 'success', Yii::t( $this->getId(), 'ITEM_UPDATED' ) );
					}
					else {
						Yii::app()->user->setFlash( 'error', Yii::t( $this->getId(), 'There were some errors during update item.' ) );
					}
				}
				else {
					Yii::app()->user->setFlash( 'error', Yii::t( $this->getId(), 'The new attributes for item were not set.' ) );
				}
			}
			else {
				Yii::app()->user->setFlash( 'error', Yii::t( $this->getId(), 'Can\'t find item with such identifier.' ) );
			}
		}
		else {
			// Yii::app()->user->setFlash( 'error', Yii::t( $this->getId(), 'Can\'t update item using such type of request.' ) );
			throw new CHttpException( 400, 'Invalid request. Please do not repeat this request again.' );
		}
		
		// TODO : need to use returnUrl parameter of user object
		if ( !isset( $_GET['ajax'] ) )
			Yii::app()->getRequest()->redirect( '/admin/' . $this->getId() );
	}
	
}
