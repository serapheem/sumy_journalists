<?php

/**
 * Statistics Controller Class
 */
class StatisticsController extends AdminController 
{
	/**
	 * Displays the main page
	 * 
	 * @access public
	 * 
	 * @return void
	 */
	public function actionIndex( )
	{
		Yii::app( )
			->getRequest( )
			->redirect( '/admin/statistics/commentsnumber?type=vkontakte' );
		
		return true;
	}
	
	/**
	 * Displays the list of items with comments number
	 * 
	 * @access public
	 * 
	 * @return void
	 */
	public function actionCommentsNumber( ) 
	{
		if ( empty( $_GET['type'] ) )
		{
			$type = '';
			$rows = CommentsNumber::model()
				->ordering( )
				->findAll( );
		}
		else {
			$type = $_GET['type'];
			$rows = CommentsNumber::model()
				->ordering( )
				->findAllByAttributes( array( 'type' => $type ) );
		}
			
		$this->render( 'commentsnumber', array( 
			'rows' => $rows, 
			'type' => $type 
		) );
		return true;
	}
	
}