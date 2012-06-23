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
		
		return array_merge( array( 
			array( 'allow',  // allow authenticated users to perform 'view' actions
				'actions' => array( 'admin', 'edit', 'create', 'update', 'delete' ),
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
			if( $attributes = Yii::app()->getRequest()->getQuery($model_class) )
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
	
	/**
	 * Updates the selected item
	 * @return void
	 */
	public function actionUpdate()
	{
		$request = Yii::app()->getRequest();
		// we only allow update via POST request
		if ( !$request->getIsPostRequest() )
		{
			throw new CHttpException( 400, 'Invalid request. Please do not repeat this request again.' );
			//Yii::app()->user->setFlash( 'error', Yii::t( $this->getId(), 'DELETE_BAD_REQUEST_TYPE_ERROR' ) );
		}
		
		$model = $this->loadModel( false );
		if ( $model )
		{
			$model_class = ucfirst( $this->getId() );
			if ( $attributes = $request->getPost($model_class) ) 
			{
				$model->attributes = $attributes;
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
		
		// TODO : need to use returnUrl parameter of user object
		if ( !$request->getIsAjaxRequest() )
			Yii::app()->getRequest()->redirect( '/admin/' . $this->getId() );
	}
	
}
