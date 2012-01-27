<?php

/**
 * Poll Controller Class
 */
class PollController extends AdminController 
{
    /**
	 * Name of default model
	 * 
	 * @access public
	 * @var string
	 */
	public $model = 'Poll';
    
    /**
	 * Displays the list of poll
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
	 * Displays edit form and save changes
	 * 
	 * @access public
	 * 
	 * @return void
	 */
    public function actionEdit( ) 
    {
    	$model = $this->loadModel( );
        $form = new CForm( 'admin.views.poll.form', $model );

        if ( is_null( $model->id ) ) 
        {
            $title = 'Нове голосування';
        } 
        else {
            $title = $model->name;
        }
        $this->breadcrumbs = array(
            'Голосування' => '/admin/poll',
            $title
        );
        
        if ( isset( $_POST['Poll'] ) ) 
        {
            $model->attributes = $_POST['Poll'];
            
            if ( $model->validate( ) && $model->save( ) ) 
            {
                if ( isset( $_POST['id'] ) && $_POST['id'] ) 
                {
                    $msg = 'Голосування успішно оновлене.';
                } 
                else {
                    $msg = 'Голосування успішно додане.';
                }
                Yii::app( )->user->setFlash( 'info', $msg );
				
				if ( !empty( $_POST['save'] ) || ( empty( $_POST['save'] ) && empty( $_POST['apply'] ) ) )
				{
					Yii::app( )
						->getRequest( )
                		->redirect( '/admin/poll' );
				}
				else {
					Yii::app( )
						->getRequest( )
                		->redirect( '/admin/poll/edit?id=' . $model->id );
				}
            }
        }

        $this->renderText($form);
		return true;
    }
    
	/**
	 * Displays the items list of poll
	 * 
	 * @access public
	 * 
	 * @return void
	 */
    public function actionItems( ) 
    {
    	// Check the identifier
    	if ( !isset( $_POST['id'] ) && isset( $_GET['id'] ) && $this->validateID( $_GET['id'], false ) )
		{
			$_POST['id'] = $_GET['id'];
		}
        $model = $this->loadModel();
        
        $rows = PollItems::model()
        	->ordering()
        	->findAllByAttributes( array( 'poll_id' => $model->id ) );
        
        $this->render('items', array(
        	'rows' => $rows, 
        	'poll' => $model
		));
		return true;
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
        
        $this->model = 'PollItems';
        $model = $this->loadModel( );
        $form = new CForm( 'admin.views.poll.item_form', $model );

        if ( is_null( $model->id ) ) 
        {
            $title = 'Новий варіант';
        } 
        else {
            $title = $model->name;
        }
        $this->breadcrumbs = array(
            'Голосування' => '/admin/poll',
            'Варіанти голосування: ' . $poll->name => '/admin/poll/items?id=' . $poll->id,
            $title
        );
        
        if ( isset( $_POST['PollItems'] ) ) 
        {
            $model->attributes = $_POST['PollItems'];
            
            if ( $model->validate( ) && $model->save( ) ) 
            {
                if ( isset( $_REQUEST['id'] ) && $_REQUEST['id'] ) 
                {
                    $msg = 'Варіант голосування успішно оновлений.';
                } 
                else {
                    $msg = 'Варіант голосування успішно доданий.';
                }
                Yii::app( )->user->setFlash( 'info', $msg );
				
				if ( !empty( $_POST['save'] ) || ( empty( $_POST['save'] ) && empty( $_POST['apply'] ) ) )
				{
					Yii::app( )
						->getRequest( )
                		->redirect( '/admin/poll/items?id=' . $poll->id );
				}
				else {
					Yii::app( )
						->getRequest( )
                		->redirect( '/admin/poll/itemedit?poll_id=' . $poll->id . '&id=' . $model->id );
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
        
        if ( isset( $_POST['items'] ) && count( $_POST['items'] ) ) 
        {
            foreach ( $_POST['items'] AS $id )
			{
                PollItems::model( )
                	->deleteByPk( $id );
			}

            Yii::app( )->user->setFlash( 'info', 'Варіанти голосування видалені.' );
        }

        Yii::app( )
        	->getRequest( )
        	->redirect( '/admin/poll/items?id=' . $poll_id );
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
		Yii::app( )->user->setFlash( 'info', 'Новий порядок збережений.' );
        Yii::app( )
        	->getRequest( )
        	->redirect( '/admin/poll/items?id=' . $poll_id ); 
        
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
		$model = 'PollItems';

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
		Yii::app( )->user->setFlash( 'info', 'Новий порядок збережений.' );
        Yii::app( )
        	->getRequest( )
        	->redirect( '/admin/poll/items?id=' . $poll_id ); 
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