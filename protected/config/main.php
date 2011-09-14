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
		'image' => array(
          'class'  => 'application.extensions.image.CImageComponent',
          'driver' => 'GD'
        ),
        'dater' => array(
            'class' => 'application.components.DaterComponent'
        ),
        'text' => array(
            'class' => 'application.components.TextComponent'
        ),
		'urlManager' => array(
			'urlFormat'      => 'path',
            'showScriptName' => false,
			'rules' => array(
                '' => 'content/page/main',
                '<lang:[a-z]{2}>' => 'content/page/main',
                '<lang:[a-z]{2}>/page/<id:\d+>' => 'content/page/view',
                '<lang:[a-z]{2}>/page/<url:.*>' => 'content/page/view',

                'admin' => 'main/mainAdmin',
                '<lang:[a-z]{2}>/search'   => 'main/main/search',
                '<lang:[a-z]{2}>/feedback' => 'main/feedback/create',

                '<lang:[a-z]{2}>/login'        => 'users/user/login',
                '<lang:[a-z]{2}>/logout'       => 'users/user/logout',
                '<lang:[a-z]{2}>/registration' => 'users/user/registration',
                'admin/login'                 => 'users/userAdmin/login',

                '<lang:[a-z]{2}>/news/<id:\d+>' => 'news/news/view',
                '<lang:[a-z]{2}>/news'          => 'news/news/index',
//                ContentModule::urlRules(),
//                MainModule::urlRules(),
//                UsersModule::urlRules(),
//                NewsModule::urlRules(),

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

        'log'=>array(
                'class'=>'CLogRouter',
                'routes'=>array(
                    array(
                        'class'        => 'DbLogRoute',
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

