<?php 
$link = '/news/' . $news->id;
$link = Yii::app( )
	->createAbsoluteUrl( $link );
$created = CLocale::getInstance( 'uk' )
	->dateFormatter
	->formatDateTime( $news->created, 'long', null );
?>
<div id="contentText">
    <h1><?php echo CHtml::encode( $news->title ) ?></h1>
    <?php /* ?><span class="note">Переглядів: <?php echo $news->views; ?></span><?php */ ?>
    <span class="note"><?php echo Yii::t( 'main', 'PUBLISHED' ) ?>: <?php echo $created ?></span>
    <br />
    <br />
    <div class="content-desc">
        <?php echo $news->body; ?>
    </div>
</div>
<div id="contentFoot">
    <?php echo Helper::getRatingButtons( 'News', $news ) ?>
    
    <?php echo Helper::getSocialButtons( $link ) ?>
</div>
<?php echo Helper::getCommentsBlock( $link ) ?>
