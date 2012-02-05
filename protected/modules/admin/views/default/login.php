<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php echo Yii::t( 'default', 'CONTROL_PANEL' ) ?></title>
		<link href="/protected/modules/admin/views/public/css/reset.css" rel="stylesheet" type="text/css" />
		<link href="/protected/modules/admin/views/public/css/login.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<div id="admin-wrapper">
			<form action="#" method="post">

				<?php echo CHTML::errorSummary( $model ) ?>

				<?php echo CHTML::activeLabelEx( $model, 'username' ) ?><br />
				<?php echo CHTML::activeTextField( $model, 'username', array( 'size' => '30', 'class' => 'text' ) ) ?><br />

				<?php echo CHTML::activeLabelEx( $model, 'password' ) ?><br />
				<?php echo CHTML::activePasswordField( $model, 'password', array( 'size' => '30', 'class' => 'text' ) ) ?><br />

				<?php echo CHTML::activeCheckBox( $model, 'rememberMe' ) ?>
				<?php echo CHTML::activeLabelEx( $model, 'rememberMe' ) ?><br />

				<p><input type="submit" class="submit" id="btnLogin" value="<?php echo Yii::t( 'main', 'ENTER' ) ?>" /></p>
			</form>
		</div>
	</body>
</html>