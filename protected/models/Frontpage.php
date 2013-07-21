<?php
/**
 * Contains FrontPage model class
 *
 * @author      Serhiy Hlushko <serhiy.hlushko@gmail.com>
 * @copyright   Copyright 2013 Hlushko inc.
 * @company     Hlushko inc.
 */

/**
 * Manages items which will be rendered on Front page
 */
class FrontPage extends SiteModel
{
    /**
     * {@inheritdoc}
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * {@inheritdoc}
     */
    public function tableName()
    {
        return '{{featured_item}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array(
            array('section, item_id', 'required'),
            array('section', 'length', 'max' => 64),
            array('item_id, ordering', 'numerical', 'integerOnly' => true),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function scopes()
    {
        return array(
            'ordering' => array('order' => 'ordering ASC'),
        );
    }

//    /**
//     * Returns the list of items on front page
//     *
//     * @return array of items
//     */
//    public function getList()
//    {
//        // Get published news
//        $command = Yii::app()->db->createCommand();
//
//        $fields = array('f.*');
//        $fields_name = array('title', 'alias', 'body', 'created', 'modified', 'ordering' => 'item_ordering');
//
//        // Get fields from other tables
//        foreach ($fields_name as $index => $name) {
//            if (is_numeric($index)) {
//                $index = $name;
//            }
//
//            $fields[] = "CASE f.section"
//                . " WHEN 'KnowOur' THEN (SELECT ko.{$index} FROM know_our AS ko WHERE ko.id = f.item_id )"
//                . " WHEN 'News' THEN (SELECT n.{$index} FROM news AS n WHERE n.id = f.item_id )"
//                . " ELSE null"
//                . " END AS '{$name}'";
//        }
//
//        $rows = $command->selectDistinct($fields)
//            ->from('frontpage AS f')
//            ->order('f.ordering ASC, modified DESC')
//            ->queryAll();
//
//        foreach ($rows as &$row) {
//            $row = (object) $row;
//        }
//
//        return $rows;
//    }

}