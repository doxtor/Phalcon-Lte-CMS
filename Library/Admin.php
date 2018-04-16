<?php
namespace Library;
class Admin extends Bootstrap{
	public $di = null;
	public function run(){
		$this->di = new \Phalcon\Di\FactoryDefault();
		$this->initFolders();
		$this->initLoader();
		$this->initConfig();
		$this->initCache();
		$this->initRouter();
		$this->initResponse();
		$this->initRequest();
		$this->initDB();
		$this->initLogger();
		$this->initSession();
		$this->initDispatcher();
		$this->initFlash();
		$this->initView();
		$this->initAssets();
		$response = $this->dispatch();
		$response->send();
	}
	protected function initFolders()
	{
		define('VIEWS_PATH', BASE_PATH . '/Views/admin/');
		define('CACHE_PATH', BASE_PATH . '/cache/');
		define('ASSETS_PATH', BASE_PATH . '/public/assets/');
		define('ASSETS_URL', 'assets/');
	}
	protected function dispatch()
	{

		$router = $this->di->get('router');
		$router->handle();
		$view = $this->di->get('view');
		$dispatcher = $this->di->get('dispatcher');

		$dispatcher->setModuleName($router->getModuleName());
		$dispatcher->setControllerName($router->getControllerName());
		$dispatcher->setActionName($router->getActionName());
		$dispatcher->setParams($router->getParams());
		$dispatcher->setDefaultNamespace('Modules\\' . ucfirst($router->getModuleName())."\Admin");
		$response = $this->di->get('response');
		$config = $this->di->get('config');
		$view->setViewsDir(MODULES_PATH . ucfirst($router->getModuleName()) . '/Views/');
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
				$view->partial(BASE_PATH . '/Views/error/show404');
			} else {
				$response->setStatusCode(503, 'Service Unavailable');
				$view->partial(BASE_PATH . '/Views/error/show503');
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
