<?php
/**
 * News list layout file
 */
$model_name = strtolower( $this->model );

$this->breadcrumbs = array(
	Yii::t( $model_name, 'SECTION_NAME' )
);

$cs = Yii::app( )->getClientScript( );  
$cs->registerScript(
	'custom_script',
	'jQuery(function($) 
	{
		$("#admin-form").find("tbody").find("tr").click(function(event)
		{
			if ( !$( event.target ).is("input") )
			{
				checkRow(this)
			}
		})
	});',
	CClientScript::POS_END
);

$delete_onclick = "if(confirm('" . Yii::t( $model_name, 'DELETE_ITEMS' ) 
				. "?')) $('#admin-form').attr('action', '/admin/{$model_name}/delete').submit(); return false;";
$order_onclick = "$('#admin-form').attr('action', '/admin/{$model_name}/saveorder').submit(); return false;";
?>

<h1 class="main"><?php echo Yii::t( 'main', 'MATERIALS' ) ?></h1>

<?php $this->renderPartial( '/html/submenu', array( 'view' => $model_name ) ); ?>

<div class="box visible">
<form action="#" method="post" id="admin-form">
	<h1><?php echo Yii::t( $model_name, 'SECTION_NAME' ) ?></h1>

	<a href="/admin/<?php echo $model_name ?>/edit" title="<?php echo Yii::t( $model_name, 'ADD_ITEM' ) ?>">
		<span class="state add">&nbsp;</span> <?php echo Yii::t( $model_name, 'ADD_ITEM' ) ?>
	</a>
	<a href="#" title="<?php echo Yii::t( $model_name, 'DELETE_ITEMS' ) ?>" onclick="<?php echo $delete_onclick ?>">
		<span class="state delete">&nbsp;</span> <?php echo Yii::t( $model_name, 'DELETE_ITEMS' ) ?>
	</a>

	<table>
		<thead>
			<tr>
				<th width="20"><input type="checkbox" value="selectAll" /></th>
				<th width="20">&nbsp;</th>
				<th class="tl"><b><?php echo Yii::t( 'main', 'TITLE' ) ?></b></th>
				<th width="70"><?php echo Yii::t( 'main', 'VIEWS' ) ?></th>
				<th width="50"><?php echo Yii::t( 'main', 'RATING' ) ?></th>
				<th width="80"><?php echo Yii::t( 'main', 'PUBLISHED' ) ?></th>
				<th width="60"><?php echo Yii::t( 'main', 'ON_FRONTPAGE' ) ?></th>
				<th width="90">
					<?php echo Yii::t( 'main', 'ORDER' ) ?> 
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
			<tr><td colspan="10" class="tc"><?php echo Yii::t( $model_name, 'NO_ITEMS' ) ?></td></tr>
		<?php else : ?>
			<?php foreach ( $rows AS $k => $row ) : ?>
				<?php 
				// Get delete data
				$delete_onclick = "if ( confirm('" . Yii::t( $model_name, 'DELETE_ITEM' ) 
								. "?') ) postSend('/admin/{$model_name}/delete', { 'items[]': {$row->id} }); return false;";
				// Get edit link
				$link = "/admin/{$model_name}/edit?id={$row->id}";
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
				$publish_onclick = "postSend('/admin/{$model_name}/edit', { id: {$row->id}, '{$this->model}[publish]': " 
								. (1 - $row->publish) . " }); return false;";
				// Get frontpage data
				if ( !empty( $row->frontpage->item_id ) && ( $row->id == $row->frontpage->item_id ) ) 
				{
					$frontpage_title = Yii::t( 'main', 'UNFEATURED' );
					$frontpage_class = 'state featured';
					$value = 0;
				} 
				else {
					$frontpage_title = Yii::t( 'main', 'FEATURED' );
					$frontpage_class = 'state unfeatured';
					$value = 1;
				}
				$frontpage_onclick = "postSend('/admin/{$model_name}/edit', { id: {$row->id}, '{$this->model}[frontpage]': {$value} }); return false;";
				// Get order data
				$order_up_onclick = "postSend('/admin/{$model_name}/changeorder', { id: {$row->id}, type: 'up' }); return false;";
				$order_down_onclick = "postSend('/admin/{$model_name}/changeorder', { id: {$row->id}, type: 'down' }); return false;";
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
					<a href="<?php echo $link ?>" title="<?php echo Yii::t( 'main', 'EDIT' ) ?>">
						<?php echo CHtml::encode( $row->title ) ?>
					</a>
				</td>
				<td><?php echo $row->views ?></td>
				<td><?php echo $row->rating ?></td>
				<td>
					<a href="#" title="<?php echo $publish_title ?>" onclick="<?php echo $publish_onclick ?>">
						<span class="<?php echo $publish_class ?>">&nbsp;</span>
					</a>
				</td>
				<td>
					<a href="#" title="<?php echo $frontpage_title ?>" onclick="<?php echo $frontpage_onclick ?>">
						<span class="<?php echo $frontpage_class ?>">&nbsp;</span>
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
