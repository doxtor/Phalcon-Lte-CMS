<?php
namespace Library;

use Phalcon\Assets\Filters\{Cssmin, Jsmin};
class Assets extends \Phalcon\Assets\Manager{
	private $cache =  null;
	private $collections = [];
	public function __construct($config){
		parent::__construct();
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
		$this->cache = new \Phalcon\Cache\Backend\Redis($cacheFrontend, $options);
		$this->collections = include VIEWS_PATH . '/assets.php';
		foreach ($this->collections as $collection_name => $files) {
			if($rand = $this->cache->get('assets.' . $collection_name)){
				$collection = $this->collection($collection_name);
				if($files['type'] === 'css'){
					$collection->addCss($files['uri'] . '?r=' . $rand);
				}else{
					$collection->addJs($files['uri'] . '?r=' . $rand);
				}
			}elseif(isset($files['path']) && !file_exists($files['path'])){
				$collection = $this->collection($collection_name);
				$collection->setLocal(true);
				if($files['type'] === 'css' && count($files['files'])){
					$collection->addFilter(new Cssmin());
					foreach ($files['files'] as $file) {
						$collection->addCss($file);
					}
				}elseif(count($files['files'])){
					$collection->addFilter(new Jsmin());
					foreach ($files['files'] as $file) {
						$collection->addJs($file);
					}
				}
				$collection->setTargetPath($files['path']);
				$collection->setTargetUri($files['uri']);
				$collection->join(true);
			}elseif(isset($files['files'])){
				$rand = filemtime($files['path']);
				$this->cache->save('assets.' . $collection_name, $rand);
				$collection = $this->collection($collection_name);
				if($files['type'] === 'css'){
					$collection->addCss($files['uri'] . '?r=' . $rand);
				}else{
					$collection->addJs($files['uri'] . '?r=' . $rand);
				}
			}else{
				$this->collection($collection_name);
			}
		}
	}
}
