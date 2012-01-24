<?php

/**
 * Class describes all the events associated with basic Site operations
 */
class AjaxController extends Controller 
{
    public function actionRating() 
    {
		$id = (int) $_GET['id'];
        $model = $_GET['model'];
        $term = (int) $_GET['term'];
        $error = 0;
		
		$msg = '';

		// Check session
		$session = Yii::app()->session;
        $change_rating = $session->get('change_rating');
        if ( empty($change_rating) ) 
        {
            $change_rating = array();
            $change_rating[$model] = array();
        } 
        elseif ( empty($change_rating[$model]) ) 
        {
            $change_rating[$model] = array();
        }
		
		if ( !in_array($id, $change_rating[$model]) )
		{
			// Check IP for voted
			$param = array(
						'section' => $model, 
						'ip' => $_SERVER['REMOTE_ADDR']
					);
			if ($model != 'Participants')
			{
				$param['item_id'] = $id;
			}
			
			$voted = VotedIP::model()->findByAttributes( $param );
			if ( empty($voted->ip) )
			{
				$can_change = true;
			}
			else {
				$can_change = false;
			}
		}
		else {
			$can_change = false;
		}

        if ( $can_change ) 
        {
            $record = $model::model()->findByPK($id);
            if (!empty($record)) 
            {
                if ($term < 0) 
                {
                    $record->rating--;
                } 
                elseif ($term > 0) 
                {
                    $record->rating++;
                }
                $record->save();
            } 
            else {
                $error = 1;
				$msg = 'Виникли технічні проблеми!';
            }

            if ( !$error ) 
            {
                array_push($change_rating[$model], $id);
				
				// Save voted IP
				$new_voted = new VotedIP( );
				$new_voted->section = $model;
				$new_voted->item_id = $id;
				$new_voted->ip = $_SERVER['REMOTE_ADDR'];
				$new_voted->created = date('Y-m-d H:i:s');
				if ( $new_voted->validate() )
				{
					$new_voted->save();
				}
            }
        }
		else {
			$record = $model::model()->findByPK($id);
			$error = 1;
			$msg = 'Ви уже проголосували!';
		}
		// Save session
		$session->add('change_rating', $change_rating);
		
		$result = array('error' => $error, 'msg' => $msg, 'rating' => $record->rating);
        echo json_encode($result);
        Yii::app()->end();
    }

    public function actionAddVoite() 
    {
        $poll_id = (int) $_GET['poll_id'];
        $item_id = (int) $_GET['item_id'];
        $error = 0;
		
		$session = Yii::app()->session;
        $poll = $session->get('poll');
        if (empty($poll)) 
        {
            $poll = array();
        }

        if (!in_array($poll_id, $poll)) 
        {
            $record = PollItems::model()->findByPK($item_id);
            if ( !empty($record) ) 
            {
                $record->count++;
                $record->save();
            } 
            else {
                $error = 1;
            }

            if (!$error) 
            {
                array_push($poll, $poll_id);
				
				// Save voted IP
				$new_voted = new VotedIP( );
				$new_voted->section = 'Poll';
				$new_voted->item_id = $poll_id;
				$new_voted->ip = $_SERVER['REMOTE_ADDR'];
				$new_voted->created = date('Y-m-d H:i:s');
				if ( $new_voted->validate() )
				{
					$new_voted->save();
				}
            }
        }
		$session->add('poll', $poll);
		
        $html = '';
        $poll = Poll::model()->findByPK($poll_id);
        if (!empty($poll) && is_array($poll->items)) 
        {
            $total = 0;
            foreach ($poll->items as $item) 
            {
                $total += $item->count;
            }
            
            $html = '<div>';
            foreach ($poll->items as $k => $item) 
            {
                $rate = round( ($item->count * 100 / $total), 2);
                $html .= '<div class="vote">'."{$item->name} - {$item->count} ($rate%)</div>";
                $html .= '<div class="imgvote"><img width="'.$rate.'%" height="10" style="border:1px solid black" src="'.Yii::app()->theme->baseUrl.'/images/poll'.(($k + 1)%5).'.gif" /></div>';
            }
            $html .= '</div>';
            $html .= '<strong>Всього проголосувало: '.$total.'</strong>';
        } 
        else {
            $error = 1;
        }

        $result = array('error' => $error, 'html' => $html);
        echo json_encode($result);
        Yii::app()->end();
    }

}