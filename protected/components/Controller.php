<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController 
{
	/**
	 * The title of current page
	 * 
	 * @access private
	 * @var string
	 */
	private $_title;
	
	/**
	 * The meta description of current page
	 * 
	 * @access private
	 * @var string
	 */
	private $_descr;
	
	/**
	 * The meta keywords of current page
	 * 
	 * @access private
	 * @var string
	 */
	private $_keywords;
	
	/**
	 * The separator for bread crumbs
	 * 
	 * @access public
	 * @var string
	 */
	public $separator = ' » ';
	
	/**
	 * The class name for current page
	 * 
	 * @access public
	 * @var string
	 */
	public $class;
	
	public $show_poll = true;
	
	/**
	 * Checks if site is offline
	 * 
	 * @access protected
	 * @param string $action
	 * 
	 * @return boolean
	 */
	protected function beforeAction( $action ) 
	{
		if ( Yii::app( )->params['offline'] ) 
		{
			$this->renderPartial( 'offline' );
			CApplication::end( );
		}
		return true;
	}
	
	/**
	 * Declares class-based actions.
	 */
	public function actions( ) 
	{
		return array(
			'captcha' => array(
				'class' => 'CCaptchaAction',
				'backColor' => 0xFFFFFF,
			),
		);
	}
	
	/**
	 * Returns the title for current page
	 * 
	 * @access public
	 * 
	 * @return string
	 */
	public function getTitle( ) 
	{
		if ( empty( $this->_title ) )
		{
			return Yii::app( )->params['title'];
		}
		else {
			return $this->_title.' - '.Yii::app( )->params['title'];
		}
	}
	
	/**
	 * Sets the title for current page
	 * 
	 * @access public
	 * @param string $title
	 * 
	 * @return void
	 */
	public function setTitle( $title ) 
	{
		$this->_title = $title;
	}
	
	/**
	 * Returns the meta description for current page
	 * 
	 * @access public
	 * 
	 * @return string
	 */
	public function getDescription( ) 
	{
		if ( empty( $this->_descr ) )
		{
			return Yii::app( )->params['description'];
		}
		else {
			return $this->_descr;
		}
	}
	
	/**
	 * Sets the meta description for current page
	 * 
	 * @access public
	 * @param string $title
	 * 
	 * @return void
	 */
	public function setDescription( $descr ) 
	{
		$this->_descr = $descr;
	}
	
	/**
	 * Returns the meta keywords for current page
	 * 
	 * @access public
	 * 
	 * @return string
	 */
	public function getKeywords( ) 
	{
		if ( empty( $this->_keywords ) )
		{
			return Yii::app( )->params['keywords'];
		}
		else {
			return $this->_keywords;
		}
	}
	
	/**
	 * Sets the meta keywords for current page
	 * 
	 * @access public
	 * @param string $title
	 * 
	 * @return void
	 */
	public function setKeywords( $keywords ) 
	{
		$this->_keywords = $keywords;
	}
	
}
