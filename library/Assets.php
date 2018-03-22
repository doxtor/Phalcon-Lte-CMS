<?php
namespace Library;

use Phalcon\Assets\Manager;
use Phalcon\Assets\Filters\{Cssmin, Jsmin};
class Assets extends Manager{
	private $cache =  null;

	/**
	 * Задать обект кеша. Для дальнейшего работы с ним.
	 * @param $cache
	 */
	public function _setCache($cache){
		$this->cache = $cache;
	}

	/**
	 * Подключить все assets которые есть в масиве.
	 * @param $assets
	 * @return bool
	 */
	public function _getIncludeAll($assets){
		if(!file_exists($assets)) return false;
		$collections = include $assets;
		foreach ($collections as $collection => $files) {
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

	/**
	 * Подключить все assets которые есть в масиве.
	 * Если они уже подключены то вернуть кеш.
	 * @param $assets
	 * @return bool
	 */
	public function _getCache($assets){
		if(!file_exists($assets)) return false;
		$collections = include $assets;
		foreach ($collections as $collection_name => $files) {
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

	/**
	 * @param $assets
	 * @return bool
	 */
	public function _getGenerated($assets){
		if(!file_exists($assets)) return false;
		$collections = include $assets;
		foreach ($collections as $collection_name => $files) {
			$this->gen($collection_name, $files);
		}
		return true;
	}

	/**
	 * @param $assets
	 * @return bool
	 */
	public function _output($assets){
		if(!file_exists($assets)) return false;
		$collections = include $assets;
		foreach ($collections as $collection_name => $files) {
			if($files['type'] === 'css'){
				$this->outputCss($collection_name);
			}else{
				$this->outputJs($collection_name);
			}
		}
	}

	/**
	 * @param $collection_name
	 * @param $files
	 */
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
