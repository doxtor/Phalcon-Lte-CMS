<?php
define('BASE_PATH', dirname(__FILE__));
include BASE_PATH . '/Bootstrap.php';
class Api extends Bootstrap
{
	public function run()
	{
        $this->di = new \Phalcon\Di\FactoryDefault();
		$this->initLoader();
		$this->initConfig();
		$this->registerNamespaces();
		$this->initCache();
		$this->initRouter();
		$this->initAcl();
		$this->initResponse();
		$this->initRequest();
		$this->initDB();
		$this->initLogger();
		$this->initErrorHandler();
		$this->initSession();
		$this->initDispatcher();
		$this->initFlash();
		$response = $this->dispatch();
		$response->send();
	}
	protected function dispatch()
	{
		$router = $this->di->get('router');
		$router->handle();
		$dispatcher = $this->di->get('dispatcher');
		$response = $this->di->get('response');
		$response->setContentType('application/json', 'UTF-8');
		/*$access = $this->di->get('access');
		if(!$access->haveAccess()){
			$dispatcher->setControllerName('user');
			$dispatcher->setActionName('login');
		}else{
			$dispatcher->setControllerName($router->getControllerName());
			$dispatcher->setActionName(
					$router->getActionName() ? $router->getActionName() : 'index'
				);
			$dispatcher->setParams($router->getParams());
		}*/
		$dispatcher->dispatch();
		return $response;
	}
}
