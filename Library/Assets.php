<?php
namespace Library;

use Phalcon\Assets\Filters\{Cssmin, Jsmin};
class Assets extends \Phalcon\Assets\Manager{
	private $cache =  null;
	public $collections = [
		'header_css' => [
			'path' => ASSETS_PATH . 'header.css',
			'uri' => ASSETS_URL . 'header.css',
			'type' => 'css',
			'files' => [
				'css/bootstrap.css',
				'css/fa-svg-with-js.css',
				'css/jquery.dataTables.css',
			],
		],
		'footer_js' => [
			'path' => ASSETS_PATH . 'footer.js',
			'uri' => ASSETS_URL . 'footer.js',
			'type' => 'js',
			'files' => [
				'js/jquery.min.js',
				'js/bootstrap.js',
				'js/fontawesome-all.js',
				'js/jquery.dataTables.min.js',
			],
		],
	];
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
	}
	public function _getIncludeAll(){
		foreach ($this->collections as $collection => $files) {
			$this->collection($collection);
			if($files['type'] === 'css' && count($files['files'])){
				foreach ($files['files'] as $file) {
					$this->addCss($file);
				}
			}elseif(count($files['files'])){
				foreach ($files['files'] as $file) {
					$this->addJs($file);
				}
			}
		}
		return true;
	}
	public function _getCache(){
		foreach ($this->collections as $collection_name => $files) {
			if($rand = $this->cache->get('assets.' . $collection_name)){
				$this->collection($collection_name);
				if($files['type'] === 'css'){
					$this->addCss($files['uri'] . '?r=' . $rand);
				}else{
					$this->addJs($files['uri'] . '?r=' . $rand);
				}
			}elseif(isset($files['path']) && !file_exists($files['path'])){
				$this->gen($collection_name, $files);
			}elseif(isset($files['files'])){
				$rand = filemtime($files['path']);
				$this->cache->save('assets.' . $collection_name, $rand);
				$this->collection($collection_name);
				if($files['type'] === 'css'){
					$this->addCss($files['uri'] . '?r=' . $rand);
				}else{
					$this->addJs($files['uri'] . '?r=' . $rand);
				}
			}else{
				$this->collection($collection_name);
			}
		}
		return true;
	}
	public function _getGenerated(){
		foreach ($this->collections as $collection_name => $files) {
			$this->gen($collection_name, $files);
		}
		return true;
	}
	public function _output(){
		foreach ($this->collections as $collection_name => $files) {
			if($files['type'] === 'css'){
				$this->outputCss($collection_name);
			}else{
				$this->outputJs($collection_name);
			}
		}
	}
	private function gen($collection_name, $files){
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
	}
}
