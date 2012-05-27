<?php 
/**
 * News article layout
 */

$created = CLocale::getInstance( 'uk' )->dateFormatter->formatDateTime( $record->created, 'long', null );
?>

<div class="article-title">
	<?php echo CHtml::encode( $record->title ); ?>
</div>
<div class="article-info">
	<div class="note"><?php echo Yii::t( 'main', 'PUBLISHED' ); ?>: <?php echo $created; ?></div>
    <div class="note"><?php echo Yii::t( 'main', 'VIEWS' ); ?>: <?php echo $record->views; ?></div>
    <div class="clear"></div>
</div>
<div class="article-text">
    <?php echo $record->body; ?>
</div>
<div class="article-footer">
	<?php echo Helper::getRatingButtons( 'News', $record ) ?>
    
    <?php echo Helper::getSocialButtons( 'News', $record ) ?>
    
    <div class="clear"></div>
</div>
<?php $this->widget( 'application.extensions.SocialComments.SocialCommentsWidget', array( 'section' => 'News', 'item' => $record ) ); ?>
