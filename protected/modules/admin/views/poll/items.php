<?php
/**
 * Poll items layout file
 */
$this->breadcrumbs = array(
    'Голосування' => '/admin/poll',
    'Варіанти голосування: ' . $poll->name
);
?>

<h1 class="main">Варіанти голосування: <?php echo $poll->name; ?></h1>

<form action="#" method="post" id="admin-form">
    
    <a href="/admin/poll/itemedit?poll_id=<?php echo $poll->id; ?>" class="add">Додати</a>
    <a href="#" class="delete" 
    	onclick="if(confirm('Видалити?')) $('#admin-form').attr('action', '/admin/poll/itemdelete').submit(); return false;" 
    >Видалити обрані</a>
    
    <table style="clear:both">
        <tr>
            <th width="25"><input type="checkbox" value="selectAll" /></th>
            <th width="35">&nbsp;</th>
            <th align="left"><b>Назва</b></th>
            <th width="100">
            	Порядок 
            	<a href="#" onclick="$('#admin-form').attr('action', '/admin/poll/saveitemorder').submit();" class="save-order"></a></th>
            <th width="90" align="center">Кількість голосів</th>
            <th width="30" align="center">ID</th>
        </tr>
    <?php if ( empty( $rows ) ) : ?>
        <tr><td colspan="6" align="center">Немає жодного варіанту.</td></tr>
    <?php else : ?>
        <?php foreach ( $rows AS $k => $row ) : ?>
        <tr>
            <td><input type="checkbox" name="items[]" value="<?php echo $row->id; ?>" /></td>
            <td class="tc">
                <a href="javascript: postSend('/admin/poll/itemdelete', { poll_id : <?php echo $poll->id; ?>, 'items[]': <?php echo $row->id; ?> });" 
                	onclick="return confirm('Видалити?');" title="Видалити" class="delete"
                ></a>
            </td>
            <td style="text-align: left">
            	<a href="/admin/poll/itemedit?poll_id=<?php echo $poll->id; ?>&amp;id=<?php echo $row->id; ?>" title="Редагувати">
            		<?php echo $row->name; ?></a>
            	</td>
            <td>
                <?php if ( $k != 0 ) : ?>
                    <a href="javascript: postSend('/admin/poll/changeitemorder', { id: <?php echo $row->id; ?>, type: 'up', poll_id: <?php echo $poll->id; ?> });" 
                    	class="order-up" title="Вверх"
                    ></a>
                <?php else : ?>
                    <span class="space"></span>
                <?php endif; ?>
                    
                <?php if ( ( $k + 1 ) != count( $rows ) ) : ?>
                    <a href="javascript: postSend('/admin/poll/changeitemorder', { id: <?php echo $row->id; ?>, type: 'down', poll_id: <?php echo $poll->id; ?> });" 
                    	class="order-down" title="Вниз"
                    ></a>
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
    </table>
    <input type="hidden" name="model" value="PollItems" />
    <input type="hidden" name="poll_id" value="<?php echo $poll->id; ?>" />
</form>