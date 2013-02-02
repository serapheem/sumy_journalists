<?php
/**
 * Layout file for list of custom items
 */

?>

<div class="newsList">
    <?php
    $this->widget('zii.widgets.CListView', array(
        'id' => $sectionId,
        'dataProvider' => $dataProvider,
        'itemView' => '_item',
        'sortableAttributes' => array(
            'title',
            'created_at',// => 'Post Time',
        ),
        'beforeAjaxUpdate' => 'function(id) { blockContent(id); }',
    ));
    ?>
</div>
