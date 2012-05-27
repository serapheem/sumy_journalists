<?php
/**
 * Main class for SocialComments Widget
 */

class SocialCommentsWidget extends CWidget 
{
	/**
	 * Name of the site content section
	 * @var sting
	 */
	public $section = null;
	
	/**
	 * Object of the site content
	 * @var CActiveRecord
	 */
	public $item = null;
	
	/**
	 * Path to assets folder of the widget
	 * @var string
	 */
	protected $assetsPath;
	
	/**
	 * Initialize the widget
	 * @return void
	 */
	public function init()
	{
		// publish assets folder
		$this->assetsPath = Yii::app()->getAssetManager()->publish( dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' );
		
		//	include required files
		Yii::app()->clientScript->registerCssFile( $this->assetsPath . '/css/smoothness/jquery-ui-1.8.17.custom.css' );
		Yii::app()->clientScript->registerScriptFile( $this->assetsPath . '/js/jquery-ui-1.8.16.custom.min.js', CClientScript::POS_END );
		
		parent::init();
	}
	
	/**
	 * Prepares data before render them
	 * @return void
	 */
	public function run() 
	{
		$this->render( 'widget', array( 'section' => $this->section, 'item' => $this->item ) );
	}
}
