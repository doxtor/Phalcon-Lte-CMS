<?php
namespace Library;
class Dispatcher extends \Phalcon\Mvc\User\Component{
	public function init(){

	}
	public function _dispatch(){
		$router = $this->di->get('router');
		$router->handle();
		$view = $this->di->get('view');
		$dispatcher = $this->di->get('dispatcher');
		$response = $this->di->get('response');
		$config = $this->di->get('config');
		$access = $this->di->get('access');
		if(!$access->haveAccess()){
			$dispatcher->setControllerName('user');
			$dispatcher->setActionName('login');
		}else{
			$dispatcher->setControllerName($router->getControllerName());
			$dispatcher->setActionName(
					$router->getActionName() ? $router->getActionName() : 'index'
				);
			$dispatcher->setParams($router->getParams());
		}
		if ($config->get('debug')->get('enable')) {
			error_reporting($config->get('debug')->get('error_reporting'));
			$debug = new \Phalcon\Debug();
			$debug->listen();
			$dispatcher->dispatch();
		} else {
			try {
				$dispatcher->dispatch();
			} catch (\Phalcon\Exception $e) {
				$view->start();
					$view->e = $e;
				if ($e instanceof \Phalcon\Mvc\Dispatcher\Exception) {
					$response->setStatusCode(404, 'Not Found');
					$view->partial(BASE_PATH . '/views/error/show404');
				} else {
					$response->setStatusCode(503, 'Service Unavailable');
					$view->partial(BASE_PATH . '/views/error/show503');
				}
				return $response;
			}
		}

		$request = $this->di->get('request');
		if (!$request->getQuery('_ajax')) {
			$view->start();
			$view->render(
				$dispatcher->getControllerName(),
				$dispatcher->getActionName(),
				$dispatcher->getParams()
			);
			$view->finish();
			$response->setContent($view->getContent());
		}
		return $response;
	}
}
