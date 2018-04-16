<?php
namespace Library;
class Session extends \Phalcon\Session\Adapter\Redis{
	public function __construct($config)
	{
		$options = [
			'host'       => $config->get('host', 'localhost'),
			'port'       => $config->get('port', '6379'),
			'persistent' => $config->get('persistent', '_PHCM_'),
			'lifetime'   => $config->get('lifetime', '18600'),
			'prefix'     => $config->get('prefix', '-cms-'),
		];
		parent::__construct($options);
		$this->start();
	}
}
