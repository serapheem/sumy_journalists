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
                'actions' => array('admin', 'create', 'edit', 'validate', 'delete'),
                'users' => array('@'),
            ),
            array('allow', // allow authenticated users to perform 'view' actions
                'actions' => array('import'),
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
            throw new BadFunctionCallException('Table name wasn\'t set!');
        
        $rows = Yii::app()->db->createCommand()
            ->select('t.*, f.item_id as onfront')
            ->from($table . ' t')
            ->leftJoin('frontpage f', 'f.item_id = t.id AND f.section = \'' . ucfirst($table) . '\'')
            ->queryAll();
        
        if ($rows)
        {
            $catids = Yii::app()->db->createCommand()
                ->select('id')
                ->from('categories')
                ->where('alias=:alias', array('alias' => $table))
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
                Yii::app()->db->createCommand()->insert($this->getId(), array(
                    'title' => $row['title'], 
                    'alias' => $row['alias'], 
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
                ));
                
                $ids = Yii::app()->db->createCommand()
                    ->select('max(id)')
                    ->from($this->getId())
                    ->queryColumn();
                
                $lastId = $ids[0];
                
                Yii::app()->db->createCommand()->insert('items_old', array(
                    'item_id' => $lastId, 
                    'section' => $table, 
                    'old_id' => $row['id'], 
                ));
                
                if ($row['onfront'])
                {
                    Yii::app()->db->createCommand()->insert('frontpage_items', array(
                        'section' => $this->getId(), 
                        'item_id' => $lastId, 
                    ));
                }
            }
        }
        
        var_dump('OK!'); die;
    }

}
