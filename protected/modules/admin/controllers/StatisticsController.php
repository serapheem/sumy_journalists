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
		// Get published news
    	$command = Yii::app( )->db->createCommand( );
		
		// Get title from other tables
		$title_query = "CASE cn.section"
					. " WHEN 'News' THEN (SELECT n.title FROM news AS n WHERE n.id = cn.item_id )"
					. " WHEN 'Participants' THEN (SELECT p.title FROM participants AS p WHERE p.id = cn.item_id )"
					. " ELSE null"
					. " END AS 'title'";
					
		// Get alias from other tables
		$alias_query = "CASE cn.section"
					. " WHEN 'News' THEN (SELECT n.alias FROM news AS n WHERE n.id = cn.item_id )"
					. " WHEN 'Participants' THEN (SELECT p.alias FROM participants AS p WHERE p.id = cn.item_id )"
					. " ELSE null"
					. " END AS 'alias'";
		
        $rows = $command->selectDistinct( array( 'cn.*', $title_query, $alias_query ) )
			->from( 'comments_number AS cn' )
			->order( 'cn.modified DESC, cn.number DESC' );
		
		$type = '';
		if ( !empty( $_GET['type'] ) )
		{
			$type = $_GET['type'];
			$command->where( 'cn.type=:type', array( ':type' => $type ) );
		}
		$rows = $command->queryAll( );
		
		$this->render( 'commentsnumber', array( 
			'rows' => $rows, 
			'type' => $type 
		) );
		return true;
	}
	
}