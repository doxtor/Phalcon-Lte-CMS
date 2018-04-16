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
		$this->registerNamespaces();
		$this->initCache();
		$this->initRouter();
		$this->initResponse();
		$this->initRequest();
		$this->initDB();
		$this->initLogger();
		$this->initErrorHandler();
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
		define('MODULES_PATH', BASE_PATH . '/modules/');
		define('VIEWS_PATH', BASE_PATH . '/views/site/');
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
		$dispatcher->setDefaultNamespace(ucfirst($router->getModuleName())."\Controller");
		$response = $this->di->get('response');
		$config = $this->di->get('config');
		$view->setViewsDir(MODULES_PATH . $router->getModuleName() . '/Views/');
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
	protected function initLoader()
	{
		require BASE_PATH . '/vendor/autoload.php';
	}
	protected function initConfig()
	{
		$this->di->set('config', function (){
			return include BASE_PATH . "/config.php";
		});
	}
	protected function registerNamespaces(){
		$loader = new \Phalcon\Loader();
		$modules = ['content', 'admin', 'users'];
		foreach ($modules as $module) {
			$nameSpaces[ucfirst($module)] = MODULES_PATH .$module;
		}
		$loader->registerNamespaces($nameSpaces, true);
		$loader->register();
	}
	protected function initErrorHandler(){
		new ErrorHandler();
	}
	public function initCache(){
		$config = $this->di->getShared('config')->get('redis');
		$this->di->setShared('cache', function() use ($config) {
			return new Cache($config);
		});
	}
	protected function initRouter()
	{
		$this->di->setShared("router", function () {
			return new Router();
		});
	}
	protected function initLogger()
	{
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
		$this->di->setShared('url', function () {
			return new \Phalcon\Mvc\Url();
		});
		$this->di->setShared('tag', function () {
			return new \Phalcon\Tag();
		});
		$this->di->setShared('escaper', function () {
			return new \Phalcon\Escaper();
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
			$assets = new Assets();
			$assets->_setCache($cache);
			$assets->_getCache();
			return $assets;
		});
	}
}
