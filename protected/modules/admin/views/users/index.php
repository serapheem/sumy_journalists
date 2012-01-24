<?php
$this->breadcrumbs = array(
    'Користувачі'
);
?>

<h1 class="main">Користувачі</h1>
<form action="/admin/users/delete" method="post">
    <a href="/admin/users/add" class="add">Додати</a>
    <a href="#" onclick="if(confirm('Видалити?')) this.parentNode.submit(); return false;" class="delete">Видалити обраних</a>
    <table style="clear:both">
        <tr>
            <th width="25"><input type="checkbox" value="selectAll" /></th>
            <th width="35">&nbsp;</th>
            <th class="tl" style="padding-left: 15px">Ім'я</th>
            <th width="150" class="tl" style="padding-left: 15px">Логін</th>
            <th width="150">Пошта</th>
            <th width="120">Був в адмін-панелі</th>
            <th width="100">Останній IP</th>
            <th width="30">ID</th>
        </tr>
    <?php foreach ($rows as $row): ?>
        <tr>
            <td><?php if ($row->id != 1): ?><input type="checkbox" name="delete[]" value="<?php echo $row->id; ?>" /><?php endif; ?></td>
            <td class="tc">
                <?php if ($row->id != 1): ?>
                    <a href="javascript: postSend('/admin/users/delete', { 'delete[]': <?php echo $row->id; ?> });" onclick="return confirm('Видалити?');" title="Видалити" class="delete"></a>
                <?php else: ?>
                	<span class="space"></span>
                <?php endif; ?>
            </td>
            <td style="padding-left: 15px" class="tl">
            	<?php if ($row->id != 1): ?>
            	<a href="javascript: postSend('/admin/users/edit', { id: <?php echo $row->id; ?> });" title="Редагувати">
            		<?php echo $row->name; ?>
            	</a>
            	<?php 
            	else:
                	echo $row->name;
                endif; ?>
            </td>
            <td class="tl" style="padding-left: 15px"><?php echo $row->username; ?></td>
            <td><?php echo $row->email; ?></td>
            <td><?php echo CLocale::getInstance('uk')->dateFormatter->formatDateTime($row->lasttime, 'long'); ?></td>
            <td><?php echo $row->ip; ?></td>
            <td><?php echo $row->id; ?></a></td>
        </tr>
    <?php endforeach; ?>
    </table>
</form>