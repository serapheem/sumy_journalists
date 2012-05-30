<?php

/**
 * Class describes all the events associated with basic Site operations
 */
class SiteController extends Controller 
{
	/**
	 * Displays items on index page
	 * @return void
	 */
	public function actionIndex() 
	{
		$rows = Frontpage::model()->getList( );
		
		$this->render( 'index', array( 'rows' => $rows ) );
	}
	
	/**
	 * Manages operations with news
	 * @return void
	 */
	public function actionNews() 
	{
		if ( isset( $_GET['slug'] ) && !isset( $_GET['id'] ) ) {
			$_GET['id'] = ( int ) $_GET['slug'];
		}
		if ( isset( $_GET['id'] ) ) {
			$this->class = 'class="news"';

			$news = News::model( )->findByPk( $_GET['id'] );

			if ( empty( $news ) ) 
			{
				throw new CHttpException( 404, Yii::t( 'news', 'ITEM_NOT_FOUND' ) );
			}

			$this->title = $news->title;
			
			// Check if user view this item at first time
			if ( Helper::isNewView( 'news', $news ) )
			{
				$news->views++;
				$news->save( );
			}
			
			$news->body = Helper::addGallery( $news->body );

			$this->render( 'news', array( 'record' => $news ) );
		} 
		else {
			$this->title = Yii::t( 'news', 'SECTION_NAME' );
			$news = News::model( )
				->published( )
				->findAll( );
			
			$this->render( 'articles', array(
				'rows' => $news, 
				'view' => 'news'
			) );
		}
	}
	
	/**
	 * Manages operations with know our items
	 * @return void
	 */
	public function actionKnowOur() 
	{
		$this->class = 'class="knowour"';
		
		if ( isset( $_GET['slug'] ) && !isset( $_GET['id'] ) ) {
			$_GET['id'] = ( int ) $_GET['slug'];
		}
		if ( isset( $_GET['id'] ) ) {
			$record = KnowOur::model( )->findByPk( $_GET['id'] );

			if ( empty( $record ) ) 
			{
				throw new CHttpException( 404, Yii::t( 'knowour', 'ITEM_NOT_FOUND' ) );
			}

			$this->title = $record->title;
			
			// Check if user view this item at first time
			if ( Helper::isNewView( 'knowour', $record ) )
			{
				$record->views++;
				$record->save( );
			}
			
			$record->body = Helper::addGallery( $record->body );
			
			$this->render( 'knowour', array( 'record' => $record ) );
		} 
		else {
			$this->title = Yii::t( 'knowour', 'SECTION_NAME' );
			
			$rows = KnowOur::model( )
				->published( )
				->findAll( );
			$this->render( 'persons', array( 
				'rows' => $rows, 
				'view' => 'knowour'
			) );
		}
	}
	
	/**
	 * Manages operations with city style items
	 * @return void
	 */
	public function actionCityStyle() 
	{
		if ( isset( $_GET['slug'] ) && !isset( $_GET['id'] ) ) {
			$_GET['id'] = ( int ) $_GET['slug'];
		}
		if ( isset( $_GET['id'] ) ) {
			$record = CityStyle::model( )->findByPk( $_GET['id'] );

			if ( empty( $record ) ) 
			{
				throw new CHttpException( 404, Yii::t( 'citystyle', 'ITEM_NOT_FOUND' ) );
			}

			$this->title = $record->title;
			
			// Check if user view this item at first time
			if ( Helper::isNewView( 'citystyle', $record ) )
			{
				$record->views++;
				$record->save( );
			}
			
			$record->body = Helper::addGallery( $record->body );
			
			$this->render( 'citystyle', array( 'record' => $record ) );
		} 
		else {
			$this->title = Yii::t( 'citystyle', 'SECTION_NAME' );
			$this->class = 'class="citystyle"';

			$city_style = CityStyle::model( )
				->published( )
				->findAll( );
				
			$this->render( 'articles', array(
				'rows' => $city_style, 
				'view' => 'citystyle'
			) );
		}
	}
	
	/**
	 * Manages operations with tyca items
	 * @return void
	 */
	public function actionTyca() 
	{
		if ( isset( $_GET['slug'] ) && !isset( $_GET['id'] ) ) {
			$_GET['id'] = ( int ) $_GET['slug'];
		}
		if ( isset( $_GET['id'] ) ) {
			$record = Tyca::model( )->findByPk( $_GET['id'] );

			if ( empty( $record ) ) 
			{
				throw new CHttpException( 404, Yii::t( 'tyca', 'ITEM_NOT_FOUND' ) );
			}

			$this->title = $record->title;
			
			// Check if user view this item at first time
			if ( Helper::isNewView( 'tyca', $record ) )
			{
				$record->views++;
				$record->save( );
			}
			
			$record->body = Helper::addGallery( $record->body );
			
			$this->render( 'tyca', array( 'record' => $record ) );
		} 
		else {
			$this->title = Yii::t( 'tyca', 'SECTION_NAME' );
			$this->class = 'class="tyca"';
			
			$rows = Tyca::model( )
				->published( )
				->findAll( );
			
			$this->render( 'persons', array(
				'rows' => $rows, 
				'view' => 'tyca'
			) );
		}
	}
	
	/**
	 * Manages operations with pages
	 * @return void
	 */
	public function actionPages() 
	{
		$this->class = 'class="page-box"';

		$row = Pages::model()->find( 'alias=?', array( $_GET['alias'] ) );

		if ( empty( $row ) )
		{
			throw new CHttpException( 404, Yii::t( 'pages', 'ITEM_NOT_FOUND' ) );
		}

		$this->title = $row->title;
		
		// Check if user view this item at first time
		if ( Helper::isNewView( 'pages', $row ) )
		{
			$row->views++;
			$row->save( );
		}

		$this->renderText( $row->body );
	}
	
	/**
	 * Manages error page
	 * @return void
	 */
	public function actionError( ) 
	{
		$this->class = 'class="error-box"';

		$error = Yii::app()->errorHandler->error;
			
		if ( $error ) {
			if ( Yii::app()->request->isAjaxRequest ) {
				echo $error['message'];
			} 
			else {
				$this->render( 'error', $error );
			}
		}
	}
	
}
