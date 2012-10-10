<?php
/**
 * Layout file for list of settings
 */

$this->breadcrumbs = array(
    Yii::t('main', 'admin.section.' . $sectionId)
);
?>

<h1 class="main"><?php echo Yii::t('main', 'admin.section.' . $sectionId); ?></h1>
<form action="<?php echo $this->createUrl('index'); ?>" method="post">
    <table id="settings" class="no-ribs">
        <tr>
            <td width="500"><label for="title">
                <b><?php echo Yii::t($sectionId, 'admin.form.label.siteName'); ?>:</b>
                    <?php echo Yii::t($sectionId, 'admin.form.label.siteNameDesc'); ?>
            </label></td>
            <td><input type="text" name="settings[title]" id="title" 
                       value="<?php echo $title; ?>" maxlength="255" /></td>
        </tr>
        <tr>
            <td><label for="description">
                <b><?php echo Yii::t($sectionId, 'admin.form.label.siteDescription'); ?>:</b>
                    <?php echo Yii::t($sectionId, 'admin.form.label.siteDescriptionDesc'); ?>
            </label></td>
            <td><input type="text" name="settings[description]" id="description" 
                       value="<?php echo $description; ?>" maxlength="255" /></td>
        </tr>
        <tr>
            <td><label for="keywords">
                <b><?php echo Yii::t($sectionId, 'admin.form.label.siteKeywords'); ?>:</b>
                    <?php echo Yii::t($sectionId, 'admin.form.label.siteKeywordsDesc'); ?>
            </label></td>
            <td><input type="text" name="settings[keywords]" id="keywords" 
                       value="<?php echo $keywords; ?>" maxlength="255" /></td>
        </tr>
        <tr>
            <td><label for="offline">
                <b><?php echo Yii::t($sectionId, 'admin.form.label.siteOff'); ?>:</b>
                    <?php echo Yii::t($sectionId, 'admin.form.label.siteOffDesc'); ?>
            </label></td>
            <td>
                <select name="settings[offline]" id="offline" style="width: 120px;">
                    <option value="0" <?php if ($offline == 0) echo 'selected="selected"'; ?>>
                        <?php echo Yii::t($sectionId, 'admin.form.label.online'); ?>
                    </option>
                    <option value="1" <?php if ($offline == 1) echo 'selected="selected"'; ?>>
                        <?php echo Yii::t($sectionId, 'admin.form.label.offline'); ?>
                    </option>
                </select>
            </td>
        </tr>
        <tr>
            <td><label for="offlineText">
                <b><?php echo Yii::t($sectionId, 'admin.form.label.offlineMessage'); ?>:</b>
                    <?php echo Yii::t($sectionId, 'admin.form.label.offlineMessageDesc'); ?>
            </label></td>
            <td><textarea name="settings[offlineText]" id="offlineText" rows="6" 
                          style="width:100%"><?php echo $offlineText; ?></textarea></td>
        </tr>
        <tr>
            <td><label for="adminEmail">
                <b><?php echo Yii::t($sectionId, 'admin.form.label.adminEmail'); ?>:</b>
                    <?php echo Yii::t($sectionId, 'admin.form.label.adminEmailDesc'); ?>
            </label></td>
            <td><input type="text" name="settings[adminEmail]" id="adminEmail" 
                       value="<?php echo $adminEmail; ?>" maxlength="128" /></td>
        </tr>
    </table>
    <div class="submit">
        <input type="submit" value="<?php echo Yii::t('main', 'admin.form.action.save'); ?>" />
    </div>
</form>