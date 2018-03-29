<?php
namespace Library;

use Phalcon\Mvc\User\Component;
use Phalcon\Cache\Backend\Redis;
use Phalcon\Cache\Frontend\Data;
class Cache extends Component
{
	public $cache;
	public function __construct($config)
	{
		$cacheFrontend = new Data([
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
		$this->cache = new Redis($cacheFrontend, $options);
	}
	public function get($key, $lifetime = null)
	{
		return $this->cache->get($key, $lifetime);
	}
	public function save($key, $data, $lifetime = null)
	{
		return $this->cache->save($key, $data, $lifetime);
	}
	public function set($key, $data, $lifetime = null)
	{
		return $this->cache->save($key, $data, $lifetime);
	}
	public function delete($key)
	{
		return $this->cache->delete($key);
	}
	public function queryKeys($prefix = null){
		return $this->cache->queryKeys($prefix);
	}
}
