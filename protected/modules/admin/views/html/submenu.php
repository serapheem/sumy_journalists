<?php
/**
 * File with sub menu
 */

?>

<h1 class="main"><?php echo Yii::t( 'main', 'MATERIALS' ) ?></h1>

<?php if ( !empty( $items ) && is_array( $items ) ) : ?>
<ul class="tabs">
	<?php foreach ( $items AS $link => $title ) : ?>
	
	<li <?php if ( $link == $current ) echo 'class="current"'; ?>>
		<a href="/admin/<?php echo $link ?>" class="a_in_tab">
			<?php echo $title ?>
		</a>
	</li>
	
	<?php endforeach; ?>
</ul>
<?php endif; ?>
