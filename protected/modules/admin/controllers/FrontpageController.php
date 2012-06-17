<?php

/**
 * Front page Controller Class
 */
class FrontpageController extends AdminAbstractController 
{
	/**
	 * Name of default model
	 * 
	 * @access public
	 * @var string
	 */
	public $model = 'Frontpage';
	
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
			->getList( );
		
		$this->render( 'list', array( 'rows' => $rows ) );
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
				$parts = explode( ':', $id );
				if ( count( $parts ) != 2 )
				{
					continue;
				}
				
				$model::model( )->deleteAllByAttributes( array( 
					'section' => $parts[0],
					'item_id' => $parts[1]
				) );
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
				$parts = explode( ':', $key );
				if ( count( $parts ) != 2 )
				{
					continue;
				}
				
				$record = $model::model( )->findByAttributes( array(
					'section' => $parts[0],
					'item_id' => $parts[1]
				) );

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

		if ( !empty( $type ) && !empty( $id ) )
		{
			$parts = explode( ':', $id );
			if ( count( $parts ) == 2 )
			{
				$record = $model::model( )
					->findByAttributes( array(
						'section' => $parts[0],
						'item_id' => $parts[1]
					) );
	
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
			->ordering()
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
