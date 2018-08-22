<?php
namespace Library;
class Admin extends Bootstrap{
	public function run(){
		$this->di = new \Phalcon\Di\FactoryDefault();
		$this->initLoader();
		$this->initConfig();
		$this->initCache();
		$this->initRouter([
			'module' => 'site',
			'controller' => 'site',
			'action' => 'list',
		]);

		$this->initResponse();
		$this->initRequest();
		$this->initDB();
		$this->initSession();
		$this->initDispatcher();
		$this->initFlash();
		$this->initView();
        $this->initModules();
		$this->initAssets();
		$response = $this->dispatch();
		$response->send();
	}
	protected function dispatch(){
		$router = $this->di->get('router');
		$router->handle();
		$view = $this->di->get('view');
		$dispatcher = $this->di->get('dispatcher');
		$response = $this->di->get('response');
		$dispatcher->setControllerSuffix('Admin');
		$dispatcher->setModuleName($router->getModuleName());
		$dispatcher->setControllerName($router->getControllerName());
		$dispatcher->setActionName($router->getActionName());
		$dispatcher->setParams($router->getParams());
		$module = ucfirst(str_replace('admin', '', $router->getControllerName()));
		$dispatcher->setDefaultNamespace('Modules\\' . $module);
		$view->setViewsDir(MODULES_PATH . $module);
		$view->pick(MODULES_PATH
			. $module
			. '/view/admin.'
			. $router->getModuleName()
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
