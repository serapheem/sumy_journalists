<?php
$this->breadcrumbs = array(
    'Голосування'
);
?>

<h1 class="main">Голосування</h1>
<form action="/admin/poll/delete" method="post">
    <a href="/admin/poll/edit" class="add">Додати</a>
    <a href="#" onclick="if(confirm('Видалити?')) this.parentNode.submit(); return false;" class="delete">Видалити обрані</a>
    <table style="clear:both">
        <tr>
            <th width="25"><input type="checkbox" value="selectAll" /></th>
            <th width="35">&nbsp;</th>
            <th align="left"><b>Назва</b></th>
            <th width="130" align="center">&nbsp;</th>
            <th width="70" align="center">Опубліковано</th>
            <th width="25" align="center">ID</th>
        </tr>
    <?php if (empty($rows)): ?>
        <tr><td colspan="6" align="center">Немає жодного голосування.</td></tr>
    <?php else:
        foreach ($rows as $row): ?>
        <tr>
            <td><input type="checkbox" name="delete[]" value="<?php echo $row->id; ?>" /></td>
            <td class="tc">
                <a href="javascript: postSend('/admin/poll/delete', { 'delete[]': <?php echo $row->id; ?> });" onclick="return confirm('Видалити?');" title="Видалити" class="delete"></a>
            </td>
            <td style="text-align: left">
            	<a href="javascript: postSend('/admin/poll/edit', { id: <?php echo $row->id; ?> });" title="Редагувати">
            		<?php echo $row->name; ?>
            	</a>
            </td>
            <td><a href="/admin/poll/items/poll-id/<?php echo $row->id; ?>">Редагувати елементи</a></td>
            <?php 
                if ($row->publish) {
                    $title = 'title="Відмінити публікацію"';
                    $class = 'class="publish_y"'; 
                } else {
                    $title = 'title="Опублікувати"';
                    $class = 'class="publish_n"';
                }
            ?>
            <td><a href="javascript: postSend('/admin/poll/publish', { id: <?php echo $row->id; ?>, publish: <?php echo $row->publish; ?> });" <?php echo $title; ?> <?php echo $class; ?>></a></td>
            <td><?php echo $row->id; ?></a></td>
        </tr>
    <?php endforeach; 
        endif;  ?>
    </table>
</form>