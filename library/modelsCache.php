<?php
namespace Library;
class modelsCache extends \Phalcon\Cache\Backend\Redis{
	public function __construct($config)
	{
		$cacheFrontend = new \Phalcon\Cache\Frontend\Data([
			'lifetime' => $config->get('lifetime'),
		]);
		$options = [
			'host'       => $config->get('host'),
			'port'       => $config->get('port'),
			'persistent' => $config->get('persistent'),
			'statsKey'   => $config->get('statsKey'),
			'lifetime'   => $config->get('lifetime'),
			'prefix'     => $config->get('prefix'),
		];
		parent::__construct($cacheFrontend, $options);
	}
}
