<?php 
$created = CLocale::getInstance( 'uk' )
	->dateFormatter
	->formatDateTime( $record->created, 'long', null );
?>
<div id="contentText">
    <h1><?php echo CHtml::encode( $record->title ) ?></h1>
    <span class="note"><?php echo Yii::t( 'main', 'VIEWS' ) ?>: <?php echo $record->views; ?></span>
    <span class="note"><?php echo Yii::t( 'main', 'PUBLISHED' ) ?>: <?php echo $created ?></span>
    <br />
    <br />
    <div class="content-desc">
    	<?php echo $record->body; ?>
    </div>
</div>
<div id="contentFoot">
    <?php echo Helper::getRatingButtons( 'Tyca', $record ) ?>
    
    <?php echo Helper::getSocialButtons( 'Tyca', $record ) ?>
</div>
<?php echo Helper::getCommentsBlock( 'Tyca', $record ) ?>