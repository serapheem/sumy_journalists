<?php

return array(
    'basePath' => dirname(__FILE__) . '/..',
    'name' => 'InCity.Sumy.Ua',
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
            'password' => 'yiiadmin',
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
//                '/admin/news/<action>' => array(
//                    '/admin/customitems/<action>', 
//                    //'urlSuffix'=>'.html', 
//                    'caseSensitive' => false,
//                    'defaultParams' => array('catid' => 3)
//                ),
//                '/admin/news' => array(
//                    '/admin/customitems', 
//                    //'urlSuffix'=>'.html', 
//                    'caseSensitive' => false,
//                    'defaultParams' => array('catid' => 3)
//                ),
//                '/admin/citystyle/<action>' => array(
//                    '/admin/customitems/<action>', 
//                    'caseSensitive' => false,
//                    'defaultParams' => array('catid' => 5)
//                ),
//                '/admin/citystyle' => array(
//                    '/admin/customitems', 
//                    'caseSensitive' => false,
//                    'defaultParams' => array('catid' => 5)
//                ),
                
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
        'db' => require dirname(__FILE__) . '/db.php',
        'errorHandler' => array(
            'errorAction' => 'site/error',
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => require dirname(__FILE__) . '/settings.php',
);