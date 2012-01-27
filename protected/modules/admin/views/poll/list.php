<?php
/**
 * Poll list layout file
 */
$this->breadcrumbs = array(
    'Голосування'
);
?>

<h1 class="main">Голосування</h1>

<form action="#" method="post" id="admin-form">
    <a href="/admin/poll/edit" class="add">Додати</a>
    <a href="#" class="delete" 
    	onclick="if(confirm('Видалити?')) $('#admin-form').attr('action', '/admin/poll/delete').submit(); return false;" 
    >Видалити обрані</a>
    
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
    <?php else: ?>
        <?php foreach ( $rows AS $row ) : ?>
        <tr>
            <td><input type="checkbox" name="items[]" value="<?php echo $row->id; ?>" /></td>
            <td class="tc">
                <a href="javascript: postSend('/admin/poll/delete', { 'items[]': <?php echo $row->id; ?> });" 
                	onclick="return confirm('Видалити?');" title="Видалити" class="delete"
                ></a>
            </td>
            <td style="text-align: left">
            	<a href="/admin/poll/edit?id=<?php echo $row->id; ?>" title="Редагувати">
            		<?php echo $row->name; ?>
            	</a>
            </td>
            <td><a href="/admin/poll/items?id=<?php echo $row->id; ?>">Редагувати елементи</a></td>
            <?php 
            if ( $row->publish ) 
            {
                $title = 'title="Відмінити публікацію"';
                $class = 'class="publish_y"'; 
            } 
            else {
                $title = 'title="Опублікувати"';
                $class = 'class="publish_n"';
            }
            ?>
            <td><a href="javascript: postSend('/admin/poll/edit', { id: <?php echo $row->id; ?>, 'Poll[publish]' : <?php echo (1 - $row->publish); ?> });" 
            	<?php echo $title; ?> <?php echo $class; ?>
            ></a></td>
            <td><?php echo $row->id; ?></a></td>
        </tr>
    	<?php endforeach; ?>
    <?php endif; ?>
    </table>
</form>