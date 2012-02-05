<?php
/**
 * Poll items layout file
 */
$parent_model_name = strtolower( $this->model );
$model_name = 'pollitems';

$this->breadcrumbs = array(
	Yii::t( $parent_model_name, 'SECTION_NAME' ) => '/admin/poll',
	Yii::t( $model_name, 'SECTION_NAME' ) . ': ' . $poll->title
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
				. "?')) $('#admin-form').attr('action', '/admin/{$parent_model_name}/itemdelete').submit(); return false;";
$order_onclick = "$('#admin-form').attr('action', '/admin/{$parent_model_name}/saveitemorder').submit(); return false;";
?>

<h1 class="main"><?php echo Yii::t( $model_name, 'SECTION_NAME' ) ?>: <?php echo $poll->title; ?></h1>

<form action="#" method="post" id="admin-form">
	
	<a href="/admin/<?php echo $parent_model_name ?>/itemedit?poll_id=<?php echo $poll->id; ?>" title="<?php echo Yii::t( $model_name, 'ADD_ITEM' ) ?>">
		<span class="state add"></span> <?php echo Yii::t( $model_name, 'ADD_ITEM' ) ?>
	</a>
	<a href="#" title="<?php echo Yii::t( $model_name, 'DELETE_ITEMS' ) ?>" onclick="<?php echo $delete_onclick ?>">
		<span class="state delete"></span> <?php echo Yii::t( $model_name, 'DELETE_ITEMS' ) ?>
	</a>
	
	<table style="clear:both">
		<thead>
			<tr>
				<th width="25"><input type="checkbox" value="selectAll" /></th>
				<th width="35">&nbsp;</th>
				<th align="left"><b><?php echo Yii::t( 'main', 'TITLE' ) ?></b></th>
				<th width="100">
					<?php echo Yii::t( 'main', 'ORDER' ) ?> 
					<a href="#" title="<?php echo Yii::t( 'main', 'SAVE_ORDER' ) ?>" onclick="<?php echo $order_onclick ?>">
						<span class="state saveorder"></span>
					</a>
				</th>
				<th width="90" align="center"><?php echo Yii::t( 'main', 'VOTES_NUMBER' ) ?></th>
				<th width="30" align="center"><?php echo Yii::t( 'main', 'ID' ) ?></th>
			</tr>
		</thead>
		<tbody>
		<?php if ( empty( $rows ) ) : ?>
			<tr><td colspan="6" class="tc"><?php echo Yii::t( $model_name, 'NO_ITEMS' ) ?></td></tr>
		<?php else : ?>
			<?php foreach ( $rows AS $k => $row ) : ?>
				<?php 
				// Get delete data
				$delete_onclick = "if ( confirm('" . Yii::t( $model_name, 'DELETE_ITEM' ) 
								. "?') ) postSend('/admin/{$parent_model_name}/itemdelete', { poll_id : {$poll->id}, 'items[]': {$row->id} }); return false;";
				// Get edit link
				$link = "/admin/{$parent_model_name}/itemedit?poll_id={$poll->id}&amp;id={$row->id}";
				// Get order data
				$order_up_onclick = "postSend('/admin/{$parent_model_name}/changeitemorder', { id: {$row->id}, type: 'up', poll_id: {$poll->id} }); return false;";
				$order_down_onclick = "postSend('/admin/{$parent_model_name}/changeitemorder', { id: {$row->id}, type: 'down', poll_id: {$poll->id} }); return false;";
				?>
			<tr>
				<td>
					<input type="checkbox" name="items[]" value="<?php echo $row->id; ?>" />
				</td>
				<td class="tc">
					<a href="#" title="<?php echo Yii::t( 'main', 'REMOVE' ) ?>" onclick="<?php echo $delete_onclick ?>">
						<span class="state delete"></span>
					</a>
				</td>
				<td style="text-align: left">
					<a href="<?php echo $link ?>" title="<?php echo Yii::t( 'main', 'EDIT' ) ?>">
						<?php echo CHtml::encode( $row->title ) ?>
					</a>
				</td>
				<td>
					<?php if( $k != 0 ) : ?>
						<a href="#" title="<?php echo Yii::t( 'main', 'UP' ) ?>" onclick="<?php echo $order_up_onclick ?>">
							<span class="uparrow"></span>
						</a>
					<?php else : ?>
						<span class="uparrow inactive"></span>
					<?php endif; ?>
						
					<?php if ( ( $k + 1 ) != count( $rows ) ) : ?>
						<a href="#" title="<?php echo Yii::t( 'main', 'DOWN' ) ?>" onclick="<?php echo $order_down_onclick ?>">
							<span class="downarrow"></span>
						</a>
					<?php else : ?>
						<span class="downarrow inactive"></span>
					<?php endif; ?>
						
					<input type="text" name="order[<?php echo $row->id; ?>]" value="<?php echo $row->ordering ?>" size="3" class="tc" />
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