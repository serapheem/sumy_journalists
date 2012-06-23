<?php
/**
 * MyAdminLink class file.
 *
 * @author Serapheem
 */

Yii::import('zii.widgets.jui.CJuiButton');

/**
 * MyAdminLink displays a link button widget.
 */
class MyAdminButton extends CJuiButton
{
	/**
	 * @var string The identifier of grid which is connected button.
	 */
	public $grid_id = null;
	/**
	 * @var string The confirm message for onclick event.
	 */
	public $confirm = '';
	
	/**
	 * (non-PHPdoc)
	 * @see framework/zii/widgets/jui/CJuiButton::init()
	 */
	public function init() 
	{
		parent::init();
		list( $name, $id )=$this->resolveNameID();
		if ( !isset($this->onclick) )
		{
			if ( $this->confirm )
			{
				$confirm = "\n\tif ( confirm(" . CJavaScript::encode($this->confirm) . ") )";
			}
			else 
				$confirm = '';
			if( Yii::app()->request->enableCsrfValidation )
			{
		        $csrfTokenName = Yii::app()->request->csrfTokenName;
		        $csrfToken = Yii::app()->request->csrfToken;
		        $csrf = "\n\t\tdata:{ '$csrfTokenName':'$csrfToken' },";
			}
			else
				$csrf = '';
			
			$this->onclick = <<<EOD
function() {{$confirm}
	$.fn.yiiGridView.update('{$this->grid_id}', {
		type:'POST',
		url:$(this).attr('href'),{$csrf}
		success:function(data) {
			$.fn.yiiGridView.update('{$this->grid_id}');
		},
		error:function() {
		}
	});
	return false;
}
EOD;
		}
	}
}
