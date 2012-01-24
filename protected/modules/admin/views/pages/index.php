<?php
$this->breadcrumbs = array(
    'Статичні сторінки'
);
?>

<h1 class="main">Статичні сторінки</h1>
<form action="/admin/pages/delete" method="post">
    <!-- <a href="/admin/pages/edit" class="add">Додати сторінку</a>
    <a href="#" onclick="if(confirm('Упевнені?')) this.parentNode.submit(); return false;" class="delete">Видалити обрані</a> -->
    <table style="clear:both">
        <tr>
            <!-- <th><input type="checkbox" value="selectAll" /></th>
            <th width="5%">&nbsp;</th> -->
            <th class="tl" style="padding-left: 15px">Назва</th>
            <th width="100">Посилання</th>
            <th width="60">Редагував</th>
            <th width="110">Час редагування</th>
            <!-- <th width="40">Переглядів</th> -->
        </tr>
    <?php if (sizeof($rows)): 
        foreach ($rows as $row): ?>
        <tr>
            <!-- <td><input type="checkbox" name="delete[]" value="<?php echo $row->id; ?>" /></td> -->
            <td style="padding-left: 15px"class="tl">
            	<a href="javascript: postSend('/admin/pages/edit', { id: <?php echo $row->id; ?> });" title="Редагувати">
            		<?php echo $row->title; ?>
            	</a>
            </td>
            <td><?php echo $row->seo; ?>.html</td>
            <td><?php echo $row->author; ?></td>
            <td><?php echo CLocale::getInstance('uk')->dateFormatter->formatDateTime($row->lasttime, 'long'); ?></td>
            <!-- <td class="tc"><?php //echo $row->views; ?></td> -->
        </tr>
    <?php endforeach;
    else: ?>
        <tr><td colspan="7">Статичних сторінок не знайдено</td></tr>
    <?php endif; ?>
    </table>
</form>