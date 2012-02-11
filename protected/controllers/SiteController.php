<?php

/**
 * Class describes all the events associated with basic Site operations
 */
class SiteController extends Controller 
{
	/**
	 * Displays items on index page
	 * 
	 * @access public
	 * 
	 * @return void
	 */
    public function actionIndex( ) 
    {
    	// Get published news
    	$command = Yii::app( )->db->createCommand( );
		
		$fields = array( 'f.*' );
		$fields_name = array( 'title', 'alias', 'body', 'created', 'modified', 'ordering' => 'item_ordering' );
		
		// Get fields from other tables
		foreach ( $fields_name AS $index => $name )
		{
			if ( is_numeric( $index ) )
			{
				$index = $name;
			}
			
			$fields[] = "CASE f.section"
						. " WHEN 'KnowOur' THEN (SELECT ko.{$index} FROM know_our AS ko WHERE ko.id = f.item_id )"
						. " WHEN 'News' THEN (SELECT n.{$index} FROM news AS n WHERE n.id = f.item_id )"
						. " ELSE null"
						. " END AS '{$name}'";
		}
		
		$rows = $command->selectDistinct( $fields )
			->from( 'frontpage AS f' )
			->order( 'f.ordering ASC, item_ordering ASC, modified DESC' )
			->queryAll( );
			
		foreach ( $rows AS &$row )
		{
			$row = (object) $row;
		}
		
        $this->render( 'index', array( 'rows' => $rows ) );
		return true;
    }
	
	/**
	 * Manages operations with news
	 * 
	 * @access public
	 * 
	 * @return void
	 */
    public function actionNews() 
    {
    	if ( isset( $_GET['slug'] ) && !isset( $_GET['id'] ) )
		{
			$_GET['id'] = ( int ) $_GET['slug'];
		}
		if ( isset( $_GET['id'] ) ) 
        {
            $this->class = 'class="contentBody"';

            $news = News::model( )
            	->findByPk( $_GET['id'] );

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
		return true;
    }
	
	/**
	 * Manages operations with know our items
	 * 
	 * @access public
	 * 
	 * @return void
	 */
    public function actionKnowOur( ) 
    {
    	if ( isset( $_GET['slug'] ) && !isset( $_GET['id'] ) )
		{
			$_GET['id'] = ( int ) $_GET['slug'];
		}
        if ( isset( $_GET['id'] ) ) 
        {
            $this->class = 'class="contentBody"';

            $record = KnowOur::model( )
            	->findByPk( $_GET['id'] );

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
            $this->class = 'class="knowour"';

            $rows = KnowOur::model( )
            	->published( )
            	->findAll( );
            $this->render( 'persons', array( 
            	'rows' => $rows, 
            	'view' => 'knowour'
            ) );
        }
		return true;
    }
	
	/**
	 * Manages operations with city style items
	 * 
	 * @access public
	 * 
	 * @return void
	 */
    public function actionCityStyle( ) 
    {
    	if ( isset( $_GET['slug'] ) && !isset( $_GET['id'] ) )
		{
			$_GET['id'] = ( int ) $_GET['slug'];
		}
        if ( isset( $_GET['id'] ) ) 
        {
            $this->class = 'class="contentBody"';

            $record = CityStyle::model( )
            	->findByPk( $_GET['id'] );

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
		return true;
    }
	
	/**
	 * Manages operations with tyca items
	 * 
	 * @access public
	 * 
	 * @return void
	 */
    public function actionTyca( ) 
    {
    	if ( isset( $_GET['slug'] ) && !isset( $_GET['id'] ) )
		{
			$_GET['id'] = ( int ) $_GET['slug'];
		}
        if ( isset( $_GET['id'] ) ) 
        {
            $this->class = 'class="contentBody"';

            $record = Tyca::model( )
            	->findByPk( $_GET['id'] );

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
		return true;
    }
	
	/**
	 * Manages operations with pages
	 * 
	 * @access public
	 * 
	 * @return void
	 */
    public function actionPages( ) 
    {
        $this->class = 'class="pageBox"';

        $row = Pages::model()
        	->find( 'alias=?', array( $_GET['alias'] ) );

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
		return true;
    }
	
	/**
	 * Manages error page
	 * 
	 * @access public
	 * 
	 * @return void
	 */
    public function actionError( ) 
    {
        $this->class = 'class="errorBox"';

        $error = Yii::app( )
        	->errorHandler
        	->error;
			
        if ( $error ) 
        {
            if ( Yii::app( )->request->isAjaxRequest )
			{
                echo $error['message'];
			} 
			else {
                $this->render( 'error', $error );
			}
        }
		return true;
    }
}