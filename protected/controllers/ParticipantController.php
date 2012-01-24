<?php

/**
 * Class describes all the events associated with Participant operations
 */
class ParticipantController extends Controller 
{
	/**
	 * Displays the top10 items
	 * 
	 * @access public
	 * 
	 * @return void
	 */
    public function actionTop10( ) 
    {
        $this->title = 'Top 10';
        $this->class = 'class="top10"';

        $rows = Participants::model( )
        	->published( )
        	->top10( )
        	->findAll( );
			
        $this->render( 'top', array(
        	'rows' => $rows, 
        	'view' => 'participant'
        ) );
		return true;
    }
	
	/**
	 * Displays the index page
	 * 
	 * @access public
	 * 
	 * @return void
	 */
	public function actionIndex( ) 
    {
        $this->title = 'Учасники';
        $this->class = 'class="participants"';

        $rows = Participants::model( )
        	->published( )
        	->findAll( );
			
        $this->render( 'participants', array(
        	'rows' => $rows, 
        	'view' => 'participant'
        ) );
		return true;
    }
	
	/**
	 * Displays the single item
	 * 
	 * @access public
	 * 
	 * @return void
	 */
	public function actionView( ) 
    {
        $this->class = 'class="participantBody"';
		
		if ( isset( $_GET['slug'] ) && !isset( $_GET['id'] ) )
		{
			$_GET['id'] = ( int ) $_GET['slug'];
		}
		if ( !isset( $_GET['id'] ) )
		{
			throw new CHttpException( 404, 'Зазначений учасник не знайдений.' );
		}
        $record = Participants::model( )
        	->findByPk( $_GET['id'] );

        if ( empty( $record ) ) 
        {
            throw new CHttpException( 404, 'Зазначений учасник не знайдений.' );
        }

        $this->title = $record->title;
        
        if ( Helper::isNewView( 'participants', $record ) )
        {
            $record->views++;
            $record->save( );
        }
            
		$this->render( 'participant', array( 'record' => $record ) );
		return true;
    }
	
	/**
	 * Displays the result statistics
	 * 
	 * @access public
	 * 
	 * @return void
	 */
	public function actionResults( )
	{
		$this->title = 'Top 10';
        $this->class = 'class="top10Results"';

        $rows = Participants::model( )
        	->results( )
        	->findAll( );
			
        $this->render( 'results', array(
        	'rows' => $rows, 
        	'view' => 'participant'
        ) );
		return true;
	}
	
}