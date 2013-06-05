<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'INTRANET - SSP/AM',
		
	'sourceLanguage'=>'en_us',
	'language'=>'pt_br',
		
	'timezone'=>'America/Manaus',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.modules.user.models.*',
		'application.modules.user.components.*',
		'application.modules.rights.*',
		'application.modules.rights.models.*',
		'application.modules.rights.components.*',
		'application.modules.unidade.models.*',
		'application.modules.unidade.components.*',
		'application.modules.protocolo.models.*',
		'application.modules.protocolo.components.*',
	),

	'modules'=>array(
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'intranet',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		'user'=>array(
			# encrypting method (php hash function)
			'hash' => 'md5',
		
			# send activation email
			'sendActivationMail' => true,
			
			# allow access for non-activated users
			'loginNotActiv' => false,
			
			# activate user on registration (only sendActivationMail = false)
			'activeAfterRegister' => false,
			
			# automatically login from registration
			'autoLogin' => true,
			
			# registration path
			'registrationUrl' => array('/user/registration'),
			
			# recovery password path
			'recoveryUrl' => array('/user/recovery'),
			
			# login form path
			'loginUrl' => array('/user/login'),
			
			# page after login
			'returnUrl' => array('/user/profile'),
			
			# page after logout
			'returnLogoutUrl' => array('/user/login'),
	
			'relations' => array(
				'protocolo'=>array(CActiveRecord::HAS_MANY, 'Protocolo', 'usuario'),
			),
				
			'profileRelations' => array(						
				'unidade'=>array(CActiveRecord::BELONGS_TO, 'Unidade', 'unidade_id'),
			),	
		),
		'rights'=>array(
			//'install'=>true,
		),
		'unidade',
		'protocolo'=>array(
			'defaultController' => 'default',
		),
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'class' => 'RWebUser',
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		*/
		'authManager'=>array(
			'class'=>'RDbAuthManager',
		),
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=intranet',
			'tablePrefix' => 'tbl_',
			'emulatePrepare' => true,
			'username' => 'intranet',
			'password' => 'intranet',
			'charset' => 'utf8',
			'enableParamLogging'=>true,
			'enableProfiling'=>true,	
		),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				/*
				array(
					'class'=>'CProfileLogRoute',
					'report'=>'summary',
				),
				*/
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'sistemas@ssp.am.gov.br',
	),
);