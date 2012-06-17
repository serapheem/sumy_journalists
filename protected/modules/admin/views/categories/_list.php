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

	<table>
		<thead>
			<tr>
				<th width="20"><input type="checkbox" value="selectAll" /></th>
				<th width="20">&nbsp;</th>
				<th class="tl"><b><?php echo Yii::t( 'main', 'TITLE' ) ?></b></th>
				<th width="70"><?php echo Yii::t( 'main', 'VIEWS' ) ?></th>
				<th width="80"><?php echo Yii::t( 'main', 'PUBLISHED' ) ?></th>
				<th width="90"><?php 
					echo Yii::t( 'main', 'ORDER' ); ?> 
					<a href="#" title="<?php echo Yii::t( 'main', 'SAVE_ORDER' ) ?>" onclick="<?php echo $order_onclick ?>">
						<span class="state saveorder">&nbsp;</span>
					</a>
				</th>
				<th width="110"><?php echo Yii::t( 'main', 'LAST_UPDATED' ) ?></th>
				<th width="20"><?php echo Yii::t( 'main', 'ID' ) ?></th>
			</tr>
		</thead>
		<tbody>
		<?php if ( empty( $rows ) ) : ?>
			<tr><td colspan="8" class="tc"><?php echo Yii::t( $section_id, 'NO_ITEMS' ) ?></td></tr>
		<?php else : ?>
			<?php foreach ( $rows AS $k => $row ) : ?>
				<?php 
				// Get delete data
				$delete_onclick = "if ( confirm('" . Yii::t( $section_id, 'DELETE_ITEM' ) 
								. "?') ) postSend('/admin/{$section_id}/delete', { 'items[]': {$row->id} }); return false;";
				// Get edit link
				$link = "/admin/{$section_id}/edit?id={$row->id}";
				// Get publish data
				if ($row->publish) 
				{
					$publish_title = Yii::t( 'main', 'UNPUBLISH' );
					$publish_class = 'state publish';
				} 
				else {
					$publish_title = Yii::t( 'main', 'PUBLISH' );
					$publish_class = 'state unpublish';
				}
				$publish_onclick = "postSend('/admin/{$section_id}/edit', { id: {$row->id}, '{$this->model}[publish]': " 
								. (1 - $row->publish) . " }); return false;";
				// Get order data
				$order_up_onclick = "postSend('/admin/{$section_id}/changeorder', { id: {$row->id}, type: 'up' }); return false;";
				$order_down_onclick = "postSend('/admin/{$section_id}/changeorder', { id: {$row->id}, type: 'down' }); return false;";
				// Get modified date
				$modified_date = CLocale::getInstance( 'uk' )->dateFormatter->formatDateTime( $row->modified, 'long' );
				?>
			<tr>
				<td>
					<input type="checkbox" name="items[]" value="<?php echo $row->id ?>" />
				</td>
				<td>
					<a href="#" title="<?php echo Yii::t( 'main', 'REMOVE' ) ?>" onclick="<?php echo $delete_onclick ?>">
						<span class="state delete">&nbsp;</span>
					</a>
				</td>
				<td class="tl">
					<a href="<?php echo $link ?>" title="<?php echo Yii::t( 'main', 'EDIT' ) ?>"><?php echo CHtml::encode( $row->title ) ?></a>
				</td>
				<td><?php echo $row->views ?></td>
				<td>
					<a href="#" title="<?php echo $publish_title ?>" onclick="<?php echo $publish_onclick ?>">
						<span class="<?php echo $publish_class ?>">&nbsp;</span>
					</a>
				</td>
				<td>
					<?php if( $k != 0 ) : ?>
						<a href="#" title="<?php echo Yii::t( 'main', 'UP' ) ?>" onclick="<?php echo $order_up_onclick ?>">
							<span class="uparrow">&nbsp;</span>
						</a>
					<?php else : ?>
						<span class="uparrow inactive">&nbsp;</span>
					<?php endif; ?>
						
					<?php if ( ( $k + 1 ) != count( $rows ) ) : ?>
						<a href="#" title="<?php echo Yii::t( 'main', 'DOWN' ) ?>" onclick="<?php echo $order_down_onclick ?>">
							<span class="downarrow">&nbsp;</span>
						</a>
					<?php else : ?>
						<span class="downarrow inactive">&nbsp;</span>
					<?php endif; ?>
						
					<input type="text" name="order[<?php echo $row->id ?>]" value="<?php echo $row->ordering ?>" size="2" class="tc" />
				</td>
				<td><?php echo $modified_date ?></td>
				<td><?php echo $row->id ?></td>
			</tr>
			<?php endforeach; ?>
		<?php endif; ?>
		</tbody>
	</table>
</form>
</div>
