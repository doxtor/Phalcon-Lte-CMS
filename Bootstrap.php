<?php
use Phalcon\DI;
use Phalcon\Loader;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Http\Response;
use Phalcon\Http\Request;
use Phalcon\Mvc\View;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Mvc\Application;
use Phalcon\Logger\Formatter\Line;
use Phalcon\Logger\Adapter\File;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Mvc\Model\Manager as ModelsManager;
use Phalcon\Mvc\Model\MetaData\Redis as MetaData;
use Phalcon\Cache\Frontend\Data;
use Phalcon\Cache\Backend\Redis;

use Library\Acl, Library\Logger, Library\Cache;
class Bootstrap extends Application{
	public $di = null;
	public function run()
	{
		$this->di = new DI();
		$this->initLoader();
		$this->initConfig();
		$this->registerNamespaces();
		$this->initCache();
		$this->initRoutes();
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
		$response = $this->dispatch($this->di);
		$response->send();
	}
	/**
	* Initializes the autoloader
	*/
	protected function initLoader()
	{
		require APP_PATH . '/vendor/autoload.php';
	}
	/**
	* Initializes the Config container
	*/
	protected function initConfig()
	{
		$this->di->setShared('config', function (){
			return include APP_PATH . "/config.php";
		});
	}
	protected function registerNamespaces(){
		$config = $this->di->getShared('config');
		$loader = new Loader();
		$loader->registerNamespaces([
			'Controller' => APP_PATH . '/controllers/',
			'Model' => APP_PATH . '/models/',
			'Form' => APP_PATH . '/forms/',
			'Library' => APP_PATH . '/library/'
		]);
		$loader->register();
	}
	protected function initAcl(){
		$this->di->set('access', new Acl($this->di));
	}
	/**
	* Sets cache settings
	*/
	public function initCache(){
		$config = $this->di->getShared('config');
		$this->di->setShared('cache', function() use ($config) {
			return new Cache($config->get('redis'));
		});
	}
	/**
	 * Initializes the routes
	 */
	protected function initRoutes()
	{
		$this->di->setShared("router", function () {
			$router = new \Phalcon\Mvc\Router();
			$router->setDefaultController('index');
			$router->add('/:controller/:action',         ['controller' => 1,'action' => 2]);
			$router->add('/:controller/:action/:params', ['controller' => 1,'action' => 2, 'params' => 3]);
			return $router;
		});
	}
	/**
	 * Initializes the loggers
	 */
	protected function initLogger()
	{
		$config   = $this->di->getShared('config');
		$this->di->setShared('logger', function () {
			return new Logger();
		});
	}
	/**
	* Initializes the error handlers
	*/
	protected function initErrorHandler()
	{
		$config   = $this->di->getShared('config');
		$logger   = $this->di->getShared('logger');

		ini_set('display_errors',$config->get('debug')->get('error_reporting'));
		error_reporting(E_ALL);

		set_error_handler(
			function ($errorNumber, $errorString, $errorFile, $errorLine) use ($logger) {
				if (0 === $errorNumber & 0 === error_reporting()) {
					return;
				}
				$logger->error(
					sprintf("[%s] [%s] %s - %s",
					$errorNumber, $errorLine, $errorString, $errorFile)
				);
			}
		);

		set_exception_handler(
			function () use ($logger) {
				$logger->error(json_encode(debug_backtrace()));
			}
		);
	}
	/**
	* Initializes the Response
	*/
	protected function initResponse()
	{
		$this->di->setShared("response",function () {
			return new Response();
		});
	}
	/**
	* dispatch
	* @param FactoryDefault $di
	* @return mixed
	*/
	public function dispatch()
	{
		$router = $this->di->get('router');
		$router->handle();
		$view = $this->di->get('view');
		$dispatcher = $this->di->get('dispatcher');
		$response = $this->di->get('response');
		$config = $this->di->get('config');
		$access = $this->di->get('access');
		if(!$access->haveAccess()){
			echo 'da';
			exit();
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
					$view->partial(APP_PATH . '/views/error/show404');
				} else {
					$response->setStatusCode(503, 'Service Unavailable');
					$view->partial(APP_PATH . '/views/error/show503');
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
	/**
	* Initializes the Dispatcher
	*/
	protected function initDispatcher()
	{
		$dispatcher = new Dispatcher();
		$dispatcher->setDefaultNamespace("Controller");
		$config = $this->di->getShared('config');
		if($config->get('debug')->get('profiler')){
			$eventsManager = new EventsManager();
			$profiler = new \Phalcon\Db\Profiler();
			$this->di->set('profiler', $profiler);
			$eventsManager->attach('db', function ($event, $db) use ($profiler) {
			    if ($event->getType() == 'beforeQuery') {
				   $profiler->startProfile($db->getSQLStatement());
			    }
			    if ($event->getType() == 'afterQuery') {
				   $profiler->stopProfile();
			    }
			});
			$db = $this->di->get('db');
			$db->setEventsManager($eventsManager);
			$halls = $this->di->get('halls');
			$halls->setEventsManager($eventsManager);
		}
		$this->di->setShared("dispatcher",$dispatcher);
	}
	/**
	* Initializes the Http\Request
	*/
	protected function initRequest()
	{
		$this->di->setShared("request",function () {
			return new Request();
		});
	}

	/**
	* Initializes the View
	*/
	protected function initView()
	{
		$this->di->setShared('url', function () {
			return new \Phalcon\Mvc\Url();
		});
		$this->di->setShared('tag', function () {
			return new \Phalcon\Tag();
		});
		$this->di->setShared('escaper', function () {
			return new \Phalcon\Escaper();
		});

		$config = $this->di->getShared('config');
		$this->di->setShared("view",function () use ($config){
			$view = new \Phalcon\Mvc\View();
			$view->setViewsDir(APP_PATH . '/views/');

			$view->registerEngines(['.volt' => function ($view, $di) use ($config){

				$volt = new \Phalcon\Mvc\View\Engine\Volt($view, $di);
				$volt->setOptions([
					'compiledPath'      => APP_PATH . '/cache/',
					'compiledSeparator' => '_',
					'compiledExtension' => '.php',
					'compileAlways'     => $config->get('debug')->get('compilevolt'),
					'stat'              => true,
				]);
				return $volt;
			}]);
			return $view;
		});
	}
	/**
	* Initializes the DB
	*/
	protected function initDB()
	{
		$config = $this->di->getShared('config');
		$this->di->setShared("db",function () use ($config){
			return new Mysql([
				"host"     => $config->get('db')->get('host'),
				"username" => $config->get('db')->get('username'),
				"password" => $config->get('db')->get('password'),
				"dbname"   => $config->get('db')->get('dbname'),
				"options" => array(
					\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
				)
			]);}
		);
		// Registering the Models-Metadata
		$this->di->setShared('modelsMetadata',function () use ($config) {
			$cacheFrontend = new Data([
				'lifetime' => $config->get('redis')->get('lifetime'),
			]);
			$options = [
				'host'       => $config->get('redis')->get('host'),
				'port'       => $config->get('redis')->get('port'),
				'persistent' => $config->get('redis')->get('persistent'),
				'statsKey'   => $config->get('redis')->get('statsKey'),
				'lifetime'   => $config->get('redis')->get('lifetime'),
				'prefix'     => $config->get('redis')->get('prefix'),
			];
			$metadata = new MetaData( $options);
			return $metadata;
		});
		$this->di->setShared('modelsCache',function() use ($config) {
			$cacheFrontend = new Data([
				'lifetime' => $config->get('redis')->get('lifetime'),
			]);
			$options = [
				'host'       => $config->get('redis')->get('host'),
				'port'       => $config->get('redis')->get('port'),
				'persistent' => $config->get('redis')->get('persistent'),
				'statsKey'   => $config->get('redis')->get('statsKey'),
				'lifetime'   => $config->get('redis')->get('lifetime'),
				'prefix'     => $config->get('redis')->get('prefix'),
			];
			return new Redis($cacheFrontend, $options);
		});
		$this->di->setShared('modelsManager',function() {
			return new ModelsManager();
		});

	}
	/**
	* Initializes the session
	*/
	protected function initSession()
	{
		$config = $this->di->getShared('config')->get('redis');
		$this->di->setShared("session",function () use ($config) {
			$options = [
				'host'       => $config->get('host'),
				'port'       => $config->get('port'),
				'persistent' => $config->get('persistent'),
				'lifetime'   => $config->get('lifetime'),
				'prefix'     => $config->get('prefix'),
			];
			$session = new \Phalcon\Session\Adapter\Redis($options);
			$session->start();
			return $session;
		});
	}
	/**
	* Init flash component
	*/
	public function initFlash() {
		$this->di->setShared('flash', function(){
			$flash = new \Phalcon\Flash\Session();
			$flash->setCssClasses([
				"error"   => "alert alert-danger hidden",
				"success" => "alert alert-success hidden",
				"notice"  => "alert alert-info hidden",
				"warning" => "alert alert-warning hidden",
				]);
			return $flash;
		});
	}
}
