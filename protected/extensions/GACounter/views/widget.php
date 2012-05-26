<?php
/**
 * Layout file for GACounter Widget
 */

if ( !isset( $week ) || !isset( $today ) || !isset( $month ) ) : ?>
	<?php echo Yii::t( 'gacounter', 'NO_DATA' ); ?>
<?php else : ?>
	<div style="float: left; padding-left: 20px;">
		<span<?php /* title="<?php echo Yii::t( 'gacounter', 'TODAY' ); ?>"*/ ?>><?php echo $today; ?></span><br />
		<span<?php /* title="<?php echo Yii::t( 'gacounter', 'WEEK' ); ?>"*/ ?>><?php echo $week; ?></span><br />
		<span<?php /* title="<?php echo Yii::t( 'gacounter', 'MONTH' ); ?>"*/ ?>><?php echo $month; ?></span>
	</div>
<?php endif; ?>