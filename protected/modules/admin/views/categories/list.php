<?php
/**
 * Layout file for list of categories
 */

$this->breadcrumbs = array(
	Yii::t( $section_id, 'SECTION_NAME' )
);

$order_onclick = "$('#admin-form').attr('action', '/admin/{$section_id}/saveorder').submit(); return false;";
?>

<?php $this->renderSubmenu(); ?>

<div class="box visible">
	<h1><?php echo Yii::t( $section_id, 'SECTION_NAME' ) ?></h1>

	<?php 
	$this->widget( 'zii.widgets.jui.CJuiButton',
		array(
			'buttonType' => 'link',
			'name' => 'edit-button',
			'caption' => Yii::t( $section_id, 'ADD_ITEM' ),
			'url' => "/admin/{$section_id}/create",
			'htmlOptions' => array( 'title' => Yii::t( $section_id, 'ADD_ITEM' ) )
		)
	); 
	$this->widget( 'MyAdminButton',
		array(
			'buttonType' => 'link',
			'name' => 'delete-button',
			'caption' => Yii::t( $section_id, 'DELETE_ITEMS' ),
			'url' => "/admin/{$section_id}/delete",
			'confirm' => Yii::t( $section_id, 'DELETE_ITEMS' ),
			'grid_id' => 'categories',
			'htmlOptions' => array( 'title' => Yii::t( $section_id, 'DELETE_ITEMS' ) )
		)
	); 
	 
	$this->widget('zii.widgets.grid.CGridView', array(
		'id' => 'categories',
		'dataProvider' => $dataProvider,
		'filter' => $model,
		'selectableRows' => $itemPerPage,
		'ajaxUpdate' => 'user-info',
		// 'updateSelector' => '#categories .pager a, #categories .items thead th a, #admin-form .delete',
		'beforeAjaxUpdate' => 'updateAjaxRequest',
		'columns' => array(
			array(
				'class' => 'CCheckBoxColumn',
				'id' => 'items'
			),
			array(
				'class' => 'CButtonColumn',
				'template' => '{delete}',
				'deleteButtonUrl' => 'Yii::app()->controller->createUrl( "delete" ) . "?items=" . $data->primaryKey',
				'deleteConfirmation' => Yii::t( $section_id, 'DELETE_ITEM' )
			),
			array(
				'class' => 'MyDataLinkColumn', 
				'name' => 'title',
				'labelExpression' => 'CHtml::encode( $data->title )', 
				'urlExpression' => '"/admin/' . $section_id . '/update?id=" . $data->id',
				'linkHtmlOptions' => array( 'title' => Yii::t( 'main', 'EDIT' ) ),
				'htmlOptions' => array( 'class' => 'link-column tl' )
			),
			array( 'name' => 'hits', 'filter' => '', 'headerHtmlOptions' => array( 'width' => '70' ) ),
			array(
				'class' => 'MyDataLinkColumn',
				'name' => 'state',
				'filter' => array( 'prompt' => Yii::t( 'main', 'SELECT_STATUS' ), 0 => Yii::t( 'main', 'UNPUBLISHED' ), 1 => Yii::t( 'main', 'PUBLISHED' ) ),
				'labelExpression' => 'GridHelper::getStateLabel( $data->state )',
				'urlExpression' => '"/admin/' . $section_id . '/update?id=". $data->id ."&'. ucfirst( $section_id ) .'[state]=". (1 - $data->state)',
				'linkHtmlOptions' => array( 
					'class' => 'state', 'click' => 'ajaxChange', 
					'titleExpression' => '$data->state ? Yii::t( "main", "UNPUBLISH" ) : Yii::t( "main", "PUBLISH" )' 
				),
				'htmlOptions' => array( 'class' => 'link-column button-column' ),
				'headerHtmlOptions' => array( 'width' => '130' )
			),
			array( 
				'name' => 'modified', 
				'value' => 'Yii::app()->getDateFormatter()->formatDateTime( $data->modified, "long" )', 
				'filter' => '', 
				'headerHtmlOptions' => array( 'width' => '110' ) 
			),
			array(
				'name' => 'id',
				'header' => Yii::t( 'main', 'ID' ),
				'headerHtmlOptions' => array( 'width' => '30' )
			)
		),
	)); 
	?>
</div>
