<?php
/**
 * Poll items layout file
 */
$this->breadcrumbs = array(
	'Голосування' => '/admin/poll',
	'Варіанти голосування: ' . $poll->name
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

$delete_onclick = "if(confirm('Видалити?')) $('#admin-form').attr('action', '/admin/poll/itemdelete').submit(); return false;";
$order_onclick = "$('#admin-form').attr('action', '/admin/poll/saveitemorder').submit(); return false;";
?>

<h1 class="main">Варіанти голосування: <?php echo $poll->name; ?></h1>

<form action="#" method="post" id="admin-form">
	
	<a href="/admin/poll/itemedit?poll_id=<?php echo $poll->id; ?>" class="add">Додати</a>
	<a href="#" class="delete" onclick="<?php echo $delete_onclick ?>">Видалити обрані</a>
	
	<table style="clear:both">
		<thead>
			<tr>
				<th width="25"><input type="checkbox" value="selectAll" /></th>
				<th width="35">&nbsp;</th>
				<th align="left"><b>Назва</b></th>
				<th width="100">Порядок <a href="#" onclick="<?php echo $order_onclick ?>" class="save-order"></a></th>
				<th width="90" align="center">Кількість голосів</th>
				<th width="30" align="center">ID</th>
			</tr>
		</thead>
		<tbody>
		<?php if ( empty( $rows ) ) : ?>
			<tr><td colspan="6" align="center">Немає жодного варіанту.</td></tr>
		<?php else : ?>
			<?php foreach ( $rows AS $k => $row ) : ?>
				<?php 
					// Get delete data
					$delete_onclick = "if ( confirm('Видалити?') ) postSend('/admin/poll/itemdelete', { poll_id : {$poll->id}, 'items[]': {$row->id} }); return false;";
					// Get edit link
					$link = "/admin/poll/itemedit?poll_id={$poll->id}&amp;id={$row->id}";
					// Get order data
					$order_up_onclick = "postSend('/admin/poll/changeitemorder', { id: {$row->id}, type: 'up', poll_id: {$poll->id} }); return false;";
					$order_down_onclick = "postSend('/admin/poll/changeitemorder', { id: {$row->id}, type: 'down', poll_id: {$poll->id} }); return false;";
					?>
			<tr>
				<td><input type="checkbox" name="items[]" value="<?php echo $row->id; ?>" /></td>
				<td class="tc">
					<a href="#" onclick="<?php echo $delete_onclick ?>" title="Видалити" class="delete"></a>
				</td>
				<td style="text-align: left">
					<a href="<?php echo $link ?>" title="Редагувати">
						<?php echo CHtml::encode( $row->name ) ?>
					</a>
				</td>
				<td>
					<?php if ( $k != 0 ) : ?>
						<a href="#" onclick="<?php echo $order_up_onclick ?>" class="order-up" title="Вверх"></a>
					<?php else : ?>
						<span class="space"></span>
					<?php endif; ?>
						
					<?php if ( ( $k + 1 ) != count( $rows ) ) : ?>
						<a href="#" onclick="<?php echo $order_down_onclick ?>" class="order-down" title="Вниз"></a>
					<?php else : ?>
						<span class="space"></span>
					<?php endif; ?>
						
					<input type="text" name="order[<?php echo $row->id; ?>]" value="<?php echo $row->ordering;?>" size="3" class="tc" />
				</td>
				<td><?php echo $row->count; ?></a></td>
				<td><?php echo $row->id; ?></a></td>
			</tr>
			<?php endforeach; ?>
		<?php endif; ?>
		</tbody>
	</table>
	<input type="hidden" name="model" value="PollItems" />
	<input type="hidden" name="poll_id" value="<?php echo $poll->id; ?>" />
</form>