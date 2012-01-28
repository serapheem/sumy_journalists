<?php
/**
 * Poll list layout file
 */
$this->breadcrumbs = array(
    'Голосування'
);
$delete_onclick = "if(confirm('Видалити?')) $('#admin-form').attr('action', '/admin/poll/delete').submit(); return false;";
?>

<h1 class="main">Голосування</h1>

<form action="#" method="post" id="admin-form">
    <a href="/admin/poll/edit" class="add">Додати</a>
    <a href="#" class="delete" onclick="<?php echo $delete_onclick ?>">Видалити обрані</a>
    
    <table style="clear:both">
        <tr>
            <th width="25"><input type="checkbox" value="selectAll" /></th>
            <th width="35">&nbsp;</th>
            <th align="left"><b>Назва</b></th>
            <th width="130" align="center">&nbsp;</th>
            <th width="70" align="center">Опубліковано</th>
            <th width="25" align="center">ID</th>
        </tr>
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
                    $publish_attr = 'title="Відмінити публікацію" class="publish_y"'; 
                } 
                else {
                    $publish_attr = 'title="Опублікувати" class="publish_n"';
                }
				$publish_onclick = "postSend('/admin/poll/edit', { id: {$row->id}, 'Poll[publish]': " . (1 - $row->publish) . " }); return false;";
            	?>
        <tr>
            <td><input type="checkbox" name="items[]" value="<?php echo $row->id; ?>" /></td>
            <td class="tc">
                <a href="#" onclick="<?php echo $delete_onclick ?>" title="Видалити" class="delete"></a>
            </td>
            <td class="tl">
            	<a href="<?php echo $link ?>" title="Редагувати">
            		<?php echo CHtml::encode( $row->name ) ?>
            	</a>
            </td>
            <td><a href="/admin/poll/items?id=<?php echo $row->id; ?>">Редагувати елементи</a></td>
            <td><a href="#" onclick="<?php echo $publish_onclick ?>" <?php echo $publish_attr ?>></a></td>
            <td><?php echo $row->id; ?></a></td>
        </tr>
    	<?php endforeach; ?>
    <?php endif; ?>
    </table>
</form>