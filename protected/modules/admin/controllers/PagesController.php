<?php

/**
 * Pages Controller Class
 */
class PagesController extends AdminController
{
	/**
	 * Name of default model
	 * 
	 * @access public
	 * @var string
	 */
	public $model = 'Pages';
	
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
			->findAll( );

		$this->render( 'list', array( 'rows' => $rows ) );
		return true;
	}
	
}
