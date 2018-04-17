<?php
namespace Library;
class Controller extends \Phalcon\Mvc\Controller{
	public function setTitle($title = null){
		$this->tag->setTitle($title);
	}
	public function getTitle(){
		return $this->tag->getTitle('');
	}
	public function forward($param){
		if(isset($param['module'])){
			$this->view->setViewsDir(MODULES_PATH . ucfirst($param['module']) . '/Views/');
			return $this->dispatcher->forward([
				'namespace'     => 'Modules\\' . ucfirst($param['module']) . '\Controller',
				'controller' => $param['controller'],
				'action' => $param['action'],
				'params' => $param['params'],
			]);
		}else{
			return $this->dispatcher->forward([
				'controller' => $param['controller'],
				'action' => $param['action'],
				'params' => $param['params'],
			]);
		}
	}
}
