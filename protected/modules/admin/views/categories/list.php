<?php
/**
 * Layout file for list of categories
 */

$this->breadcrumbs = array(
	Yii::t( $section_id, 'SECTION_NAME' )
);

$delete_onclick = "if(confirm('" . Yii::t( $section_id, 'DELETE_ITEMS' ) 
				. "?')) $('#admin-form').attr('action', '/admin/{$section_id}/delete').submit(); return false;";
$order_onclick = "$('#admin-form').attr('action', '/admin/{$section_id}/saveorder').submit(); return false;";
?>

<?php $this->renderSubmenu(); ?>

<div class="box visible">
<form action="#" method="post" id="admin-form">
	<h1><?php echo Yii::t( $section_id, 'SECTION_NAME' ) ?></h1>

	<a href="/admin/<?php echo $section_id ?>/edit" title="<?php echo Yii::t( $section_id, 'ADD_ITEM' ) ?>">
		<span class="state add">&nbsp;</span> <?php echo Yii::t( $section_id, 'ADD_ITEM' ); 
	?></a>
	<a href="#" title="<?php echo Yii::t( $section_id, 'DELETE_ITEMS' ) ?>" onclick="<?php echo $delete_onclick ?>">
		<span class="state delete">&nbsp;</span> <?php echo Yii::t( $section_id, 'DELETE_ITEMS' ); 
	?></a>
	
	<?php 
		$this->widget('zii.widgets.grid.CGridView', array(
			'id' => 'categories',
			'dataProvider' => $dataProvider,
			'filter' => $model,
			'selectableRows' => $itemPerPage,
			'ajaxUpdate' => 'user-info',
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
					'urlExpression' => '"/admin/' . $section_id . '/edit?id=" . $data->id',
					'linkHtmlOptions' => array( 'title' => Yii::t( 'main', 'EDIT' ) ),
					'htmlOptions' => array( 'class' => 'link-column tl' )
				),
				array( 'name' => 'hits', 'filter' => '', 'headerHtmlOptions' => array( 'width' => '70' ) ),
				array(
					'class' => 'MyDataLinkColumn',
					'name' => 'state',
					'filter' => array( 'prompt' => Yii::t( 'main', 'SELECT_STATUS' ), 0 => Yii::t( 'main', 'UNPUBLISHED' ), 1 => Yii::t( 'main', 'PUBLISHED' ) ),
					'labelExpression' => 'GridHelper::getStateLabel( $data->state )',
					'urlExpression' => '"/admin/' . $section_id . '/update?id=" . $data->id',
					'linkHtmlOptions' => array( 'titleExpression' => '$data->state ? Yii::t( "main", "UNPUBLISH" ) : Yii::t( "main", "PUBLISH" )' ),
					'htmlOptions' => array( 'class' => 'link-column button-column' ),
					'headerHtmlOptions' => array( 'width' => '130' )
				),
				array( 
					'name' => 'modified', 
					'value' => 'CLocale::getInstance( "uk" )->dateFormatter->formatDateTime( $data->modified, "long" )', 
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
	
</form>
</div>
