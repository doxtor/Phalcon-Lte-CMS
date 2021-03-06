<?php
namespace Library;
class Controller extends \Phalcon\Mvc\Controller{
	public function setTitle($title = null){
		$this->tag->setTitle($title);
	}
	public function forward($param){
		$this->dispatcher->setModuleName($param['module']);
		$this->view->pick(MODULES_PATH
			. ucfirst($param['module'])
			. '/view/' . CLIENT
			. '.' . $param['controller']
			. '.' . $param['action']);
		return $this->dispatcher->forward([
			'namespace'     => 'Modules\\' . ucfirst($param['controller']),
			'controller' => $param['controller'],
			'action' => ($param['action'] ?? 'index'),
			'params' => ($param['params'] ?? []),
		]);
	}
	public function _list(){
		
	}
}
