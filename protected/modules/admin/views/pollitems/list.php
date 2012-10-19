<?php
/**
 * Layout file for list of poll items
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
        'url' => $this->createUrl('create', array('catid' => Yii::app()->request->getQuery('catid') ?: null)),
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
                'name' => 'poll_id',
                'value' => 'CHtml::encode($data->poll->title)',
                'filter' => $model->getPollidFilterValues(),
                'headerHtmlOptions' => array('width' => '250'),
                'htmlOptions' => array('class' => 'tl')
            ),
            array(
                'name' => 'count', 
                'filter' => '', 
                'headerHtmlOptions' => array('width' => '120')
            ),
            array('name' => 'id', 'headerHtmlOptions' => array('width' => '30')),
        ),
    ));
    ?>
</div>
