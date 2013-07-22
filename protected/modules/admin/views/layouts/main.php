<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
    <head>
        <title><?php echo ($this->_title ? ($this->_title . ' - ') : '') . Yii::t('main', 'admin.menu.adminPanel'); ?></title>

        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=7" />
<!-- TODO : S.H. need to check it -->
        <link rel="stylesheet" type="text/css" href="/protected/modules/admin/views/public/css/style.css" media="all" />
        <!--[if IE]>
                <link rel="stylesheet" type="text/css" href="/protected/modules/admin/views/public/css/ie.css" media="all" />
        <![endif]-->
        <?php /* <script src="<?php echo Yii::app( )->theme->baseUrl; ?>/js/jquery-1.7.min.js" type="text/javascript"></script> */ ?>
        <script type="text/javascript" src="/protected/modules/admin/views/public/js/core.js"></script>
    </head>
    <body>
        <div id="page">
            <div id="menu">
                <?php 
                if ($mainMenuItems = $this->getMainMenuItems())
                {
                    ?><ul><?php
                    foreach ($mainMenuItems as $link => $item)
                    {
                        $htmlOptions = '';
                        if (!empty($item['htmlOptions']))
                        {
                            foreach ($item['htmlOptions'] as $key => $value)
                            {
                                $htmlOptions .= ' ' . $key . '="' . $value . '"';
                            }
                        }
                        $linkHtmlOptions = '';
                        if (!empty($item['linkHtmlOptions']))
                        {
                            foreach ($item['linkHtmlOptions'] as $key => $value)
                            {
                                $linkHtmlOptions .= ' ' . $key . '="' . $value . '"';
                            }
                        }
                        ?>
                        <li<?php echo $htmlOptions; ?>>
                            <a href="<?php echo $link; ?>"<?php echo $linkHtmlOptions; ?>>
                                <?php echo $item['label']; ?>
                            </a>
                        </li>
                        <?php
                    }
                    ?></ul><?php
                }
                ?>
            </div>
            <div id="menu-bg">&nbsp;</div>
            <div id="crumbs">
                <?php
                $this->widget('zii.widgets.CBreadcrumbs', array(
                    'links' => $this->breadcrumbs,
                    'homeLink' => CHtml::link(Yii::t('main', 'admin.menu.adminPanel'), '/admin'),
                ));
                ?><!-- breadcrumbs -->	
            </div>

            <?php
//            if (Yii::app()->user->hasFlash('error') 
//                || Yii::app()->user->hasFlash('warning') 
//                || Yii::app()->user->hasFlash('notice')
//            )
//            {
//                $user_style = '';
//            }
//            else
//            {
//                $user_style = ' style="display: none"';
//            }
            ?>
            <div id="user-info"<?php //echo $user_style; ?>>
                <div class="success" onclick="this.style.display='none'"<?php echo ( Yii::app()->user->hasFlash('success') ) ? '' : ' style="display: none"'; ?>>
                    <span class="icon">&nbsp;</span><?php
            echo ( Yii::app()->user->hasFlash('success') ) ? Yii::app()->user->getFlash('success') : '&nbsp;';
            ?></div>
                <div class="warning" onclick="this.style.display='none'"<?php echo ( Yii::app()->user->hasFlash('warning') ) ? '' : ' style="display: none"'; ?>>
                    <span class="icon">&nbsp;</span><?php
            echo ( Yii::app()->user->hasFlash('warning') ) ? Yii::app()->user->getFlash('warning') : '&nbsp;';
            ?></div>
                <div class="error" onclick="this.style.display='none'"<?php echo ( Yii::app()->user->hasFlash('error') ) ? '' : ' style="display: none"'; ?>>
                    <span class="icon">&nbsp;</span><?php
            echo ( Yii::app()->user->hasFlash('error') ) ? Yii::app()->user->getFlash('error') : '&nbsp;';
            ?></div>
            </div>

            <div id="content">
                <?php echo $content; ?>
            </div>
        </div>
    </body>
</html>