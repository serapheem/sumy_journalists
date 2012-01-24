<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
    <head>
        <title>Адмін-панель</title>

        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=7" />

        <link rel="stylesheet" type="text/css" href="/protected/modules/admin/views/public/css/style.css" media="all" />
        <!--[if IE]>
            <link rel="stylesheet" type="text/css" href="/protected/modules/admin/views/public/css/ie.css" media="all" />
	<![endif]-->
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery-1.5.js" type="text/javascript"></script>
        <script type="text/javascript" src="/protected/modules/admin/views/public/js/core.js"></script>
    </head>
    <body>
        <div id="page">
            <div id="menu">
                <ul>
                    <li><a href="/admin/default">Установки</a></li>
                    <li><a href="/admin/publications/news">Публікації</a></li>
                    <li><a href="/admin/poll">Голосування</a></li>
                    <li><a href="/admin/users">Користувачі</a></li>
                    <li><a href="/admin/pages">Статичні сторінки</a></li>
                    <li><a href="javascript: postSend('/admin/users/edit', { id: <?php echo Yii::app()->user->getId(); ?> });" title="Редагувати">Змінити пароль</a></li>
                    <li class="right"><a href="/admin/default/logout">Вийти</a></li>
                    <li class="right"><a href="/" rel="external">Перегляд сайту</a></li>
                </ul>
            </div>
            <div id="menu-bg">&nbsp;</div>
            <div id="crumbs">
                <?php 
                    $this->widget('zii.widgets.CBreadcrumbs', array(
                        'links' => $this->breadcrumbs,
                        'homeLink' => '<a href="/admin">Адмін-панель</a>',
                    )); ?><!-- breadcrumbs -->	
            </div>
            <?php if (Yii::app()->user->hasFlash('info')): ?>
                <div class="info" onclick="this.style.display='none'">
                    <?php echo Yii::app()->user->getFlash('info'); ?>
                </div>
            <?php endif; ?>
            <div id="content">
                <?php echo $content; ?>
            </div>
        </div>
    </body>
</html>