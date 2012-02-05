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
		
        $news = $command->selectDistinct( 'tbl.*, f.section' )
			->from( 'news tbl' )
			->join( 'frontpage f', 'f.item_id = tbl.id' )
			->where( array( 'AND', 'f.section = :section', 'tbl.publish = 1' ),
					array( ':section' => 'News' ) )
			->order( 'tbl.ordering ASC' )
			->queryAll( );
		
		// Get published know ours items
		$command->reset( );
		$know_our = $command->selectDistinct( 'tbl.*, f.section' )
			->from( 'know_our tbl' )
			->join( 'frontpage f', 'f.item_id = tbl.id' )
			->where( array( 'AND', 'f.section = :section', 'tbl.publish = 1' ),
					array( ':section' => 'KnowOur' ) )
			->order( 'tbl.ordering ASC' )
			->queryAll( );
						
		$news = array_merge( $news, $know_our );
		
		foreach ( $news AS $index => &$news_ )
		{
			$news_ = (object) $news_;
		}
		
        $this->render( 'index', array( 'news' => $news ) );
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

            $this->render( 'news', array( 'news' => $news ) );
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