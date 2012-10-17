<?php
/**
 * GridHelper class file.
 */

/**
 * GridHelper is a static class that provides a collection of helper methods for creating items for Grid.
 * @static
 */
class GridHelper
{
    /**
     * Generates the label for link of item state
     * @return string
     */
    public static function getStateLabel($state = 0)
    {
        $class = 'state';
        if ($state)
            $class .= ' publish';
        else
            $class .= ' unpublish';

        return '<span class="' . $class . '">&nbsp;</span>';
    }
    
    /**
     * Generates the label for link of item featured
     * @return string
     */
    public static function getFeaturedLabel($featured = 0)
    {
        $class = 'state';
        if ($featured)
            $class .= ' featured';
        else
            $class .= ' unfeatured';

        return '<span class="' . $class . '">&nbsp;</span>';
    }

}
