<?php
namespace Library;
class Controller extends \Phalcon\Mvc\Controller{
	public function setTitle($title = null){
		$this->tag->setTitle($title);
	}
	public function forward($param){
		$this->view->pick(MODULES_PATH
			. ucfirst($param['module'])
			. '/view/site.' . $param['controller']
			. '.' . $param['action']);
		return $this->dispatcher->forward([
			'namespace'     => 'Modules\\' . ucfirst($param['controller']),
			'controller' => $param['controller'],
			'action' => $param['action'],
			'params' => $param['params'],
		]);
	}
}
