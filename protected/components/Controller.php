<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController 
{
    private $_title;
    private $_descr;
    private $_keywords;
    
    public $sepatator = ' » ';
    public $class;
    public $show_poll = true;

    protected function beforeAction($action) 
    {
        if (Yii::app()->params['offline']) 
        {
            $this->renderPartial('offline');
            CApplication::end();
        }
        return true;
    }
	
	/**
     * Declares class-based actions.
     */
    public function actions() 
    {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
        );
    }
	
    public function getTitle() 
    {
        if ( empty($this->_title) )
		{
            return Yii::app()->params['title'];
		}
        else {
            return $this->_title.' - '.Yii::app()->params['title'];
		}
    }

    public function setTitle($title) 
    {
        $this->_title = $title;
    }

    public function getDescription() 
    {
        if ( empty($this->_descr) )
		{
            return Yii::app()->params['description'];
		}
        else {
            return $this->_descr;
		}
    }

    public function setDescription($descr) 
    {
        $this->_descr = $descr;
    }

    public function getKeywords() 
    {
        if ( empty($this->_keywords) )
		{
            return Yii::app()->params['keywords'];
		}
        else {
            return $this->_keywords;
		}
    }
    
    public function setKeywords($keywords) 
    {
        $this->_keywords = $keywords;
    }
    
    public function getPoll()
    {                
        $poll = Poll::model()->published()->find();
        return $poll;
    }    
}