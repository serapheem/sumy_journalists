<?php
$this->breadcrumbs = array(
	Yii::t( 'default', 'SITE_SETTINGS' )
);
?>

<h1 class="main"><?php echo Yii::t( 'default', 'SITE_SETTINGS' ) ?></h1>
<form action="#" method="post">
	<table id="settings" class="no-ribs">
		<tr>
			<td width="500"><label for="title">
				<b><?php echo Yii::t( 'default', 'SITE_NAME' ) ?>:</b><?php echo Yii::t( 'default', 'SITE_NAME_DESC' ) ?>
			</label></td>
			<td><input type="text" name="settings[title]" id="title" value="<?php echo $title ?>" maxlength="255" /></td>
		</tr>
		<tr>
			<td><label for="description">
				<b><?php echo Yii::t( 'default', 'SITE_DESCRIPTION' ) ?>:</b><?php echo Yii::t( 'default', 'SITE_DESCRIPTION_DESC' ) ?>
			</label></td>
			<td><input type="text" name="settings[description]" id="description" value="<?php echo $description ?>" maxlength="255" /></td>
		</tr>
		<tr>
			<td><label for="keywords">
				<b><?php echo Yii::t( 'default', 'SITE_KEYWORDS' ) ?>:</b><?php echo Yii::t( 'default', 'SITE_KEYWORDS_DESC' ) ?>
			</label></td>
			<td><input type="text" name="settings[keywords]" id="keywords" value="<?php echo $keywords ?>" maxlength="255" /></td>
		</tr>
		<tr>
			<td><label for="offline">
				<b><?php echo Yii::t( 'default', 'OFF_SITE' ) ?>:</b><?php echo Yii::t( 'default', 'OFF_SITE_DESC' ) ?>
			</label></td>
			<td>
				<select name="settings[offline]" id="offline" style="width: 120px;">
					<option value="0" <?php if ($offline == 0) echo 'selected="selected"'; ?>><?php echo Yii::t( 'main', 'ONLINE' ) ?></option>
					<option value="1" <?php if ($offline == 1) echo 'selected="selected"'; ?>><?php echo Yii::t( 'main', 'OFFLINE' ) ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><label for="offlineText">
				<b><?php echo Yii::t( 'default', 'OFFLINE_MESSAGE' ) ?>:</b><?php echo Yii::t( 'default', 'OFFLINE_MESSAGES_DESC' ) ?>
			</label></td>
			<td><textarea name="settings[offlineText]" id="offlineText" rows="6" style="width:100%"><?php echo $offlineText ?></textarea></td>
		</tr>
		<tr>
			<td><label for="adminEmail">
				<b><?php echo Yii::t( 'default', 'ADMIN_EMAIL' ) ?>:</b><?php echo Yii::t( 'default', 'ADMIN_EMAIL_DESC' ) ?>
			</label></td>
			<td><input type="text" name="settings[adminEmail]" id="adminEmail" value="<?php echo $adminEmail ?>" maxlength="128" /></td>
		</tr>
	</table>
	<div class="submit">
		<input type="submit" value="<?php echo Yii::t( 'main', 'SAVE' ) ?>" />
	</div>
</form>