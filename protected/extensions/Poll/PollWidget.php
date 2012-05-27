<?php
/**
 * Poll Widget main class file
 */

class PollWidget extends CWidget 
{
	/**
	 * Path to assets folder of the widget
	 * @var string
	 */
	protected $assetsPath;
	
	/**
	 * Identifier of poll
	 * @var integer
	 */
	public $poll_id = 0;
	
	/**
	 * Initialize the widget
	 * @return void
	 */
	public function init()
	{
		// publish assets folder
		$this->assetsPath = Yii::app()->getAssetManager()->publish( dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' );
		
		parent::init();
	}
	
	/**
	 * Prepares data before render them
	 * @return void
	 */
	public function run() 
	{
		if ( $this->poll_id ) {
			$poll = Poll::model()->findByPK( $this->poll_id );
		}
		else {
			$poll = Poll::model()->published()->find();
		}
		
		if ( !empty( $poll ) && !empty( $poll->items ) )
		{ 
			$add_vote = true;
			$session = Yii::app( )->session->get( 'poll' );
			if ( !empty($session) && in_array( $poll->id, $session ) ) {
				$add_vote = false;
			}
			if ( $add_vote )
			{
				// Check IP for voted
				$param = array(
					'section' => 'Poll', 
					'item_id' => $poll->id,
					'ip' => $_SERVER['REMOTE_ADDR']
				);
				$voted = VotedIP::model()->findByAttributes( $param );
				if ( !empty( $voted->ip ) ) {
					$add_vote = false;
				}
			}
			// Get total count of votes
			$total = 0;
			foreach ( $poll->items as $item ) 
			{
				$total += $item->count;
			}
			
			$this->render( 'widget', array( 
				'show_poll' => true, 
				'assets_path' => $this->assetsPath, 
				'poll' => $poll, 
				'add_vote' => $add_vote, 
				'total' => $total 
			) );
		} 
		else {
			$this->render( 'widget', array( 'show_poll' => false ) );
		}
	}
	
}
