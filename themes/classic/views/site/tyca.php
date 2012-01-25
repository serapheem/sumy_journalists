<?php 
$link = '/tyca/' . $record->id;
$link = Yii::app( )
	->createAbsoluteUrl( $link );
?>
<div id="contentText">
    <h1><?php echo $record->title; ?></h1>
    <span class="note">Опубліковано: <?php echo CLocale::getInstance('uk')->dateFormatter->formatDateTime($record->created, 'long', null); ?></span>
    <br />
    <br />
    <div class="content-desc">
    	<?php echo $record->body; ?>
    </div>
</div>
<div id="contentFoot">
    <?php echo Helper::getRatingButtons('Tyca', $record) ?>
    
    <?php echo Helper::getSocialButtons( $link ) ?>
</div>
<?php echo Helper::getCommentsBlock( $link ) ?>