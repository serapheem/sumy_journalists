<?php
/**
 * News list layout file
 */
$this->breadcrumbs = array(
	'Учасники'
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

$delete_onclick = "if(confirm('Видалити?')) $('#admin-form').attr('action', '/admin/participants/delete').submit(); return false;";
$order_onclick = "$('#admin-form').attr('action', '/admin/participants/saveorder').submit(); return false;";
?>

<h1 class="main">Публікації</h1>

<?php $this->renderPartial( '/html/submenu', array( 'view' => 'participants' ) ); ?>

<div class="box visible">
<form action="#" method="post" id="admin-form">
	<h1>Учасники</h1>

	<a href="/admin/participants/edit" title="Додати особу"><span class="state add"></span> Додати учасника</a>
	<a href="#" title="Видалити обраних" onclick="<?php echo $delete_onclick ?>"><span class="state delete"></span> Видалити обраних</a>

	<table>
		<thead>
			<tr>
				<th width="20"><input type="checkbox" value="selectAll" /></th>
				<th width="20">&nbsp;</th>
				<th class="tl"><b>Ім'я</b></th>
				<th width="70">Переглядів</th>
				<th width="50">Рейтинг</th>
				<th width="80">Опубліковано</th>
				<th width="60">На головній</th>
				<th width="90">
					Порядок 
					<a href="#" title="Зберегти порядок" onclick="<?php echo $order_onclick ?>"><span class="state saveorder"></span></a>
				</th>
				<th width="110">Дата оновлення</th>
				<th width="20">ID</th>
			</tr>
		</thead>
		<tbody>
		<?php if ( empty( $rows ) ) : ?>
			<tr><td colspan="10" align="center">Немає жодного учасника.</td></tr>
		<?php else : ?>
			<?php foreach ( $rows AS $k => $row ) : ?>
				<?php 
				// Get delete data
				$delete_onclick = "if ( confirm('Видалити?') ) postSend('/admin/participants/delete', { 'items[]': {$row->id} }); return false;";
				// Get edit link
				$link = "/admin/participants/edit?id={$row->id}";
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
				$publish_onclick = "postSend('/admin/participants/edit', { id: {$row->id}, 'Participants[publish]': " . (1 - $row->publish) . " }); return false;";
				// Get frontpage data
				if ( $row->top10 ) 
				{
					$top10_title = 'Забрати з головної';
					$top10_class = 'state featured';
				} 
				else {
					$top10_title = 'Розмістити на головній';
					$top10_class = 'state unfeatured';
				}
				$top10_onclick = "postSend('/admin/participants/edit', { id: {$row->id}, 'Participants[top10]': " . (1 - $row->top10) . " }); return false;";
				// Get order data
				$order_up_onclick = "postSend('/admin/participants/changeorder', { id: {$row->id}, type: 'up' }); return false;";
				$order_down_onclick = "postSend('/admin/participants/changeorder', { id: {$row->id}, type: 'down' }); return false;";
				// Get modified date
				$modified_date = CLocale::getInstance( 'uk' )->dateFormatter->formatDateTime( $row->modified, 'long' );
				?>
			<tr>
				<td>
					<input type="checkbox" name="items[]" value="<?php echo $row->id ?>" />
				</td>
				<td>
					<a href="#" title="Видалити" onclick="<?php echo $delete_onclick ?>"><span class="state delete"></span></a>
				</td>
				<td class="tl">
					<a href="<?php echo $link ?>" title="Редагувати">
						<?php echo CHtml::encode( $row->title ) ?>
					</a>
				</td>
				<td><?php echo $row->views ?></td>
				<td><?php echo $row->rating ?></td>
				<td>
					<a href="#" title="<?php echo $publish_title ?>" onclick="<?php echo $publish_onclick ?>">
						<span class="<?php echo $publish_class ?>"></span>
					</a>
				</td>
				<td>
					<a href="#" title="<?php echo $top10_title ?>" onclick="<?php echo $top10_onclick ?>">
						<span class="<?php echo $top10_class ?>"></span>
					</a>
				</td>
				<td>
					<?php if( $k != 0 ) : ?>
						<a href="#" title="Вверх" onclick="<?php echo $order_up_onclick ?>"><span class="uparrow"></span></a>
					<?php else : ?>
						<span class="uparrow inactive"></span>
					<?php endif; ?>
						
					<?php if ( ( $k + 1 ) != count( $rows ) ) : ?>
						<a href="#" title="Вниз" onclick="<?php echo $order_down_onclick ?>"><span class="downarrow"></a>
					<?php else : ?>
						<span class="downarrow inactive"></span>
					<?php endif; ?>
						
					<input type="text" name="order[<?php echo $row->id ?>]" value="<?php echo $row->ordering ?>" size="3" class="tc" />
				</td>
				<td><?php echo $modified_date ?></td>
				<td><?php echo $row->id ?></a></td>
			</tr>
			<?php endforeach; ?>
		<?php endif; ?>
		</tbody>
	</table>
</form>
</div>
