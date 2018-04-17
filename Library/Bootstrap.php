<?php
namespace Library;
use Phalcon\Mvc\Application;
class Bootstrap extends Application{
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
		define('VIEWS_PATH', BASE_PATH . '/Views/site/');
		define('CACHE_PATH', BASE_PATH . '/cache/');
		define('ASSETS_PATH', BASE_PATH . '/public/assets/');
		define('ASSETS_URL', 'assets/');
	}
	protected function dispatch(){
		$router = $this->di->get('router');
		$view = $this->di->get('view');
		$dispatcher = $this->di->get('dispatcher');
		$response = $this->di->get('response');
		$config = $this->di->get('config');

		$router->handle();
		$dispatcher->setModuleName($router->getModuleName());
		$dispatcher->setControllerName($router->getControllerName());
		$dispatcher->setActionName($router->getActionName());
		$dispatcher->setParams($router->getParams());
		$dispatcher->setDefaultNamespace('Modules\\'.ucfirst($router->getModuleName())."\Controller");

		$view->setViewsDir(MODULES_PATH . ucfirst($router->getModuleName()) . '/Views/');
		try {
			$debug = new \Phalcon\Debug();
			$debug->listen();
			$dispatcher->dispatch();
		} catch (\Phalcon\Exception $e) {
			$view->start();
			$view->setPartialsDir('');
			$view->setViewsDir(BASE_PATH . '/Views/');

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
	protected function initLoader(){
		require BASE_PATH . '/vendor/autoload.php';
	}
	protected function initConfig(){
		$this->di->set('config', function (){
			return include BASE_PATH . "/config.php";
		});
	}
	public function initCache(){
		$config = $this->di->getShared('config')->get('redis');
		$this->di->setShared('cache', function() use ($config) {
			return new Cache($config);
		});
	}
	protected function initRouter(){
		$this->di->setShared('router', function () {
			return new Router();
		});
	}
	protected function initLogger(){
		$this->di->setShared('logger', function () {
			return new Logger();
		});
	}
	protected function initResponse(){
		$this->di->setShared('response',function () {
			return new \Phalcon\Http\Response();
		});
	}
	protected function initDispatcher(){
		$this->di->setShared('dispatcher', function() {
			return new Dispatcher();
		});
	}
	protected function initRequest(){
		$this->di->setShared('request',function () {
			return new \Phalcon\Http\Request();
		});
	}
	protected function initFlash(){
		$this->di->setShared('flash', function(){
			return new Flash();
		});
	}
	protected function initSession(){
		$config = $this->di->getShared('config')->get('redis');
		$this->di->setShared('session', function() use ($config){
			return new Session($config);
		});
	}
	protected function initDB(){
		$config = $this->di->getShared('config')->get('db');
		$this->di->setShared('db', function() use ($config){
			return new DB($config);
		});
		$config = $this->di->getShared('config')->get('redis');
		$this->di->setShared('modelsMetadata', function() use ($config){
			return new modelsMetadata($config);
		});
		$this->di->setShared('modelsCache', function() use ($config){
			return new modelsCache($config);
		});
	}
	protected function initView(){
		$this->di->setShared('tag', function () {
			return new Tag();
		});
		$this->di->setShared('view', function () {
			return new View();
		});
		$view = $this->di->get('view'); $di = $this->di;
		$this->di->setShared('volt', function ($view, $di) {
			return new Volt($view, $di);
		});
	}
	protected function initAssets()
	{
		$cache = $this->di->getShared('cache');
		$this->di->setShared('assets', function () use ($cache) {
			$assets = new Assets($cache);
			$assets->_getCache();
			return $assets;
		});
	}
}
