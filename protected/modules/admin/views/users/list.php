<?php
/**
 * Users list layout file
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
	<a href="/admin/<?php echo $model_name ?>/add" title="<?php echo Yii::t( $model_name, 'ADD_ITEM' ) ?>">
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
				<th class="tl" style="padding-left: 15px"><?php echo Yii::t( 'main', 'NAME' ) ?></th>
				<th width="150" class="tl" style="padding-left: 15px"><?php echo Yii::t( 'main', 'LOGIN' ) ?></th>
				<th width="150"><?php echo Yii::t( 'main', 'EMAIL' ) ?></th>
				<th width="120"><?php echo Yii::t( 'main', 'LAST_VISITED' ) ?></th>
				<th width="100"><?php echo Yii::t( 'main', 'LAST_IP' ) ?></th>
				<th width="30"><?php echo Yii::t( 'main', 'ID' ) ?></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($rows as $row): ?>
			<?php 
			// Get delete data
			$delete_onclick = "if ( confirm('" . Yii::t( $model_name, 'DELETE_ITEM' ) 
								. "?') ) postSend('/admin/{$model_name}/delete', { 'items[]': {$row->id} }); return false;";
			// Get edit link
			$link = "/admin/{$model_name}/edit?id={$row->id}";
			// Get modified date
			$lasttime = CLocale::getInstance( 'uk' )->dateFormatter->formatDateTime( $row->lasttime, 'long' );
			?>
			<tr>
				<td>
					<?php if ($row->id != 1) : ?><input type="checkbox" name="items[]" value="<?php echo $row->id; ?>" /><?php endif; ?>
				</td>
				<td>
					<?php if ($row->id != 1): ?>
						<a href="#" title="<?php echo Yii::t( 'main', 'REMOVE' ) ?>" onclick="<?php echo $delete_onclick ?>">
							<span class="state delete">&nbsp;</span>
						</a>
					<?php else: ?>
						<span class="space">&nbsp;</span>
					<?php endif; ?>
				</td>
				<td style="padding-left: 15px" class="tl">
					<?php if ( $row->id != 1 ) : ?>
					<a href="<?php echo $link ?>" title="<?php echo Yii::t( 'main', 'EDIT' ) ?>">
						<?php echo CHtml::encode( $row->name ) ?>
					</a>
					<?php else : ?>
						<?php echo CHtml::encode( $row->name ) ?>
					<?php endif; ?>
				</td>
				<td class="tl" style="padding-left: 15px">
					<?php echo CHtml::encode( $row->username ) ?>
				</td>
				<td><?php echo $row->email ?></td>
				<td><?php echo $lasttime ?></td>
				<td><?php echo $row->ip ?></td>
				<td><?php echo $row->id ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</form>