<?php
/**
 * Contains controller class of items
 */

/**
 * Items Controller Class
 */
class ItemsController extends AdminAbstractController
{
    /**
     * {@inheritdoc}
     */
    public function accessRules()
    {
        return array(
            array('allow', // allow authenticated users to perform 'view' actions
                'actions' => array('admin', 'create', 'edit', 'validate', 'delete', 'import'),
                'users' => array('@'),
                'expression' => '$user->id == 1',
            ),
            /* array('allow', // allow admin role to perform 'admin', 'update' and 'delete' actions
              'actions'=>array('admin','delete','update'),
              'roles'=>array(User::ROLE_ADMIN),
              ), */
            array('deny', // deny all users
                'users' => array('*'),
            )
        );
    }
    
    /**
     * Import data from different tables
     */
    public function actionImport()
    {
        $table = Yii::app()->request->getParam('table');
        
        if (!$table)
            throw new BadMethodCallException('Table name wasn\'t set!');
        
        $data = array(
            'news' => array('section' => 'News', 'table' => 'news'),
            'citystyle' => array('section' => 'CityStyle', 'table' => 'city_style'),
            'knowour' => array('section' => 'KnowOur', 'table' => 'know_our'),
            'pages' => array('section' => 'Pages', 'table' => 'pages'),
            'tyca' => array('section' => 'Tyca', 'table' => 'tyca'),
            'participants' => array('section' => 'Participants', 'table' => 'participants'),
        );
        
        if (!array_key_exists($table, $data))
            throw new BadMethodCallException('Incorrect name of the table!');
        
        $tableData = $data[$table];
        
        $rows = Yii::app()->db->createCommand()
            ->select('t.*, f.item_id as onfront')
            ->from($tableData['table'] . ' t')
            ->leftJoin('frontpage f', 'f.item_id = t.id AND f.section = \'' . $tableData['section'] . '\'')
            ->queryAll();
        
        if ($rows)
        {
            $catids = Yii::app()->db->createCommand()
                ->select('id')
                ->from('categories')
                ->where('slug=:slug', array('slug' => $table))
                ->queryColumn();
            
            if ($catids && is_array($catids))
            {
                $catid = $catids[0];
            }
            else {
                throw new Exception('Can\'t find category ID!');
            }
            
            foreach ($rows as $row)
            {
                if (in_array($table, array('news', 'citystyle', 'knowour', 'tyca', 'pages')))
                {
                    $insertData = array(
                        'title' => $row['title'], 
                        'slug' => $row['alias'], 
                        'fulltext' => $row['body'], 
                        'catid' => $catid, 
                        'state' => $row['publish'], 
                        'created_at' => $row['created'], 
                        'created_by' => $row['created_by'], 
                        'modified_at' => $row['modified'], 
                        'modified_by' => $row['modified_by'], 
                        'hits' => $row['views'], 
                        'rating' => $row['rating'], 
                        'ordering' => $row['ordering'],
                    );
                }
                elseif ($table == 'pages')
                {
                    $insertData = array(
                        'title' => $row['title'], 
                        'slug' => $row['alias'], 
                        'fulltext' => $row['body'], 
                        'catid' => $catid, 
                        'state' => 1, 
                        'created_at' => $row['created'], 
                        'created_by' => $row['created_by'], 
                        'modified_at' => $row['modified'], 
                        'modified_by' => $row['modified_by'], 
                        'hits' => $row['views'], 
                        'rating' => 0, 
                        'ordering' => 0,
                    );
                }
                elseif ($table == 'participants')
                {
                    $insertData = array(
                        'title' => $row['title'], 
                        'slug' => $row['alias'], 
                        'fulltext' => $row['body'], 
                        'catid' => $catid, 
                        'state' => $row['publish'], 
                        'created_at' => $row['created'], 
                        'created_by' => $row['created_by'], 
                        'modified_at' => $row['modified'], 
                        'modified_by' => $row['modified_by'], 
                        'hits' => $row['views'], 
                        'rating' => $row['rating'], 
                        'ordering' => $row['ordering'],
                    );
                }
                else {
                    throw new BadMethodCallException('Unsupported name of section!');
                }
                Yii::app()->db->createCommand()->insert($this->getId(), $insertData);
                
                $ids = Yii::app()->db->createCommand()
                    ->select('max(id)')
                    ->from($this->getId())
                    ->queryColumn();
                
                $lastId = $ids[0];
                
                Yii::app()->db->createCommand()->insert('items_old', array(
                    'item_id' => $lastId, 
                    'section' => $tableData['section'], 
                    'old_id' => $row['id'], 
                ));
                
                if ($row['onfront'])
                {
                    Yii::app()->db->createCommand()->insert('featured_items', array(
                        'section' => $this->getId(), 
                        'item_id' => $lastId, 
                    ));
                }
            }
        }
        
        var_dump('OK!'); die;
    }

}
