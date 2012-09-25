<?php
/**
 * File with sub menu
 */

$um = Yii::app()->getUrlManager();
?>

<h1 class="main"><?php echo CHtml::encode($sectionTitle); ?></h1>

<?php if (!empty($items) && is_array($items)) : ?>
    <ul class="tabs">
        <?php foreach ($items as $link => $title) : ?>

            <li<?php echo ($link != $current) ? '' : ' class="current"'; ?>>
                <a href="<?php echo $um->createUrl($link); ?>" class="a_in_tab">
                    <?php echo CHtml::encode($title); ?>
                </a>
            </li>

        <?php endforeach; ?>
    </ul>
<?php endif; ?>
