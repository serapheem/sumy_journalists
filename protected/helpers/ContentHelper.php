<?php
/*
 * File for ContentHelper class
 */

/**
 * Class which contains logic work with content of website
 * 
 * @static
 */
class ContentHelper
{
    /**
     * Returns thumb image for given article
     * 
     * @param AbstractModel $item Information of the atricle
     * 
     * @return string Link for thumb image
     */
    public static function getThumb(AbstractModel $item)
    {
        $default = Yii::app()->theme->baseUrl . '/images/no_image_small.png';
        
        // Get image of article
        // TODO : change it
        $image = null; Helper::getThumbImage($item->fulltext);
        $image = Yii::app()->createAbsoluteUrl(empty($image) ? $default : $image);
        
        return $image;
    }
    
    /**
     * Returns intro text for given article
     * 
     * @param AbstractModel $item Information of the article
     * 
     * @return string Intro text
     */
    public static function getIntroText(AbstractModel $item)
    {
        $charsMaxNumber = 300;
        
        $intro = strip_tags($item->fulltext);
        $intro = wordwrap($intro, $charsMaxNumber, '`|+');
        $wrap_pos = strpos($intro, '`|+');
        if ($wrap_pos !== false) 
        {
            $intro = substr($intro, 0, $wrap_pos) . '...';
        } 

        return $intro;
    }

}
