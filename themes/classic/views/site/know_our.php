<?php 
$link = '/knowour/' . $record->id;
$link = Yii::app( )
	->createAbsoluteUrl( $link );
$created = CLocale::getInstance( 'uk' )
	->dateFormatter
	->formatDateTime( $record->created, 'long', null );
?>
<div id="contentText">
    <h1><?php echo CHtml::encode( $record->title ) ?></h1>
    <span class="note">Опубліковано: <?php echo $created ?></span>
    <br />
    <br />
    <div class="content-desc">
    	<?php echo $record->body; ?>
    </div>
</div>
<div id="contentFoot">
    <?php echo Helper::getRatingButtons( 'KnowOur', $record ) ?>
    
    <?php echo Helper::getSocialButtons( $link ) ?>
</div>
<?php echo Helper::getCommentsBlock( $link ) ?>