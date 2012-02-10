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
				<th width="110"><?php echo Yii::t( 'main', 'LAST_UPDATED' ) ?></th>
			</tr>
		</thead>
		<tbody>
		<?php if ( empty( $rows ) ) : ?>
			<tr>
				<td colspan="4"><?php echo Yii::t( 'statistics', 'NO_ITEMS' ) ?></td>
			</tr>
		<?php else : ?>
			<?php foreach ( $rows as $row ): ?>
				<?php 
				$row = ( object ) $row;
				if ( empty( $row->title ) )
				{
					continue;
				}
				// Get edit link
				$section = strtolower( $row->section );
				if ( empty( $row->alias ) )
				{
					$slug = $row->item_id;
				}
				else {
					$slug = $row->item_id . ':' . $row->alias;
				}
				$link = "/{$section}/{$slug}";
				// Get modified date
				$modified_date = CLocale::getInstance( 'uk' )->dateFormatter->formatDateTime( $row->modified, 'long' );
				?>
				<tr>
					<td style="padding-left: 15px" class="tl">
						<a href="<?php echo $link ?>" title="<?php echo Yii::t( 'main', 'EDIT' ) ?>" target="_blank">
							<?php echo CHtml::encode( $row->title ) ?>
						</a>
					</td>
					<td><?php echo Yii::t( $section, 'SECTION_NAME' ) ?></td>
					<td><?php echo $row->number ?></td>
					<td><?php echo $modified_date ?></td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
		</tbody>
	</table>
</form>
</div>
