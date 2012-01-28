<?php
/**
 * News list layout file
 */
$this->breadcrumbs = array(
    'Новини'
);
$delete_onclick = "if(confirm('Видалити?')) $('#admin-form').attr('action', '/admin/news/delete').submit(); return false;";
$order_onclick = "$('#admin-form').attr('action', '/admin/news/saveorder').submit(); return false;";
?>

<h1 class="main">Публікації</h1>

<?php $this->renderPartial( '/html/submenu', array( 'view' => 'news' ) ); ?>

<div class="box visible">
<form action="#" method="post" id="admin-form">
    <h1>Новини</h1>

    <a href="/admin/news/edit" title="Додати новину" class="add">Додати новину</a>
    <a href="#" class="delete" onclick="<?php echo $delete_onclick ?>" >Видалити обрані</a>

    <table>
        <tr>
            <th width="20"><input type="checkbox" value="selectAll" /></th>
            <th width="20">&nbsp;</th>
            <th class="tl"><b>Назва</b></th>
            <th width="70">Переглядів</th>
            <th width="50">Рейтинг</th>
            <th width="80">Опубліковано</th>
            <th width="60">На головній</th>
            <th width="90">Порядок <a href="#" class="save-order" onclick="<?php echo $order_onclick ?>"></a></th>
            <th width="110">Дата оновлення</th>
            <th width="20">ID</th>
        </tr>
        <?php if ( empty( $rows ) ) : ?>
            <tr><td colspan="10" align="center">Немає жодної новини.</td></tr>
        <?php else : ?>
            <?php foreach ( $rows AS $k => $row ) : ?>
            	<?php 
            	// Get delete data
            	$delete_onclick = "if ( confirm('Видалити?') ) postSend('/admin/news/delete', { 'items[]': {$row->id} }); return false;";
				// Get edit link
				$link = "/admin/news/edit?id={$row->id}";
            	// Get publish data
            	if ($row->publish) 
                {
                    $publish_attr = 'title="Відмінити публікацію" class="publish_y"'; 
                } 
                else {
                    $publish_attr = 'title="Опублікувати" class="publish_n"';
                }
				$publish_onclick = "postSend('/admin/news/edit', { id: {$row->id}, 'News[publish]': " . (1 - $row->publish) . " }); return false;";
				// Get frontpage data
				if ( !empty( $row->frontpage->item_id ) && ( $row->id == $row->frontpage->item_id ) ) 
                {
                    $frontpage_attr = 'title="Забрати з головної" class="front_y"'; 
					$value = 0;
                } 
                else {
                    $frontpage_attr = 'title="Розмістити на головній" class="front_n"';
					$value = 1;
                }
				$frontpage_onclick = "postSend('/admin/news/edit', { id: {$row->id}, 'News[frontpage]': {$value} }); return false;";
				// Get order data
				$order_up_onclick = "postSend('/admin/news/changeorder', { id: {$row->id}, type: 'up' }); return false;";
				$order_down_onclick = "postSend('/admin/news/changeorder', { id: {$row->id}, type: 'down' }); return false;";
				// Get modified date
				$modified_date = CLocale::getInstance( 'uk' )->dateFormatter->formatDateTime( $row->modified, 'long' );
            	?>
        <tr>
            <td><input type="checkbox" name="items[]" value="<?php echo $row->id; ?>" /></td>
            <td>
                <a href="#" onclick="<?php echo $delete_onclick ?>" title="Видалити" class="delete"></a>
            </td>
            <td class="tl">
            	<a href="<?php echo $link ?>" title="Редагувати">
            		<?php echo CHtml::encode( $row->title ) ?>
            	</a>
            </td>
            <td><?php echo $row->views ?></td>
            <td><?php echo $row->rating ?></td>
            <td>
            	<a href="#" onclick="<?php echo $publish_onclick ?>" <?php echo $publish_attr ?>></a>
            </td>
            <td>
            	<a href="#" onclick="<?php echo $frontpage_onclick ?>" <?php echo $frontpage_attr ?>></a>
            </td>
            <td>
                <?php if( $k != 0 ) : ?>
                    <a href="#" onclick="<?php $order_up_onclick ?>" class="order-up" title="Вверх"></a>
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
            <td><?php echo $modified_date ?></td>
            <td><?php echo $row->id ?></a></td>
        </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
</form>
</div>
