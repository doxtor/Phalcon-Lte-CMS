<?php
namespace Library;
class Controller extends \Phalcon\Mvc\Controller{
	public function setTitle($title = null){
		$this->tag->setTitle($title);
	}
	public function forward($param){
		$this->view->pick(MODULES_PATH . $param['controller'] . '/view/site.' . $param['action']);
		return $this->dispatcher->forward([
			'namespace'     => 'Modules\\' . $param['controller'],
			'controller' => $param['controller'],
			'action' => $param['action'],
			'params' => $param['params'],
		]);
	}
}
