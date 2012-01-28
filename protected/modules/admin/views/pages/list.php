<?php
/**
 * Pages list layout file
 */
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
            <th width="40">Переглядів</th>
        </tr>
        <?php if ( empty( $rows ) ) : ?>
            <tr><td colspan="5" align="center">Статичних сторінок не знайдено.</td></tr>
        <?php else : ?>
        	<?php foreach ( $rows AS $row ) : ?>
        		<?php
        		// Get edit link
				$link = "/admin/pages/edit?id={$row->id}";
        		// Get modified date
				$modified_date = CLocale::getInstance( 'uk' )->dateFormatter->formatDateTime( $row->modified, 'long' );
        		?>
	        <tr>
	            <!-- <td><input type="checkbox" name="delete[]" value="<?php echo $row->id; ?>" /></td> -->
	            <td style="padding-left: 15px" class="tl">
	            	<a href="<?php echo $link ?>" title="Редагувати">
	            		<?php echo CHtml::encode( $row->title ) ?>
	            	</a>
	            </td>
	            <td><?php echo $row->alias; ?>.html</td>
	            <td><?php echo CHtml::encode( $row->updater->name ) ?></td>
	            <td><?php echo $modified_date ?></td>
	            <td><?php echo $row->views; ?></td>
	        </tr>
	        <?php endforeach; ?>
        <?php endif; ?>
    </table>
</form>