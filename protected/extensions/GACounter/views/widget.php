<?php
/**
 * Layout file for GACounter Widget
 */

?>
<div>
	<?php if ( !isset( $week ) || !isset( $today ) || !isset( $month ) ) : ?>
		<?php echo Yii::t( 'gacounter', 'NO_DATA' ); ?>
	<?php else : ?>
		<p<?php /* title="<?php echo Yii::t( 'gacounter', 'TODAY' ); ?>"*/ ?>><?php echo $today; ?></p>
		<p<?php /* title="<?php echo Yii::t( 'gacounter', 'WEEK' ); ?>"*/ ?>><?php echo $week; ?></p>
		<p<?php /* title="<?php echo Yii::t( 'gacounter', 'MONTH' ); ?>"*/ ?>><?php echo $month; ?></p>
	<?php endif; ?>
</div>