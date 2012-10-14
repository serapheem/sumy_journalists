<?php
/**
 * Layout file for list of poll categories
 */

$this->breadcrumbs = array(
    Yii::t('main', 'admin.section.' . $sectionId)
);
?>

<?php $this->renderSubmenu(); ?>

<div class="box visible">
    <h1><?php echo Yii::t('main', 'admin.section.' . $sectionId); ?></h1>

    <?php
    $this->widget('zii.widgets.jui.CJuiButton', array(
        'buttonType' => 'link',
        'name' => 'create-button',
        'caption' => Yii::t($sectionId, 'admin.list.action.createItem'),
        'url' => $this->createUrl('create'),
        'htmlOptions' => array('title' => Yii::t($sectionId, 'admin.list.action.createItem'))
        )
    );
    // TODO : Create new confirm message
    $this->widget('MyAdminButton', array(
        'buttonType' => 'link',
        'name' => 'delete-button',
        'caption' => Yii::t($sectionId, 'admin.list.action.deleteItems'),
        'url' => $this->createUrl('delete'),
        'confirm' => Yii::t($sectionId, 'admin.list.label.deleteConfirm'),
        'grid_id' => 'categories',
        'htmlOptions' => array('title' => Yii::t($sectionId, 'admin.list.action.deleteItems'))
        )
    );

    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => $sectionId,
        'dataProvider' => $dataProvider,
        'filter' => $model,
        'selectableRows' => $itemPerPage,
        'ajaxUpdate' => 'user-info',
        // 'updateSelector' => '#categories .pager a, #categories .items thead th a, #admin-form .delete',
        'beforeAjaxUpdate' => 'updateAjaxRequest',
        'columns' => array(
            array(
                'class' => 'CCheckBoxColumn',
                'id' => 'ids'
            ),
            array(
                'class' => 'CButtonColumn',
                'template' => '{delete}',
                'deleteButtonUrl' => 'Yii::app()->controller->createUrl(\'delete\') . \'?ids=\' . $data->primaryKey',
                'deleteConfirmation' => Yii::t($sectionId, 'admin.list.label.deleteConfirm')
            ),
            array(
                'class' => 'MyDataLinkColumn',
                'name' => 'title',
                'labelExpression' => 'CHtml::encode($data->title)',
                'urlExpression' => 'Yii::app()->controller->createUrl(\'edit\', array(\'id\' => $data->primaryKey))',
                'linkHtmlOptions' => array('title' => Yii::t('main', 'admin.list.action.edit')),
                'htmlOptions' => array('class' => 'link-column tl')
            ),
            array(
                'class' => 'CLinkColumn',
                'label' => Yii::t($sectionId, 'admin.list.action.moderateElements'),
                'urlExpression' => 'Yii::app()->getUrlManager()->createUrl(\'admin/pollitems/admin\', '
                                . 'array(\'catid\' => $data->primaryKey))',
                'linkHtmlOptions' => array('title' => Yii::t('main', 'admin.list.action.edit')),
                'headerHtmlOptions' => array('width' => '130')
            ),
            array(
                'class' => 'MyDataLinkColumn',
                'name' => 'state',
                'filter' => $model->getStateFilterValues(),
                'labelExpression' => 'GridHelper::getStateLabel($data->state)',
                'urlExpression' => 'Yii::app()->controller->createUrl(\'edit\', array(\'id\' => $data->primaryKey))'
                    . ' . \'?' . $modelClass . '[state]=\' . (1 - $data->state)',
                'linkHtmlOptions' => array(
                    'class' => 'state', 'click' => 'ajaxChange',
                    'titleExpression' => '$data->state '
                        . '? Yii::t( "main", "admin.list.action.unpublish" ) '
                        . ': Yii::t( "main", "admin.list.action.publish" )'
                ),
                'htmlOptions' => array('class' => 'link-column button-column'),
                'headerHtmlOptions' => array('width' => '130')
            ),
            array('name' => 'id', 'headerHtmlOptions' => array('width' => '30'))
        ),
    ));
    ?>
</div>
