<?php
use Phalcon\Config;
return new Config([
	'debug' => [
		'enable'			=> getenv('DEBUG_ENABLE'),
		'compilevolt'		=> boolval(getenv('DEBUG_COMPILEVOLT')),
		'error_reporting'	=> getenv('DEBUG_ERROR_REPORTING'),
		'sql_profiler'		=> getenv('DEBUG_SQL_PROFILER'),
		'cache_profiler'	=> getenv('DEBUG_CACHE_PROFILER'),
		'password_profiler'	=> getenv('DEBUG_PASSWORD_PROFILER'),
	],
	'logger' => [
		'defaultFilename'	=> getenv('LOGGER_DEFAULT_FILENAME'),
		'format'			=> getenv('LOGGER_FORMAT'),
		'level'			=> getenv('LOGGER_LEVEL'),
	],
	'db' => [
		'local' => [
			'host'		=> getenv('DB_LOCAL_HOST'),
			'username'	=> getenv('DB_LOCAL_USERNAME'),
			'password'	=> getenv('DB_LOCAL_PASSWORD'),
			'dbname'		=> getenv('DB_LOCAL_DBNAME'),
		],
		'halls' => [
			'host'		=> getenv('DB_HALLS_HOST'),
			'username'	=> getenv('DB_HALLS_USERNAME'),
			'password'	=> getenv('DB_HALLS_PASSWORD'),
			'dbname'		=> getenv('DB_HALLS_DBNAME'),
		],
	],
	'redis' => [
		'host'       => getenv('REDIS_HOST'),
		'port'       => getenv('REDIS_PORT'),
		'persistent' => getenv('REDIS_PRESISTENT'),
		'statsKey'   => getenv('REDIS_STATUSKEY'),
		'lifetime'   => getenv('REDIS_LIFETIME'),
		'index'      => getenv('REDIS_INDEX'),
	],
	'oauth' => [
		'url' 			=> getenv('OAUTH_URL'),
		'client_id' 		=> getenv('OAUTH_CLIENT_ID'),
		'client_secret' 	=> getenv('OAUTH_CLIENT_SECRET'),
	],
	'1c' => [
		'DO' => [
			'url'		=> getenv('1C_DO_URL'),
			'login'		=> getenv('1C_DO_LOGIN'),
			'password'	=> getenv('1C_DO_PASSWORD'),
			'authtype'	=> getenv('1C_DO_AUTHTYPE'),
		],
		'StarbetZUP' => [
			'url'		=> getenv('1C_STARBETZUP_URL'),
			'login'		=> getenv('1C_STARBETZUP_LOGIN'),
			'password'	=> getenv('1C_STARBETZUP_PASSWORD'),
			'authtype'	=> getenv('1C_STARBETZUP_AUTHTYPE'),
		],
	],
	'application' => [
		'controllersDir'	=> __DIR__ . '/../controllers/',
		'modelsDir'		=> __DIR__ . '/../models/',
		'viewsDir'		=> __DIR__ . '/../views/',
		'libraryDir'		=> __DIR__ . '/../library/',
		'tasksDir'		=> __DIR__ . '/../tasks/',
		'cacheDir'		=> __DIR__ . '/../../storage/cache/',
		'filesDir'		=> __DIR__ . '/../../storage/files/',
	],
]);
