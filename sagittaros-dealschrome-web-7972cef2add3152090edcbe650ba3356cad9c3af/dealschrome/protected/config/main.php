<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Dealschrome',
    'theme' => 'chrome',
    'preload' => array('log', 'kint'),
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.components.ImageCache.*',
    ),
    'modules' => array(
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'asdqwe',
            'ipFilters' => array('127.0.0.1', '::1', '182.55.242.246'),
        ),
        'deal',
        'pages',
        'admin',
    ),
    'homeUrl' => '/deal/search',
    'components' => array(
        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => FALSE,
            'appendParams' => FALSE,
            'rules' => array(
                '' => 'deal/search', //this is the homepage
                'search' => 'deal/search/full',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ),
        'db' => array(
            'connectionString' => 'mysql:host=127.0.0.1;dbname=dealschrome',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => 'WINDzen89',
            'charset' => 'utf8',
        ),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            /**
              array(
              'class'=>'CWebLogRoute',
              ),
             * */
            ),
        ),
        'request' => array(
            'enableCsrfValidation' => TRUE,
        ),
        'kint' => array(
            'class' => 'ext.Kint.Kint',
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'felixsagitta@gmail.com',
    ),
);