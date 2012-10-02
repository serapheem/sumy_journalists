<?php
/**
 * Pages list layout file
 */
$model_name = strtolower( $this->model );

$this->breadcrumbs = array(
	Yii::t( $model_name, 'SECTION_NAME' )
);
?>

<h1 class="main"><?php echo Yii::t( $model_name, 'SECTION_NAME' ) ?></h1>
<form action="/admin/pages/delete" method="post">
	<!-- <a href="/admin/pages/edit" class="add">Додати сторінку</a>
	<a href="#" onclick="if(confirm('Упевнені?')) this.parentNode.submit(); return false;" class="delete">Видалити обрані</a> -->
	<table>
		<thead>
			<tr>
				<!-- <th><input type="checkbox" value="selectAll" /></th>
				<th width="5%">&nbsp;</th> -->
				<th class="tl" style="padding-left: 15px"><?php echo Yii::t( 'main', 'TITLE' ) ?></th>
				<th width="100"><?php echo Yii::t( 'main', 'ALIAS' ) ?></th>
				<th width="60"><?php echo Yii::t( 'main', 'EDITED' ) ?></th>
				<th width="110"><?php echo Yii::t( 'main', 'LAST_UPDATED' ) ?></th>
				<th width="40"><?php echo Yii::t( 'main', 'VIEWS' ) ?></th>
			</tr>
		</thead>
		<tbody>
		<?php if ( empty( $rows ) ) : ?>
			<tr><td colspan="5" class="tc"><?php echo Yii::t( $model_name, 'NO_ITEMS' ) ?></td></tr>
		<?php else : ?>
			<?php foreach ( $rows AS $row ) : ?>
				<?php
				// Get edit link
				$link = "/admin/{$model_name}/edit?id={$row->id}";
				// Get modified date
				$modified_date = CLocale::getInstance( 'uk' )->dateFormatter->formatDateTime( $row->modified, 'long' );
				?>
			<tr>
				<!-- <td><input type="checkbox" name="delete[]" value="<?php echo $row->id; ?>" /></td> -->
				<td style="padding-left: 15px" class="tl">
					<a href="<?php echo $link ?>" title="<?php echo Yii::t( 'main', 'EDIT' ) ?>">
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
		</tbody>
	</table>
</form>