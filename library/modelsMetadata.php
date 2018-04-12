<?php
namespace Library;
class modelsMetadata extends \Phalcon\Mvc\Model\MetaData\Redis{
	public function __construct($config){
		$options = [
			'host'       => $config->get('host'),
			'port'       => $config->get('port'),
			'persistent' => $config->get('persistent'),
			'statsKey'   => $config->get('statsKey'),
			'lifetime'   => $config->get('lifetime'),
			'prefix'     => $config->get('prefix'),
		];
		parent::__construct($options);
	}
}
