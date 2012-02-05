<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
    <head>
        <title><?php echo Yii::t( 'main', 'ADMIN_PANEL' ) ?></title>

        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=7" />

        <link rel="stylesheet" type="text/css" href="/protected/modules/admin/views/public/css/style.css" media="all" />
        <!--[if IE]>
            <link rel="stylesheet" type="text/css" href="/protected/modules/admin/views/public/css/ie.css" media="all" />
		<![endif]-->
        <script src="<?php echo Yii::app( )->theme->baseUrl; ?>/js/jquery-1.7.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="/protected/modules/admin/views/public/js/core.js"></script>
    </head>
    <body>
        <div id="page">
            <div id="menu">
                <ul>
                    <li><a href="/admin"><?php echo Yii::t( 'main', 'SETTINGS' ) ?></a></li>
                    <li><a href="/admin/news"><?php echo Yii::t( 'main', 'MATERIALS' ) ?></a></li>
                    <li><a href="/admin/poll"><?php echo Yii::t( 'main', 'POLL' ) ?></a></li>
                    <li><a href="/admin/users"><?php echo Yii::t( 'main', 'USERS' ) ?></a></li>
                    <li><a href="/admin/pages"><?php echo Yii::t( 'main', 'PAGES' ) ?></a></li>
                    <li class="right"><a href="/" rel="external"><?php echo Yii::t( 'main', 'LOG_OUT' ) ?></a></li>
                    <li class="right"><a href="/admin/default/logout"><?php echo Yii::t( 'main', 'VIEW_SITE' ) ?></a></li>
                </ul>
            </div>
            <div id="menu-bg">&nbsp;</div>
            <div id="crumbs">
                <?php 
                $this->widget('zii.widgets.CBreadcrumbs', array(
                    'links' => $this->breadcrumbs,
                    'homeLink' => '<a href="/admin">' . Yii::t( 'main', 'ADMIN_PANEL' ) . '</a>',
                )); 
                ?><!-- breadcrumbs -->	
            </div>
            <?php if ( Yii::app( )->user->hasFlash( 'info' ) ) : ?>
                <div class="info" onclick="this.style.display='none'">
                    <?php echo Yii::app( )->user->getFlash( 'info' ) ?>
                </div>
            <?php endif; ?>
            <div id="content">
                <?php echo $content ?>
            </div>
        </div>
    </body>
</html>