<?php
$this->breadcrumbs = array(
	Yii::t( 'main', 'ERROR' )
);
?>

<h1><?php echo Yii::t( 'main', 'ERROR' ) . ' ' . $code ?></h1>
<p class="error"><?php echo CHtml::encode( $message ) ?></p>