<?php
/**
 * Contains abstract model for admin module
 */
/**
 * Admin Abstract Model class
 */
abstract class AdminAbstractModel extends CActiveRecord
{
    /**
     * @param int $parentId Identifier of the parent category
     * @return array The list of categories for filter
     */
    public function getCatidFilterValues($parentId = null)
    {
        $attrs = array('state' => 1);
        if ($parentId)
        {
            $attrs['parent_id'] = $parentId;
        }
        $items = Categories::model()->findAllByAttributes($attrs);
        
        $result = array();
        foreach ($items as $item)
        {
            $result[$item->primaryKey] = $item->title;
        }
        return $result;
    }

    /**
     * @return array The list of possible state values for filter
     */
    public function getStateFilterValues()
    {
        return array(
            'prompt' => Yii::t('main', 'admin.list.filter.state.select'),
            1 => Yii::t('main', 'admin.list.filter.state.published'), 
            0 => Yii::t('main', 'admin.list.filter.state.unpublished')
        );
    }

    /**
     * @return array The list of possible state values
     */
    public function getStateValues()
    {
        return array(
            1 => Yii::t('main', 'admin.list.label.published'), 
            0 => Yii::t('main', 'admin.list.label.unpublished')
        );
    }

}
