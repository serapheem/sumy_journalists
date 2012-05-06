<?php
/**
 * Layout file for GACounter Widget
 */

if ( !isset( $week ) || !isset( $today ) || !isset( $month ) ) : ?>
	<?php echo Yii::t( 'gacounter', 'NO_DATA' ); ?>
<?php else : ?>
	<?php echo Yii::t( 'gacounter', 'TODAY' ) . ': ' . $today; ?><br />
	<?php echo Yii::t( 'gacounter', 'WEEK' ) . ': ' . $week; ?><br />
	<?php echo Yii::t( 'gacounter', 'MONTH' ) . ': ' . $month; ?><br />
<?php endif; ?>