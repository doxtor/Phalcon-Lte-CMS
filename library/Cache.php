<?php
namespace Library;

use Phalcon\Mvc\User\Component;
use Phalcon\Cache\Backend\Redis;
use Phalcon\Cache\Frontend\Data;
class Cache extends Component
{
	public $cache;
	public $log;

	/**
	* Cache constructor.
	* @param $config
	*/
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
		$this->log = [];
	}
	/**
	* Get var in Redis
	*
	* @param $key Key var
	* @param $lifetime
	*
	* @return var
	*
	*/
	public function get($key, $lifetime = null)
	{
		$result = $this->cache->get($key, $lifetime);
		if($result){
			$this->log[] = ['type' => 'get','key' => $key];
		}
		return $result;
	}
	/**
	* Save var in Redis
	*
	* @param $key Key var
	* @param $data var
	* @param $lifetime
	*
	* @return bool
	*
	*/
	public function save($key, $data, $lifetime = null)
	{
		$result = $this->cache->save($key, $data, $lifetime);
		if($result){
			$this->log[] = ['type' => 'save','key' => $key];
		}
		return $result;
	}
	/**
	* Set var in Redis
	* Like as Save method
	*
	* @param $key Key var
	* @param $data var
	* @param $lifetime
	*
	* @return bool
	*
	*/
	public function set($key, $data, $lifetime = null)
	{
		$result = $this->cache->save($key, $data, $lifetime);
		if($result){
			$this->log[] = ['type' => 'set','key' => $key];
		}
		return $result;
	}
	/**
	* Delete var in Redis
	*
	* @param $key Key var
	*
	* @return bool
	*
	*/
	public function delete($key)
	{
		$result = $this->cache->delete($key);
		if($result){
			$this->log[] = ['type' => 'delete','key' => $key];
		}
		return $result;
	}
	/**
	* Query
	* For get all keys vars in Redis save
	*
	* @param $prefix
	*
	* @return array keys
	*
	*/
	public function queryKeys($prefix = null){
		return $this->cache->queryKeys($prefix);
	}
}
