<?php
namespace Library;
class DB extends \Phalcon\Db\Adapter\Pdo\Mysql{
	public function __construct($config)
	{
		$options = [
			'host'     => $config->get('host'),
			'username' => $config->get('username'),
			'password' => $config->get('password'),
			'dbname'   => $config->get('dbname'),
			'options' => [\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8']
		];
		parent::__construct($options);
	}
}
