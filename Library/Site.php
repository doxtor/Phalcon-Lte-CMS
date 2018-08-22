<?php
namespace Library;
class Site extends Bootstrap{
	public function run(){
		$this->di = new \Phalcon\Di\FactoryDefault();
		$this->initLoader();
		$this->initConfig();
		$this->initCache();
		$this->initRouter([
			'module' => 'site',
			'controller' => 'site',
			'action' => 'index',
		]);
		$this->initModules();
		$this->initResponse();
		$this->initRequest();
		$this->initDB();
		$this->initSession();
		$this->initDispatcher();
		$this->initFlash();
		$this->initView();
		$this->initAssets();
		$response = $this->dispatch();
		$response->send();
	}
	protected function dispatch(){
		$view = $this->di->get('view');
		$dispatcher = $this->di->get('dispatcher');
		$response = $this->di->get('response');
		$router = $this->di->getShared('router');
		$modules = $this->di->getShared('modules');
		foreach ($modules as $module) {
			if(class_exists('Modules\\' . $module .'\Router')){
				$class_name = 'Modules\\' . $module .'\Router';
				$router = (new $class_name())->add($router);
			}
		}

		$router->handle();
		$dispatcher->setModuleName($router->getModuleName());
		$dispatcher->setControllerName($router->getControllerName());
		$dispatcher->setActionName($router->getActionName());
		$dispatcher->setParams($router->getParams());
		$module = ucfirst($router->getModuleName());
		$dispatcher->setDefaultNamespace('Modules\\' . $module);

		$view->setViewsDir(MODULES_PATH . $module);
		$view->pick(MODULES_PATH
			. $module
			. '/view/site.' . $router->getModuleName()
			. '.' . $router->getActionName());
		try {
			$debug = new \Phalcon\Debug();
			$debug->listen();
			$dispatcher->dispatch();
		} catch (\Phalcon\Exception $e) {
			$view->start();
			$view->setPartialsDir('');
			$view->setViewsDir(BASE_PATH . '/views/');
			if ($e instanceof \Phalcon\Mvc\Dispatcher\Exception) {
				$view->e = $e;
				$response->setStatusCode(404, 'Not Found');
				$view->partial(BASE_PATH . '/views/error/show404');
			} else {
				$response->setStatusCode(503, 'Service Unavailable');
				$view->partial(BASE_PATH . '/views/error/show503');
			}
			return $response;
		}
		$request = $this->di->get('request');
		if(!$request->isAjax()) {
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
