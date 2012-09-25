<?php

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'My Web Application',
    'sourceLanguage' => 'en',
    'language' => 'uk',
    'theme' => 'classic',
    // preloading 'log' component
    'preload' => array('log'),
    // autoloading model and component classes
    'import' => array(
        'application.components.*',
        'application.helpers.*',
        'application.models.*',
    ),
    'modules' => array(
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'yii',
        ),
        'admin' => array(
        ),
    ),
    // application components
    'components' => array(
        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => array(
                //'/admin' => '',
                '/news.html' => '/site/news',
                '/news/<slug:(\w|_|-|.|:)+>' => '/site/news',
                '/top10.html' => '/participants/top10',
                '/top10/results.html' => '/participants/results',
                '/participants.html' => '/participants',
                '/participants/<slug:(\w|_|-|.|:)+>' => '/participants/view',
                '/knowour.html' => '/site/knowour',
                '/knowour/<slug:(\w|_|-|.|:)+>' => '/site/knowour',
                '/citystyle.html' => '/site/citystyle',
                '/citystyle/<slug:(\w|_|-|.|:)+>' => '/site/citystyle',
                '/tyca.html' => '/site/tyca',
                '/tyca/<slug:(\w|_|-|.|:)+>' => '/site/tyca',
                '/<alias:(\w|_|-|.|:)+>.html' => '/site/pages',
                '/<controller>/<action>' => '/<controller>/<action>',
            ),
        ),
        'db' => require dirname(__FILE__) . DIRECTORY_SEPARATOR . 'db.php',
        'errorHandler' => array(
            'errorAction' => 'site/error',
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => require dirname(__FILE__) . DIRECTORY_SEPARATOR . 'settings.php',
);