<?php
/**
 * Layout file for list of users
 */

$this->breadcrumbs = array(
    Yii::t('main', 'admin.section.' . $sectionId)
);
?>

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
            'class' => 'MyDataLinkColumn',
            'name' => 'name',
            'labelExpression' => 'CHtml::encode($data->name)',
            'urlExpression' => 'Yii::app()->controller->createUrl(\'edit\', array(\'id\' => $data->primaryKey))',
            'linkHtmlOptions' => array('title' => Yii::t('main', 'admin.list.action.edit')),
            'htmlOptions' => array('class' => 'link-column tl')
        ),
        array('name' => 'email', 'headerHtmlOptions' => array('width' => '150')),
        array(
            'name' => 'lasttime',
            'value' => 'Yii::app()->dateFormatter->formatDateTime($data->lasttime, "long")',
            'filter' => '',
            'headerHtmlOptions' => array('width' => '120')
        ),
        array('name' => 'ip', 'headerHtmlOptions' => array('width' => '100')),
        array('name' => 'id', 'headerHtmlOptions' => array('width' => '30'))
    ),
));
?>
