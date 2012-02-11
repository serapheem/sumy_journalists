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
		
		$fields = array( 'cn.*' );
		$fields_name = array( 'title', 'alias' );
		
		// Get fields from other tables
		foreach ( $fields_name AS $name )
		{
			$fields[] = "CASE cn.section"
						. " WHEN 'CityStyle' THEN (SELECT cs.{$name} FROM city_style AS cs WHERE cs.id = cn.item_id )"
						. " WHEN 'KnowOur' THEN (SELECT ko.{$name} FROM know_our AS ko WHERE ko.id = cn.item_id )"
						. " WHEN 'News' THEN (SELECT n.{$name} FROM news AS n WHERE n.id = cn.item_id )"
						. " WHEN 'Participants' THEN (SELECT p.{$name} FROM participants AS p WHERE p.id = cn.item_id )"
						. " WHEN 'Tyca' THEN (SELECT t.{$name} FROM tyca AS t WHERE t.id = cn.item_id )"
						. " ELSE null"
						. " END AS '{$name}'";
		}
		
		$rows = $command->selectDistinct( $fields )
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