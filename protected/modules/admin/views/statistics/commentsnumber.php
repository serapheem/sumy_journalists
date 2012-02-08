<?php
/**
 * Comments number layout file
 */

$this->breadcrumbs = array(
	Yii::t( 'statistics', 'SECTION_NAME' )
);
?>

<h1 class="main"><?php echo Yii::t( 'statistics', 'SECTION_NAME' ) ?></h1>

<?php 
$menu_items = array( 
	'statistics/commentsnumber?type=vkontakte' => Yii::t( 'statistics', 'VKONTAKTE' ) 
);
$this->renderPartial( '/html/submenu', array( 
	'items' => $menu_items, 
	'current' => 'statistics/commentsnumber' . ( empty( $type ) ? '' : '?type=' . $type ) 
) ); 
?>

<div class="box visible">
<form action="#" method="post" id="admin-form">
	<h1><?php echo Yii::t( 'statistics', 'VKONTAKTE' ) ?></h1>
	
	<table style="clear:both">
		<thead>
			<tr>
				<th class="tl" style="padding-left: 15px"><?php echo Yii::t( 'main', 'TITLE' ) ?></th>
				<th width="80"><?php echo Yii::t( 'main', 'SECTION' ) ?></th>
				<th width="115"><?php echo Yii::t( 'main', 'COMMENTS_NUMBER' ) ?></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ( $rows as $row ): ?>
			<?php 
			$model_name = $row->section;
			$item = $model_name::model( )
				->findByPk( $row->item_id );
			
			if ( empty( $item ) )
			{
				continue;
			}
			
			// Get edit link
			$section = strtolower( $row->section );
			$link = "/{$section}/{$row->item_id}";
			?>
			<tr>
				<td style="padding-left: 15px" class="tl">
					<a href="<?php echo $link ?>" title="<?php echo Yii::t( 'main', 'EDIT' ) ?>" target="_blank">
						<?php echo CHtml::encode( $item->title ) ?>
					</a>
				</td>
				<td><?php echo Yii::t( $section, 'SECTION_NAME' ) ?></td>
				<td><?php echo $row->number ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</form>
</div>
