<?php

class CKEditorWidget extends CInputWidget {

    //	General Purpose
    private $_editorOptions;
    protected $assetsPath;
    protected $cssFile;
    //	HTML Part
    protected $element = array();
    //	Javascript Part
    public $editorOptions = array();

    //	Initialize widget
    public function init() {
        //	publish  assets folder
        $this->assetsPath = Yii::app()->getAssetManager()->publish(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets');

        //	resolve HTML element name and id
        list($this->element['name'], $this->element['id']) = $this->resolveNameID();

        //	include CKEditor file
        Yii::app()->clientScript->registerScriptFile($this->assetsPath . '/ckeditor.js');
        Yii::app()->clientScript->registerScriptFile($this->assetsPath . '/AjexFileManager/ajex.js');

        //	include CSS file if defined
        if ($this->cssFile !== null) {
            Yii::app()->clientScript->registerCssFile($this->cssFile);
        }

        $this->jsOptions();

        $ckeditorScript = "var ckeditor = CKEDITOR.replace('%s', %s);\r\n " .
                "AjexFileManager.init({returnTo: 'ckeditor', editor: ckeditor});\r\n";
        $ckeditorScript = sprintf($ckeditorScript, $this->element['name'], $this->_editorOptions);
        
        Yii::app()->clientScript->registerScript('Yii.' . __CLASS__ . '#' . $this->element['id'], $ckeditorScript, CClientScript::POS_READY);
    }

    private function jsOptions() {
        //setting appearance Editor
        if ($this->editorOptions['toolbar'] == 'custom')
            $this->editorOptions['toolbar'] = "js:[
                            ['Save','NewPage','Preview','-','Templates'],
                            ['Cut','Copy','Paste','PasteText','PasteWord','-','SpellCheck'],
                            ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
                            ['Form','Checkbox','Radio','TextField','Textarea','Select'],
                            ['Bold','Italic','Underline','StrikeThrough','-','Subscript','Superscript'],
                            ['OrderedList','UnorderedList','-','Outdent','Indent','Blockquote'],
                            ['JustifyLeft','JustifyCenter','JustifyRight','JustifyFull'],
                            ['Link','Unlink','Anchor'],
                            ['Image','Youtube','Filebrowser','Table','Rule','Smiley','SpecialChar','PageBreak'],
                            ['Style','FontFormat','FontName','FontSize'],
                            ['TextColor','BGColor'],
                        ]";

        $cutoff = false;
        $jsObject = "\r\n{\r\n";

        foreach ($this->editorOptions as $name => $value) {
            if (is_string($value) && preg_match("/^js\:(.*)/i", $value)) {
                $jsObject .= "\t" . $name . ": " . preg_replace("/^js\:(.*)/i", "$1", $value) . ",\r\n";
            } else {
                $jsObject .= "\t" . $name . ": " . CJavaScript::jsonEncode($value) . ",\r\n";
            }

            $cutoff = true;
        }

        if ($cutoff) {
            $jsObject = substr($jsObject, 0, -3) . "\r\n";
        }

        $jsObject .= "}";

        $this->_editorOptions = $jsObject;
    }

    public function run() {
        $this->render('widget');
    }

}

?>