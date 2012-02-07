<?php
/**
 * Poll list layout file
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
?>

<h1 class="main"><?php echo Yii::t( $model_name, 'SECTION_NAME' ) ?></h1>

<form action="#" method="post" id="admin-form">
	<a href="/admin/<?php echo $model_name ?>/edit" title="<?php echo Yii::t( $model_name, 'ADD_ITEM' ) ?>">
		<span class="state add">&nbsp;</span> <?php echo Yii::t( $model_name, 'ADD_ITEM' ) ?>
	</a>
	<a href="#" title="<?php echo Yii::t( $model_name, 'DELETE_ITEMS' ) ?>" onclick="<?php echo $delete_onclick ?>">
		<span class="state delete">&nbsp;</span> <?php echo Yii::t( $model_name, 'DELETE_ITEMS' ) ?>
	</a>
	
	<table style="clear:both">
		<thead>
			<tr>
				<th width="25"><input type="checkbox" value="selectAll" /></th>
				<th width="35">&nbsp;</th>
				<th align="left"><b><?php echo Yii::t( 'main', 'TITLE' ) ?></b></th>
				<th width="130" align="center">&nbsp;</th>
				<th width="70" align="center"><?php echo Yii::t( 'main', 'PUBLISHED' ) ?></th>
				<th width="25" align="center"><?php echo Yii::t( 'main', 'ID' ) ?></th>
			</tr>
		</thead>
		<tbody>
		<?php if ( empty( $rows ) ) : ?>
			<tr><td colspan="6" class="tc"><?php echo Yii::t( $model_name, 'NO_ITEMS' ) ?></td></tr>
		<?php else : ?>
			<?php foreach ( $rows AS $row ) : ?>
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
				?>
			<tr>
				<td>
					<input type="checkbox" name="items[]" value="<?php echo $row->id; ?>" />
				</td>
				<td class="tc">
					<a href="#" title="<?php echo Yii::t( 'main', 'REMOVE' ) ?>" onclick="<?php echo $delete_onclick ?>">
						<span class="state delete">&nbsp;</span>
					</a>
				</td>
				<td class="tl">
					<a href="<?php echo $link ?>" title="<?php echo Yii::t( 'main', 'EDIT' ) ?>">
						<?php echo CHtml::encode( $row->title ) ?>
					</a>
				</td>
				<td>
					<a href="/admin/<?php echo $model_name ?>/items?id=<?php echo $row->id; ?>"><?php echo Yii::t( $model_name, 'MODERATE_ELEMENTS' ) ?></a>
				</td>
				<td>
					<a href="#" title="<?php echo $publish_title ?>" onclick="<?php echo $publish_onclick ?>">
						<span class="<?php echo $publish_class ?>">&nbsp;</span>
					</a>
				</td>
				<td><?php echo $row->id ?></td>
			</tr>
			<?php endforeach; ?>
		<?php endif; ?>
		</tbody>
	</table>
</form>