<?php

class GACounter extends CWidget 
{
	/**
	 * Initialize widget
	 */	
	public function init() 
	{
		require_once dirname( __FILE__ ) . '/classes/gapi.class.php';
		
		parent::init();
	}

	public function run() 
	{
		if ( !class_exists( 'gapi' ) )
		{
			$this->render( 'widget' );
			return true;
		}
		
		$ga = new gapi( 'serapheem013@gmail.com', 'cyoj bpjz fybu ljna' );
		
		$ga->requestReportData( '53709199', array( 'year', 'month','day' ), array( 'pageviews', 'visits' ), array( '-year', '-month', '-day' ) );
		
		$today_count = 0;
		$week_count = 0;
		foreach( $ga->getResults() as $index => $result )
		{
			if ( $index == 0 ) 
			{
				$today_count = $result->getVisits();
			}
			if ( $index < 7 ) 
			{
				$week_count += $result->getVisits();
			}
			else {
				break;
			}
		}
		
		$this->render( 'widget', array( 'today' => $today_count, 'week' => $week_count, 'month' => $ga->getVisits() ) );
	}
}
