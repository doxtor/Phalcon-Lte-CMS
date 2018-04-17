<?php
namespace Library;
class Session extends \Phalcon\Session\Adapter\Redis{
	public function __construct($config){
		$options = [
			'host'       => $config->get('host'),
			'port'       => $config->get('port'),
			'persistent' => $config->get('persistent'),
			'lifetime'   => $config->get('lifetime'),
			'prefix'     => $config->get('prefix'),
		];
		parent::__construct($options);
		$this->start();
	}
}
