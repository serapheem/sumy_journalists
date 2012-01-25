<?php 
$link = '/news/' . $news->id;
$link = Yii::app( )
	->createAbsoluteUrl( $link );
?>
<div id="contentText">
    <h1><?php echo $news->title; ?></h1>
    <?php /* ?><span class="note">Переглядів: <?php echo $news->views; ?></span><?php */ ?>
    <span class="note">Опубліковано: <?php echo CLocale::getInstance('uk')->dateFormatter->formatDateTime($news->created, 'long', null); ?></span>
    <br />
    <br />
    <div class="content-desc">
        <?php echo $news->body; ?>
    </div>
</div>
<div id="contentFoot">
    <?php echo Helper::getRatingButtons('News', $news) ?>
    
    <?php echo Helper::getSocialButtons( $link ) ?>
</div>
<?php echo Helper::getCommentsBlock( $link ) ?>
