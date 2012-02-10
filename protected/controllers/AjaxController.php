<?php

/**
 * Class describes all the events associated with basic Site operations
 */
class AjaxController extends Controller
{
	/**
	 * Changes rating of the material
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function actionRating( )
	{
		$id = (int) $_GET['id'];
		$model = $_GET['model'];
		$term = (int) $_GET['term'];
		$error = 0;

		$msg = '';

		// Check session
		$session = Yii::app( )->session;
		$change_rating = $session->get( 'change_rating' );
		if ( empty( $change_rating ) )
		{
			$change_rating = array( );
			$change_rating[$model] = array( );
		}
		elseif ( empty( $change_rating[$model] ) )
		{
			$change_rating[$model] = array( );
		}
		
		// Also check user IP
		$can_change = false;
		if ( !in_array( $id, $change_rating[$model] ) )
		{
			// Check IP for voted
			$param = array(
				'section' => $model,
				'ip' => $_SERVER['REMOTE_ADDR']
			);
			if ( $model != 'Participants' )
			{
				$param['item_id'] = $id;
			}

			$voted = VotedIP::model( )
				->findByAttributes( $param );
			if ( empty( $voted->ip ) )
			{
				$can_change = true;
			}
		}
		
		// Add user vote
		if ( $can_change )
		{
			$record = $model::model( )
				->findByPK( $id );
			
			if ( !empty( $record ) )
			{
				if ( $term < 0 )
				{
					$record->rating--;
				}
				elseif ( $term > 0 )
				{
					$record->rating++;
				}
				$record->save( );
			}
			else {
				$error = 1;
				$msg = Yii::t( 'main', 'SOME_TECHNICAL_PROBLEMS' );
			}

			if ( !$error )
			{
				array_push( $change_rating[$model], $id );

				// Save voted IP
				$new_voted = new VotedIP( );
				$new_voted->section = $model;
				$new_voted->item_id = $id;
				$new_voted->ip = $_SERVER['REMOTE_ADDR'];
				$new_voted->created = date( 'Y-m-d H:i:s' );
				if ( $new_voted->validate( ) )
				{
					$new_voted->save( );
				}
			}
		}
		else {
			$record = $model::model( )
				->findByPK( $id );
			$error = 1;
			$msg = Yii::t( 'main', 'YOU_ALREADY_VOTED' );
		}
		// Save session
		$session->add( 'change_rating', $change_rating );

		$result = array(
			'error' => $error,
			'msg' => $msg,
			'rating' => $record->rating
		);
		echo json_encode( $result );
		Yii::app( )->end( );
		return true;
	}
	
	/**
	 * Adds vote for poll
	 */
	public function actionAddVoite( )
	{
		$poll_id = (int) $_GET['poll_id'];
		$item_id = (int) $_GET['item_id'];
		$error = 0;
		
		// Check session
		$session = Yii::app( )->session;
		$poll = $session->get( 'poll' );
		if ( empty( $poll ) )
		{
			$poll = array( );
		}
		
		// Also check user IP
		if ( !in_array( $poll_id, $poll ) )
		{
			$record = PollItems::model( )
				->findByPK( $item_id );
			if ( !empty( $record ) )
			{
				$record->count++;
				$record->save( );
			}
			else {
				$error = 1;
			}

			if ( !$error )
			{
				array_push( $poll, $poll_id );

				// Save voted IP
				$new_voted = new VotedIP( );
				$new_voted->section = 'Poll';
				$new_voted->item_id = $poll_id;
				$new_voted->ip = $_SERVER['REMOTE_ADDR'];
				$new_voted->created = date( 'Y-m-d H:i:s' );
				if ( $new_voted->validate( ) )
				{
					$new_voted->save( );
				}
			}
		}
		// Save session
		$session->add( 'poll', $poll );
		
		// Get poll block
		$html = '';
		$poll = Poll::model( )
			->findByPK( $poll_id );
		if ( !empty( $poll ) && is_array( $poll->items ) )
		{
			ob_start( );
			$this->renderPartial( '/html/poll', array( 'poll' => $poll ) );
			$html = ob_get_contents( );
			ob_end_clean( );
		}
		else {
			$error = 1;
		}

		$result = array(
			'error' => $error,
			'html' => $html
		);
		echo json_encode( $result );
		Yii::app( )->end( );
		return true;
	}
	
	/**
	 * Stores number of comments
	 * 
	 * @access public
	 * 
	 * @return void
	 */
	public function actionSaveCommentsNumber( )
	{ 
		if ( empty( $_POST['type'] ) || empty( $_POST['section'] )
			|| empty( $_POST['id'] ) || !isset( $_POST['num'] ) 
			|| empty( $_POST['date'] ) || empty( $_POST['sign'] )
			|| !isset( $_POST['last_comment'] ) )
		{
			Yii::app( )->end( );
			return true;
		}
		
		$type = $_POST['type'];
		$section = $_POST['section'];
		$id = ( int ) $_POST['id'];
		$num = ( int ) $_POST['num'];
		$date = $_POST['date'];
		$sign = $_POST['sign'];
		$last_comment = $_POST['last_comment'];
		
		if ( $sign != md5( 'uJCaEw2tOMoVMcgvFKlc' . $date . $num . $last_comment ) )
		{
			Yii::app( )->end( );
			return true;
		}
			
		if ( !$id )
		{
			Yii::app( )->end( );
			return true;
		}
		
		$timestamp = strtotime( $date );
		if ( $timestamp )
		{
			$date = date( 'Y-m-d H:i:s', $timestamp );
		}
		else {
			$date = date( 'Y-m-d H:i:s' );
		}
		
		$params = array(
			'type' => $type,
			'section' => $section,
			'item_id' => $id
		);
		if ( !$num )
		{
			CommentsNumber::model()
				->deleteAllByAttributes( $params );
		}
		else {
			$record = CommentsNumber::model()
				->findByAttributes( $params );
			
			if ( empty( $record ) )
			{
				$record = new CommentsNumber( );
				$record->type = $type;
				$record->section = $section;
				$record->item_id = $id;
				$record->number = $num;
				$record->modified = $date;
				
				if ( $record->validate( ) )
				{
					$record->save( );
				}
			}
			elseif ( $record->number != $num )
			{
				CommentsNumber::model()
					->updateAll( 
						array( 'number' => $num, 'modified' => $date ), 
						'type=:type AND section=:section AND item_id=:id',
						array( 
							':type' => $type, 
							':section' => $section, 
							':id' => $id 
						) 
					);
			}
		}
		Yii::app( )->end( );
		return true;
	}

}
