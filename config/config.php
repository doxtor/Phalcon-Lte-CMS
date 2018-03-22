<?php
use Phalcon\Config;
return new Config([
	'debug' => [
		'enable'            => true,
		'compilevolt'       => true,
		'error_reporting'   => -1,
	],
	'logger' => [
		'defaultFilename'       => 'application',
		'format'                => '[%date%][%type%] %message%',
		'level'                 => 'debug',
	],
	'db' => [
		'host'     => 'localhost',
		'username' => 'root',
		'password' => 'root',
		'dbname'   => 'db',
	],
	'redis' => [
		'host'       => 'localhost',
		'port'       => '6379',
		'persistent' => '0',
		'statsKey'   => '_PHCM_',
		'lifetime'   => '18600',
		'index'      => '2',
		'prefix'     => '-cms-',
	],
]);
