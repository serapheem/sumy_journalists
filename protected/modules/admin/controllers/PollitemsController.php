<?php
/**
 * Contains controller for poll items
 */

/**
 * Poll Items Controller Class
 */
class PollitemsController extends AdminAbstractController
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
            array('deny', // deny all users
                'users' => array('*'),
            )
        );
    }
    
    /**
     * {@inheritdoc}
     */
    protected function getSubmenuItems()
    {
        $sections = array('pollcats', 'pollitems');
        $items = array();
        foreach ($sections as $section)
        {
            $items['admin/' . $section] = Yii::t('main', 'admin.section.' . $section);
        }
        
        return $items;
    }

    /**
     * {@inheritdoc}
     */
    public function actionAdmin()
    {
        $request = Yii::app()->request;
        $modelClass = $this->getModelClass();
        $attributes = $request->getQuery($modelClass);
        
        if (!$attributes && ($catid = $request->getQuery('catid')))
        {
            $_GET[$modelClass] = array('poll_id' => $catid);
        }
        
        parent::actionAdmin();
    }
	
	/**
	 * Displays edit form and save changes of item
	 * 
	 * @access public
	 * 
	 * @return void
	 */
	public function actionItemEdit( ) 
	{
		if ( isset( $_REQUEST['poll_id'] ) )
		{
			$poll_id = $_REQUEST['poll_id'];
		}
		else {
			$poll_id = 0;
		}
		$this->validateID( $poll_id );
		$model = $this->model;
		$poll = $model::model( )
			->findByPk( $poll_id );
		
		$parent_model_name = strtolower( $this->model );
		$this->model = 'PollItems';
		$model_name = strtolower( $this->model );
		
		$model = $this->loadModel( );
		$form = new CForm( 'admin.views.poll.item_form', $model );

		if ( is_null( $model->id ) ) 
		{
			$title = Yii::t( $model_name, 'NEW_ITEM' );
		} 
		else {
			$title = $model->title;
		}
		$this->breadcrumbs = array(
			Yii::t( $parent_model_name, 'SECTION_NAME' ) => '/admin/' . $parent_model_name,
			Yii::t( $model_name, 'SECTION_NAME' ) . ': ' . $poll->title => "/admin/{$parent_model_name}/items?id=" . $poll->id,
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
						->redirect( "/admin/{$parent_model_name}/items?id=" . $poll->id );
				}
				else {
					Yii::app( )
						->getRequest( )
						->redirect( "/admin/{$parent_model_name}/itemedit?poll_id=" . $poll->id . '&id=' . $model->id );
				}
			}
		}

		$this->renderText($form);
		return true;
	}
	
	/**
	 * Deletes the selected items of poll
	 * 
	 * @access public
	 * 
	 * @return void
	 */
	public function actionItemDelete( ) 
	{
		if ( isset( $_REQUEST['poll_id'] ) )
		{
			$poll_id = $_REQUEST['poll_id'];
		}
		else {
			$poll_id = 0;
		}
		$this->validateID($poll_id);
		
		$parent_model_name = strtolower( $this->model );
		$model = 'PollItems';
		$model_name = strtolower( $model );
		
		if ( isset( $_POST['items'] ) && count( $_POST['items'] ) ) 
		{
			foreach ( $_POST['items'] AS $id )
			{
				$model::model( )
					->deleteByPk( $id );
			}

			Yii::app( )->user->setFlash( 'info', Yii::t( $model_name, '1#ITEM_DELETED|n>1#ITEMS_DELETED', count( $_POST['items'] ) ) );
		}

		Yii::app( )
			->getRequest( )
			->redirect( "/admin/{$parent_model_name}/items?id=" . $poll_id );
		return true;
	}
	
	/**
	 * Saves order of items
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function actionSaveItemOrder( ) 
	{
		if ( isset( $_REQUEST['poll_id'] ) )
		{
			$poll_id = $_REQUEST['poll_id'];
		}
		else {
			$poll_id = 0;
		}
		$order = $_POST['order'];
		
		$parent_model_name = strtolower( $this->model );
		$model = 'PollItems';
		
		if ( !empty( $order ) && is_array( $order ) )
		{
			foreach ( $order AS $key => $value )
			{
				$record = $model::model( )
					->findByPk( $key );

				if ( $record->ordering != $value )
				{
					$record->ordering = $value;
					$record->save( );
				}
			}
		}

		if ( $this->validateID( $poll_id ) ) 
		{
			$this->model = $model;
			$this->setPageState( 'poll_id', $poll_id );
			$this->reorderItems( );
		}
		Yii::app( )->user->setFlash( 'info', Yii::t( 'main', 'NEW_ORDER_SAVED' ) );
		Yii::app( )
			->getRequest( )
			->redirect( "/admin/{$parent_model_name}/items?id=" . $poll_id ); 
		
		return true;
	}
	
	/**
	 * Changes order of selected item
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function actionChangeItemOrder() 
	{
		$id = $_POST['id'];
		$type = $_POST['type'];
		$poll_id = $_POST['poll_id'];
		
		$parent_model_name = strtolower( $this->model );
		$model = 'PollItems';
		$model_name = strtolower( $model );

		if ( !empty( $type ) && $this->validateID( $id ) ) 
		{
			$record = $model::model()
				->findByPk( $id );
			
			if ( ( $type == 'up' ) && ( $record->ordering > 1 ) ) 
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
		
		if ( $this->validateID( $poll_id ) ) 
		{
			$this->model = $model;
			$this->setPageState( 'poll_id', $poll_id );
			$this->reorderItems( );
		}
		Yii::app( )->user->setFlash( 'info', Yii::t( $model_name, 'ITEM_ORDER_CHANGED' ) );
		Yii::app( )
			->getRequest( )
			->redirect( "/admin/{$parent_model_name}/items?id=" . $poll_id ); 
	}
	
	/**
	 * Reorders items current poll
	 * 
	 * @access protected
	 * 
	 * @return void
	 */
	protected function reorderItems( ) 
	{
		$model = $this->model;
		$poll_id = $this->getPageState( 'poll_id', 0 );
		
		if ( $this->validateID( $poll_id, false ) ) 
		{
			$rows = $model::model( )
				->ordering( )
				->findAll( 'poll_id=:poll_id', array( 'poll_id' => $poll_id ) );
		} 
		else {
			$rows = $model::model( )
				->ordering( )
				->findAll( );
		}

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