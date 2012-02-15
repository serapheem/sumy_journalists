<?php
/**
 * Front page list layout file
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

<?php 
$menu_items = array( 
	'news' => Yii::t( 'news', 'SECTION_NAME' ), 
	'citystyle' => Yii::t( 'citystyle', 'SECTION_NAME' ), 
	'knowour' => Yii::t( 'knowour', 'SECTION_NAME' ), 
	'tyca' => Yii::t( 'tyca', 'SECTION_NAME' ), 
	'participants' => Yii::t( 'participants', 'SECTION_NAME' ),
	'frontpage' => Yii::t( 'frontpage', 'SECTION_NAME' )
);
$this->renderPartial( '/html/submenu', array( 
	'items' => $menu_items, 
	'current' => $model_name 
) ); 
?>

<div class="box visible">
<form action="#" method="post" id="admin-form">
	<h1><?php echo Yii::t( $model_name, 'SECTION_NAME' ) ?></h1>

	<a href="#" title="<?php echo Yii::t( $model_name, 'DELETE_ITEMS' ) ?>" onclick="<?php echo $delete_onclick ?>">
		<span class="state delete"></span> <?php echo Yii::t( $model_name, 'DELETE_ITEMS' ) ?>
	</a>

	<table>
		<thead>
			<tr>
				<th width="20"><input type="checkbox" value="selectAll" /></th>
				<th width="20">&nbsp;</th>
				<th class="tl"><b><?php echo Yii::t( 'main', 'TITLE' ) ?></b></th>
				<th width="110"><?php echo Yii::t( 'main', 'SECTION' ) ?></th>
				<th width="20"><?php echo Yii::t( 'main', 'ID' ) ?></th>
				
				<th width="90">
					<?php echo Yii::t( 'main', 'ORDER' ) ?> 
					<a href="#" title="<?php echo Yii::t( 'main', 'SAVE_ORDER' ) ?>" onclick="<?php echo $order_onclick ?>">
						<span class="state saveorder"></span>
					</a>
				</th>
				<th width="110"><?php echo Yii::t( 'main', 'LAST_UPDATED' ) ?></th>
			</tr>
		</thead>
		<tbody>
		<?php if ( empty( $rows ) ) : ?>
			<tr><td colspan="7" class="tc"><?php echo Yii::t( $model_name, 'NO_ITEMS' ) ?></td></tr>
		<?php else : ?>
			<?php foreach ( $rows AS $k => $row ) : ?>
				<?php 
				// Get delete data
				$id = CHtml::encode( $row->section . ':' . $row->item_id );
				$delete_onclick = "if ( confirm('" . Yii::t( $model_name, 'DELETE_ITEM' ) 
								. "?') ) postSend('/admin/{$model_name}/delete', { 'items[]': '{$id}' }); return false;";
				// Get order data
				$order_up_onclick = "postSend('/admin/{$model_name}/changeorder', { id: '{$id}', type: 'up' }); return false;";
				$order_down_onclick = "postSend('/admin/{$model_name}/changeorder', { id: '{$id}', type: 'down' }); return false;";
				// Get modified date
				$modified_date = CLocale::getInstance( 'uk' )->dateFormatter->formatDateTime( $row->modified, 'long' );
				?>
			<tr>
				<td>
					<input type="checkbox" name="items[]" value="<?php echo $id; ?>" />
				</td>
				<td>
					<a href="#" title="<?php echo Yii::t( 'main', 'REMOVE' ) ?>" onclick="<?php echo $delete_onclick ?>">
						<span class="state delete"></span>
					</a>
				</td>
				<td class="tl">
					<?php echo CHtml::encode( $row->title ) ?>
				</td>
				<td>
					<?php echo Yii::t( strtolower( $row->section ), 'SECTION_NAME' ) ?>
				</td>
				<td><?php echo $row->item_id ?></td>
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
						
					<input type="text" name="order[<?php echo $id ?>]" value="<?php echo $row->ordering ?>" size="2" class="tc" />
				</td>
				<td><?php echo $modified_date ?></td>
			</tr>
			<?php endforeach; ?>
		<?php endif; ?>
		</tbody>
	</table>
</form>
</div>
