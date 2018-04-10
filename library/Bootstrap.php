<?php
namespace Library;
use Phalcon\Mvc\Application;
class Bootstrap extends Application{
	public $di = null;
	public function run(){
		define('VIEWS_PATH', BASE_PATH . '/views/');
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
		$this->initView();
		$response = $this->dispatch();
		$response->send();
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
		/*$access = $this->di->get('acl');
		if(!$access->haveAccess()){
			$dispatcher->setControllerName('user');
			$dispatcher->setActionName('login');
		}else{
			$dispatcher->setControllerName($router->getControllerName());
			$dispatcher->setActionName($router->getActionName() ? $router->getActionName() : 'index');
			$dispatcher->setParams($router->getParams());
		}*/
		//$view->setLayout('list');
		//echo $view->getLayout();
		$view->setViewsDir(BASE_PATH . '/modules/' . $router->getModuleName() . '/views/');

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
		$modules = ['content', 'admin', 'user'];
		$nameSpaces = ['Library' => BASE_PATH . '/library/'];
		foreach ($modules as $module) {
			$name = ucfirst($module);
			$nameSpaces[$name] = BASE_PATH.'/modules/'.$module;
			$nameSpaces[$name.'\Controller'] = BASE_PATH.'/modules/'.$module.'/controller/';
			$nameSpaces[$name.'\Model'] = BASE_PATH.'/modules/'.$module.'/model/';
			$nameSpaces[$name.'\Form'] = BASE_PATH.'/modules/'.$module.'/form/';
		}
		$loader->registerNamespaces($nameSpaces, true);
		$loader->register();
	}
	protected function initErrorHandler()
	{
		new \Library\ErrorHandler();
	}
	protected function initAcl(){
		//(new \Library\Acl($this->di))->init();
	}
	public function initCache(){
		$config = $this->di->getShared('config')->get('redis');
		$this->di->setShared('cache', function() use ($config) {
			return new \Library\Cache($config);
		});
	}
	protected function initRouter()
	{
		$this->di->setShared("router", function () {
			return new \Library\Router();
		});
	}
	protected function initLogger()
	{
		$this->di->setShared('logger', function () {
			return new \Library\Logger();
		});
	}
	protected function initResponse(){
		$this->di->setShared('response',function () {
			return new \Library\Response();
		});
	}

	protected function initDispatcher(){
		$this->di->setShared('dispatcher', function() {
			return new \Library\Dispatcher();
		});
	}
	protected function initRequest(){
		$this->di->setShared('request',function () {
			return new \Library\Request();
		});
	}
	protected function initFlash(){
		$this->di->setShared('flash', function(){
			return new \Library\Flash();
		});
	}
	protected function initSession(){
		$config = $this->di->getShared('config')->get('redis');
		$this->di->setShared('session', function() use ($config){
			return new \Library\Session($config);
		});
	}
	protected function initDB(){
		$config = $this->di->getShared('config')->get('db');
		$this->di->setShared('db', function() use ($config){
			return new \Library\DB($config);
		});
		$config = $this->di->getShared('config')->get('redis');
		$this->di->setShared('modelsMetadata', function() use ($config){
			return new \Library\modelsMetadata($config);
		});
		$this->di->setShared('modelsCache', function() use ($config){
			return new \Library\modelsCache($config);
		});
	}
	protected function initView($client = 'site'){
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
			return new \Library\View();
		});
		$view = $this->di->get('view'); $di = $this->di;
		$this->di->setShared('volt', function ($view, $di) {
			return new \Library\Volt($view, $di);
		});
	}
}
