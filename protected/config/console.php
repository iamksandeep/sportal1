<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Student Portal Console',
	// application components
	'components'=>array(
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=sp',
			'emulatePrepare' => true,
			'username' => 'sp',
			'password' => 'sp',
			'charset' => 'utf8',
		),
	),
);