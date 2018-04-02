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
/*
class DB extends \Phalcon\Mvc\User\Component{
	public function init(){
		$config = $this->di->getShared('config');
		$this->di->setShared("db",function () use ($config){
			return new \Phalcon\Db\Adapter\Pdo\Mysql([
				"host"     => $config->get('db')->get('host'),
				"username" => $config->get('db')->get('username'),
				"password" => $config->get('db')->get('password'),
				"dbname"   => $config->get('db')->get('dbname'),
				"options" => array(
					\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
				)
			]);}
		);
		$this->di->setShared('modelsMetadata',function () use ($config) {
			$cacheFrontend = new \Phalcon\Cache\Frontend\Data([
				'lifetime' => $config->get('redis')->get('lifetime'),
			]);
			$options = [
				'host'       => $config->get('redis')->get('host'),
				'port'       => $config->get('redis')->get('port'),
				'persistent' => $config->get('redis')->get('persistent'),
				'statsKey'   => $config->get('redis')->get('statsKey'),
				'lifetime'   => $config->get('redis')->get('lifetime'),
				'prefix'     => $config->get('redis')->get('prefix'),
			];
			$metadata = new \Phalcon\Mvc\Model\MetaData\Redis($options);
			return $metadata;
		});
		$this->di->setShared('modelsCache',function() use ($config) {
			$cacheFrontend = new \Phalcon\Cache\Frontend\Data([
				'lifetime' => $config->get('redis')->get('lifetime'),
			]);
			$options = [
				'host'       => $config->get('redis')->get('host'),
				'port'       => $config->get('redis')->get('port'),
				'persistent' => $config->get('redis')->get('persistent'),
				'statsKey'   => $config->get('redis')->get('statsKey'),
				'lifetime'   => $config->get('redis')->get('lifetime'),
				'prefix'     => $config->get('redis')->get('prefix'),
			];
			return new \Phalcon\Cache\Backend\Redis($cacheFrontend, $options);
		});
		$this->di->setShared('modelsManager',function() {
			return new \Phalcon\Mvc\Model\Manager();
		});
	}
}
*/
