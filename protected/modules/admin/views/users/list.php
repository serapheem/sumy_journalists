<?php
$this->breadcrumbs = array(
    'Користувачі'
);
$delete_onclick = "if(confirm('Видалити?')) $('#admin-form').attr('action', '/admin/users/delete').submit(); return false;";
?>

<h1 class="main">Користувачі</h1>
<form action="#" method="post" id="admin-form">
    <a href="/admin/users/add" class="add">Додати</a>
    <a href="#" onclick="<?php echo $delete_onclick ?>" class="delete">Видалити обраних</a>
    
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
    	<?php 
    	// Get delete data
    	$delete_onclick = "if ( confirm('Видалити?') ) postSend('/admin/users/delete', { 'items[]': {$row->id} }); return false;";
		// Get edit link
		$link = "/admin/users/edit?id={$row->id}";
		// Get modified date
		$lasttime = CLocale::getInstance( 'uk' )->dateFormatter->formatDateTime( $row->lasttime, 'long' );
    	?>
        <tr>
            <td><?php if ($row->id != 1): ?><input type="checkbox" name="items[]" value="<?php echo $row->id; ?>" /><?php endif; ?></td>
            <td>
                <?php if ($row->id != 1): ?>
                    <a href="#" onclick="<?php echo $delete_onclick ?>" title="Видалити" class="delete"></a>
                <?php else: ?>
                	<span class="space"></span>
                <?php endif; ?>
            </td>
            <td style="padding-left: 15px" class="tl">
            	<?php if ( $row->id != 1 ) : ?>
            	<a href="<?php echo $link ?>" title="Редагувати">
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
            <td><?php echo $row->id ?></a></td>
        </tr>
    <?php endforeach; ?>
    </table>
</form>