<?php
$modules_includes = array();
$modules_dirs     = scandir(MODULES_PATH);

foreach ($modules_dirs as $module)
{
    if ($module[0] == ".") continue;

    $modules[] = $module;
		
    $modules_includes[] = "application.modules.{$module}.*";
    $modules_includes[] = "application.modules.{$module}.models.*";
    $modules_includes[] = "application.modules.{$module}.portlets.*";
    $modules_includes[] = "application.modules.{$module}.forms.*";
    $modules_includes[] = "application.modules.{$module}.components.*";
}



$modules['gii'] = array(
    'class'          => 'system.gii.GiiModule',
    'generatorPaths' => array('application.gii'),
	'password'       => 'giisecret',
	'ipFilters'      => array('127.0.0.1','::1')
);

return array(
    'language' => 'ru',
	'basePath' => dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'     => '',

	'preload'=>array('log'),

	'import'=> array_merge(
        $modules_includes,
        array(
            'application.components.*',
            'application.libs.tools.*',
            'ext.yiiext.filters.setReturnUrl.ESetReturnUrlFilter',
            'application.modules.srbac.controllers.SBaseController',
	    )
    ),

	'modules' => $modules,

	'components' => array(
        'session' => array(
            'autoStart'=> true
        ),
		'user' => array(
			'allowAutoLogin' => true,
            'class'          => 'WebUser'
		),
		'image'=>array(
          'class'  => 'application.extensions.image.CImageComponent',
          'driver' => 'GD'
        ),
		'urlManager' => array(
			'urlFormat'      => 'path',
            'showScriptName' => false,
			'rules' => array(
                ContentModule::urlRules(),
                MainModule::urlRules(),
                UsersModule::urlRules(),
                NewsModule::urlRules(),

                '<lang:[a-z]{2}>/<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<lang:[a-z]{2}>/<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                '<lang:[a-z]{2}>/<controller:\w+>/<action:\w+>'=>'<controller>/<action>',                
                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),

		'errorHandler' => array(
            'errorAction' => 'main/main/error',
        ),

        'authManager' => array(
            'class'           => 'CDbAuthManager',
			'connectionID'    => 'db',     
            'itemTable'       => 'AuthItem',
            'assignmentTable' => 'AuthAssignment',
            'itemChildTable'  => 'AuthItemChild',			  
			'defaultRoles'    => array('guest')
        ),
        
//        'srbac' => array(
//          'userclass'=>'User', //default: User
//          'userid'=>'id', //default: userid
//          //'username'=>'role', //default:username
//          'delimeter'=>'@', //default:-
//          'debug'=>true, //default :false
//          'pageSize'=>10, // default : 15
//          'superUser' =>'Authority', //default: Authorizer
//          'css'=>'srbac.css', //default: srbac.css
//          'layout'=>
//            'application.views.layouts.main', //default: application.views.layouts.main,
//                                              //must be an existing alias
//          'notAuthorizedView'=> 'srbac.views.authitem.unauthorized', // default:
//                            //srbac.views.authitem.unauthorized, must be an existing alias
//          'alwaysAllowed'=>array(   //default: array()
//             'SiteLogin','SiteLogout','SiteIndex','SiteAdmin',
//             'SiteError', 'SiteContact'),
//          'userActions'=>array('Show','View','List'), //default: array()
//          'listBoxNumberOfLines' => 15, //default : 10
//          'imagesPath' => 'srbac.images', // default: srbac.images
//          'imagesPack'=>'noia', //default: noia
//          'iconText'=>true, // default : false
//          'header'=>'srbac.views.authitem.header', //default : srbac.views.authitem.header,
//                                                   //must be an existing alias
//          'footer'=>'srbac.views.authitem.footer', //default: srbac.views.authitem.footer,
//                                                   //must be an existing alias
//          'showHeader'=>true, // default: false
//          'showFooter'=>true, // default: false
//          'alwaysAllowedPath'=>'srbac.components', // default: srbac.components
//                                                   // must be an existing alias
//        ),
//
        'log'=>array(
                'class'=>'CLogRouter',
                'routes'=>array(
                    array(
                        'class'        => 'CDbLogRoute',
                        'levels'       => 'error, warning, info',
                        'connectionID' => 'db',
                        'logTableName' => 'log',
                        'enabled'      => true
                    )
                ),
        ),
		
        'preload'=>array('log'),
        
//        'log'=>array(
//            'class'=>'CLogRouter',
//            'routes'=>array(
//                array(
//                    'class'=>'CWebLogRoute',
//                    'levels'=>'profile',
//                    'enabled'=>true,
//                ),
//            ),
//        ),
	),

	'params'=>array(
		'adminEmail'=>'artem-moscow@yandex.ru.com',
	),

    'language' => 'ru',
);

