<?php
/*
 * Template for single item in the list
 */

$sectionId = $this->getId();

$articleId = $data->id . (empty($data->slug) ? '' : ':' . $data->slug);
$link = Yii::app()->createAbsoluteUrl('/' . $sectionId . '/' . $articleId);

$image = ContentHelper::getThumb($data);
$intro = ContentHelper::getIntroText($data); 
?>

<div class="articlesBox">
    <div class="articlesImg"><a href="<?php echo $link; ?>">
        <img src="<?php echo $image; ?>" title="<?php echo CHtml::encode($data->title); ?>" />
    </a></div>
    <div class="articlesText" >
        <h4><a href="<?php echo $link ?>"><?php echo CHtml::encode($data->title) ?></a></h4>
        <div>
            <p style="font-size:10px;"><?php //echo $row->date; ?></p>
            <p><?php echo $intro; ?></p>
            <a href="<?php echo $link; ?>" class="readMore"><?php echo Yii::t('main', 'READ_MORE'); ?>...</a>
        </div>
    </div>
    <div class="clear"></div>
</div>