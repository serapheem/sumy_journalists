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
    <?php echo Helper::getRatingButtons( 'News', $record ) ?>
    
    <?php echo Helper::getSocialButtons( 'News', $record ) ?>
</div>
<?php echo Helper::getCommentsBlock( 'News', $record ) ?>
