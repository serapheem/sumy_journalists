<?php
/**
 * Layout file for list of categories
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
    $this->widget('admin.components.grid.MyAdminButton', array(
        'buttonType' => 'link',
        'name' => 'delete-button',
        'caption' => Yii::t($sectionId, 'admin.list.action.deleteItems'),
        'url' => $this->createUrl('delete'),
        'confirm' => Yii::t($sectionId, 'admin.list.label.deleteConfirm'),
        'grid_id' => $sectionId,
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
                'class' => 'admin.components.grid.MyDataLinkColumn',
                'name' => 'title',
                'labelExpression' => 'CHtml::encode($data->title)',
                'urlExpression' => 'Yii::app()->controller->createUrl(\'edit\', array(\'id\' => $data->primaryKey))',
                'linkHtmlOptions' => array('title' => Yii::t('main', 'admin.list.action.edit')),
                'htmlOptions' => array('class' => 'link-column tl')
            ),
            array(
                'name' => 'catid',
                'value' => 'CHtml::encode($data->category->title)',
                'filter' => $model->getCatidFilterValues(),
                'headerHtmlOptions' => array('width' => '150'),
                'htmlOptions' => array('class' => 'tl')
            ),
            array(
                'class' => 'admin.components.grid.MyDataLinkColumn',
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
            array(
                'class' => 'admin.components.grid.MyDataLinkColumn',
                'name' => 'featured',
                'filter' => $model->getFeaturedFilterValues(),
                'labelExpression' => 'GridHelper::getFeaturedLabel(!empty($data->featured))',
                'urlExpression' => 'Yii::app()->controller->createUrl(\'edit\', array(\'id\' => $data->primaryKey))'
                    . ' . \'?' . $modelClass . '[featured]=\' . (1 - !empty($data->featured))',
                'linkHtmlOptions' => array(
                    'class' => 'feature', 'click' => 'ajaxChange',
                    'titleExpression' => 'empty($data->featured) '
                        . '? Yii::t( "' . $sectionId . '", "admin.list.action.feature" ) '
                        . ': Yii::t( "' . $sectionId . '", "admin.list.action.unfeature" )'
                ),
                'htmlOptions' => array('class' => 'link-column button-column'),
                'headerHtmlOptions' => array('width' => '130')
            ),
            array('name' => 'hits', 'filter' => '', 'headerHtmlOptions' => array('width' => '70')),
            array('name' => 'rating', 'filter' => '', 'headerHtmlOptions' => array('width' => '70')),
            array(
                'name' => 'modified_at',
                'value' => 'Yii::app()->dateFormatter->formatDateTime( $data->modified_at, "long" )',
                'filter' => '',
                'headerHtmlOptions' => array('width' => '120')
            ),
            array('name' => 'id', 'headerHtmlOptions' => array('width' => '30'))
        ),
    ));
    ?>
</div>
