<?php
use Phalcon\Config;
return new Config([
	'debug' => [
		'enable'          => true,
		'display_errors'  => -1,
	],
	'db' => [
		'host'            => 'localhost',
		'username'        => 'root',
		'password'        => 'root',
		'dbname'          => 'cms',
	],
	'redis' => [
		'host'            => 'localhost',
		'port'            => '6379',
		'persistent'      => '0',
		'statsKey'        => '_PHCM_',
		'lifetime'        => '18600',
		'index'           => '2',
		'prefix'          => '-cms-',
	],
]);