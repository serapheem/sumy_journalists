<?php
/**
 * City Style list layout file
 */
$this->breadcrumbs = array(
    'City - стиль'
);
?>

<h1 class="main">Публікації</h1>

<?php $this->renderPartial( '/html/submenu', array( 'view' => 'citystyle' ) ); ?>

<div class="box visible">
<form action="#" method="post" id="admin-form">
    <h1>City - стиль</h1>

    <a href="/admin/citystyle/edit" title="Додати статтю" class="add">Додати статтю</a>
    <a href="#" class="delete" 
    	onclick="if(confirm('Видалити?')) $('#admin-form').attr('action', '/admin/citystyle/delete').submit(); return false;" 
    >Видалити обрані</a>

    <table>
        <tr>
            <th width="20"><input type="checkbox" value="selectAll" /></th>
            <th width="20">&nbsp;</th>
            <th class="tl"><b>Назва</b></th>
            <th width="70">Переглядів</th>
            <th width="50">Рейтинг</th>
            <th width="80">Опубліковано</th>
            <th width="90">
            	Порядок 
            	<a href="#" class="save-order" onclick="$('#admin-form').attr('action', '/admin/citystyle/saveorder').submit();"></a></th>
            <th width="110">Дата оновлення</th>
            <th width="20">ID</th>
        </tr>
        <?php if ( empty( $rows ) ) : ?>
            <tr><td colspan="7" align="center">Немає жодної статті.</td></tr>
        <?php else : ?>
            <?php foreach ( $rows AS $k => $row ) : ?>
        <tr>
            <td><input type="checkbox" name="items[]" value="<?php echo $row->id; ?>" /></td>
            <td>
                <a href="javascript: postSend('/admin/citystyle/delete', { 'items[]': <?php echo $row->id; ?> });" 
                	onclick="return confirm('Видалити?');" title="Видалити" class="delete"
                ></a>
            </td>
            <td class="tl">
            	<a href="/admin/citystyle/edit?id=<?php echo $row->id; ?>" title="Редагувати">
            		<?php echo $row->title; ?>
            	</a>
            </td>
            <td><?php echo $row->views ?></td>
            <td><?php echo $row->rating ?></td>
            <?php 
                if ($row->publish) 
                {
                    $title = 'title="Відмінити публікацію"';
                    $class = 'class="publish_y"'; 
                } 
                else {
                    $title = 'title="Опублікувати"';
                    $class = 'class="publish_n"';
                }
            ?>
            <td>
            	<a href="javascript: postSend('/admin/citystyle/edit', { id: <?php echo $row->id; ?>, 'CityStyle[publish]': <?php echo (1 - $row->publish); ?> });" 
            		<?php echo $title; ?> <?php echo $class; ?>
            	></a>
            </td>
            <td>
                <?php if ( $k != 0 ) : ?>
                    <a href="javascript: postSend('/admin/citystyle/changeorder', { id: <?php echo $row->id; ?>, type: 'up' });" 
                    	class="order-up" title="Вверх"
                    ></a>
                <?php else: ?>
                    <span class="space"></span>
                <?php endif; ?>
                    
                <?php if ( ( $k + 1 ) != count( $rows ) ) : ?>
                    <a href="javascript: postSend('/admin/citystyle/changeorder', { id: <?php echo $row->id; ?>, type: 'down' });" 
                    	class="order-down" title="Вниз"
                    ></a>
                <?php else: ?>
                    <span class="space"></span>
                <?php endif; ?>
                    
                <input type="text" name="order[<?php echo $row->id; ?>]" value="<?php echo $row->ordering;?>" size="3" class="tc" />
            </td>
            <td><?php echo CLocale::getInstance('uk')->dateFormatter->formatDateTime($row->modified, 'long'); ?></td>
            <td><?php echo $row->id; ?></a></td>
        </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
</form>
