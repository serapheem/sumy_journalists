<?php
/**
 * Poll list layout file
 */
$this->breadcrumbs = array(
	'Голосування'
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

$delete_onclick = "if(confirm('Видалити?')) $('#admin-form').attr('action', '/admin/poll/delete').submit(); return false;";
?>

<h1 class="main">Голосування</h1>

<form action="#" method="post" id="admin-form">
	<a href="/admin/poll/edit" title="Додати"><span class="state add"></span> Додати</a>
	<a href="#" title="Видалити обрані" onclick="<?php echo $delete_onclick ?>"><span class="state delete"></span> Видалити обрані</a>
	
	<table style="clear:both">
		<thead>
			<tr>
				<th width="25"><input type="checkbox" value="selectAll" /></th>
				<th width="35">&nbsp;</th>
				<th align="left"><b>Назва</b></th>
				<th width="130" align="center">&nbsp;</th>
				<th width="70" align="center">Опубліковано</th>
				<th width="25" align="center">ID</th>
			</tr>
		</thead>
		<tbody>
		<?php if ( empty( $rows ) ) : ?>
			<tr><td colspan="6" align="center">Немає жодного голосування.</td></tr>
		<?php else : ?>
			<?php foreach ( $rows AS $row ) : ?>
				<?php 
				// Get delete data
				$delete_onclick = "if ( confirm('Видалити?') ) postSend('/admin/poll/delete', { 'items[]': {$row->id} }); return false;";
				// Get edit link
				$link = "/admin/poll/edit?id={$row->id}";
				// Get publish data
				if ($row->publish) 
				{
					$publish_title = 'Відмінити публікацію';
					$publish_class = 'state publish';
				} 
				else {
					$publish_title = 'Опублікувати';
					$publish_class = 'state unpublish';
				}
				$publish_onclick = "postSend('/admin/poll/edit', { id: {$row->id}, 'Poll[publish]': " . (1 - $row->publish) . " }); return false;";
				?>
			<tr>
				<td>
					<input type="checkbox" name="items[]" value="<?php echo $row->id; ?>" />
				</td>
				<td class="tc">
					<a href="#" title="Видалити" onclick="<?php echo $delete_onclick ?>"><span class="state delete"></span></a>
				</td>
				<td class="tl">
					<a href="<?php echo $link ?>" title="Редагувати">
						<?php echo CHtml::encode( $row->name ) ?>
					</a>
				</td>
				<td>
					<a href="/admin/poll/items?id=<?php echo $row->id; ?>">Редагувати елементи</a>
				</td>
				<td>
					<a href="#" title="<?php echo $publish_title ?>" onclick="<?php echo $publish_onclick ?>">
						<span class="<?php echo $publish_class ?>"></span>
					</a>
				</td>
				<td><?php echo $row->id; ?></a></td>
			</tr>
			<?php endforeach; ?>
		<?php endif; ?>
		</tbody>
	</table>
</form>