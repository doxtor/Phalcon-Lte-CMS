<?php
namespace Modules\Site;
use Modules\Site\Model\Site;
use Phalcon\Paginator\Adapter\QueryBuilder as PaginatorQueryBuilder;
class SiteController extends \Library\Controller{
	public function indexAction(){
		$site = Site::findFirst([
			'rewrite = :rewrite: AND trash = "0"',
			'bind' => ['rewrite' => $this->router->getRewriteUri()],
		]);
		$this->tag->setTitle($site->name);
		$this->tag->setDescription($site->description);
		$this->tag->setBackground($site->bg_image);
		if(isset($site->module)){
			$this->tag->setDescription($site->description);
			$this->tag->setKeywords($site->keywords);
			return $this->forward([
				'controller' => $site->controller,
				'action' => $site->action,
				'params' => json_decode($site->params),
			]);
		}else{
			$this->view->site = $site;
		}
	}
	public function clearcacheAction(){
		$prefix = $this->config->get('redis')->get('prefix');
		$keys = $this->cache->queryKeys($prefix);
		if($this->request->getQuery('clear')){
			foreach ($keys as $key) {
				$key = str_replace($prefix,'',$key);
				$this->cache->delete($key);
			}
			$dir = APP_PATH.'/public/assets/';
			$assets = scandir($dir);
			foreach ($assets as $asset) {
				if($asset != '..' && $asset != '.' && $asset != '.gitignore'){
					unlink($dir.$asset);
				}
			}
			$this->response->redirect('admin');
		}
		$values = [];
		foreach ($keys as $key) {
			$key = str_replace($prefix,'',$key);
			$value = $this->cache->get($key);
			$values[$key] = substr(print_r($value,true),0,500).'...';
		}
		$this->view->keys = $keys;
		$this->view->values = $values;
	}
}
