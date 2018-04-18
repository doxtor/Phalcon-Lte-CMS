<?php
namespace Library;
use Phalcon\Http\Request;
use Library\Model\Rewrite;
class Router extends \Phalcon\Mvc\Router{
	function __construct($config){
		$this->setDefaultModule($config['module']);
		$this->setDefaultController($config['controller']);
		$this->setDefaultAction($config['action']);
		$this->add('/:module',                             ['module' => 1, 'controller' => 'index','action' => 'index'         ])->setName('default');
		$this->add('/:module/:controller',                 ['module' => 1, 'controller' => 2,      'action' => 'index'         ])->setName('default');
		$this->add('/:module/:controller/:action',         ['module' => 1, 'controller' => 2,      'action' => 3               ])->setName('default');
		$this->add('/:module/:controller/:action/:params', ['module' => 1, 'controller' => 2,      'action' => 3, 'params' => 4])->setName('default');
	}
	public function handle($uri = null){
		$uri = $uri ?? $this->getRewriteUri();
		/*if($rewrite = Rewrite::findFirst([
			'rewrite = :rewrite:',
			'bind' => ['rewrite' => $uri]])){
			$this->add($uri, [
				'module' => $rewrite->module,
				'controller' => $rewrite->controller,
				'action' => $rewrite->action
			])->setName('default');
		}*/
		parent::handle();
	}
}
