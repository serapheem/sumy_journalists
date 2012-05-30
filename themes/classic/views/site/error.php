<?php
/**
 * Error page layout
 */

?>

<div class="article-title"><?php echo Yii::t( 'main', 'ERROR' ) ?> <?php echo $code; ?></div>
<div class="article-text">
    <?php echo CHtml::encode($message); ?>
</div>