<?php

/**
 * Class describes all the events associated with Participant operations
 */
class ParticipantController extends Controller 
{
    public function actionTop10() 
    {
        $this->title = 'Top 10';
        $this->class = 'class="top10"';

        $rows = Participants::model()->published()->top10()->findAll();
        $this->render('top', array('rows' => $rows, 'view' => 'participant') );
    }
	
	public function actionIndex() 
    {
        $this->title = 'Учасники';
        $this->class = 'class="participants"';

        $rows = Participants::model()->published()->findAll();
        $this->render('participants', array('rows' => $rows, 'view' => 'participant') );
    }

	public function actionView() 
    {
        $this->class = 'class="participantBody"';

        $record = Participants::model()->findByPk($_GET['id']);

        if (empty($record)) 
        {
            throw new CHttpException(404, 'Зазначена особа не знайдена.');
        }

        $this->title = $record->title;
        
        if (Helper::isNewView('participants', $record))
        {
            $record->views++;
            $record->save();
        }
            
		$this->render('participant', array('record' => $record) );
    }
	
	public function actionResults()
	{
		$this->title = 'Top 10';
        $this->class = 'class="top10Results"';

        $rows = Participants::model()->results()->findAll();
        $this->render('results', array('rows' => $rows, 'view' => 'participant') );
	}
	
}