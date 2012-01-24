<?php
/*
 * ------------------------------------------------------------------------
 * Version: 0.1
 *
 * Created on 12/02/2011
 * Created by Serapheem
 *
 * ------------------------------------------------------------------------
 * Usage:
 * <?php $this->widget(
 *	'application.extensions.NHCKEditor.CKEditorWidget', 
 *	array(
 *		//	[Required] CModel object
 *		'model' => $model,
 *		'attribute' => 'ATTRIBUTE_NAME',
 *		
 *		//	[Optional] Options based on Edit Area API documentation
 *		'editorOptions' => array(
 *			//  Now supports PHP array and javascript code (must begin with js:)
 *			
 *			//'width' => 800,
 *			//'height' => 480,
 *			//'language' => 'th',
 *			
 *			
 *			//'toolbar' => 'Full',              //	format #1:	String
 *			
 *			//'toolbar' => array(		        //	format #2:	PHP array
 *			//	array('Source', '-', 'Save')
 *			//),
 *			
 *			//'toolbar' => "js:[		        //	format #3:	javascript code
 *			//	['Source', '-', 'Save']
 *			//]",
 *			
 *			//'uiColor' => '',
 *			
 *			//	... your own options
 *		),
 *		
 *		//	[Optional] htmlOptions based on Yii implementation
 *		'htmlOptions' => array(
 *			//
 *		),
 *	)
 * ); ?>
 * ------------------------------------------------------------------------
 */

class EditAreaWidget extends CInputWidget
{
	//	General Purpose
	private $_editorOptions;
	protected $assetsPath;
	
	//	HTML Part
	protected $element = array();
	
	//	Javascript Part
	public $editorOptions = array();
	
	//	Initialize widget
	public function init()
	{
		//	publish  assets folder
		$this->assetsPath = Yii::app()->getAssetManager()->publish(dirname(__FILE__).DIRECTORY_SEPARATOR.'assets');
		
		//	resolve HTML element name and id
		list($this->element['name'], $this->element['id']) = $this->resolveNameID();
		
		//	include CKEditor file
		Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/edit_area_full.js');
                
		$this->jsOptions();
		
		//$ckeditorScript = "CKEDITOR.replace('%s', %s);\r\n";
		//$ckeditorScript = sprintf($ckeditorScript, $this->element['name'], $this->_editorOptions);
                $ckeditorScript = 'editAreaLoader.init({ id: "%s" %s});';
		$ckeditorScript = sprintf($ckeditorScript, $this->element['id'], $this->_editorOptions);
		//$ckeditorScript .= 'var ckeditor = CKEDITOR.replace("'.$this->element['name'].'");' .
                  //                  'ajexFileManager.init({returnTo: \'ckeditor\', editor: ckeditor});';
                Yii::app()->clientScript->registerScript('Yii.'.__CLASS__.'#'.$this->element['id'], $ckeditorScript, CClientScript::POS_READY);
        }
	
	private function jsOptions()
	{
		//setting appearance Editor
		if ($this->editorOptions['toolbar'] == 'custom')
                        $this->editorOptions['toolbar'] = '"search, go_to_line, fullscreen, |, undo, redo, |, select_font, |, change_smooth_selection, highlight, reset_highlight"';
                elseif ($this->editorOptions['toolbar'] == 'simple')
                        $this->editorOptions['toolbar'] = '"search, go_to_line, fullscreen, |, select_font, |, change_smooth_selection, highlight, reset_highlight"';

                $cutoff = false;
		//$jsObject = "\r\n{\r\n";
                $jsObject = '';
		
		foreach($this->editorOptions as $name => $value)
		{
			$jsObject .= ', '.$name.': '.$value;
			
			//$cutoff = true;
		}
		
		if($cutoff)
		{
			$jsObject = substr($jsObject, 0, -3)."\r\n";
		}
		
		//$jsObject .= "}";
		
		$this->_editorOptions = $jsObject;
	}

	public function run()
	{
		$this->render('widget');
	}
}
?>