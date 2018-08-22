<?php
namespace Library;
use Phalcon\Mvc\Application;
class Bootstrap extends Application{
	public $di = null;
	protected function initLoader(){
		require BASE_PATH . '/vendor/autoload.php';
	}
	protected function initConfig(){
		$this->di->set('config', function (){
			return include BASE_PATH . '/config.php';
		});
	}
	public function initCache(){
		$config = $this->di->getShared('config')->get('redis');
		$this->di->setShared('cache', function() use ($config) {
			return new Cache($config);
		});
	}
	protected function initRouter($config){
		$this->di->setShared('router', function () use($config) {
			return new Router($config);
		});
	}
	protected function initModules(){
		$this->di->setShared('modules', function(){
            $modules = [];
            $controller = CLIENT === 'site' ? 'Controller': CLIENT === 'admin' ? 'Admin' : '';
            $folders = scandir(MODULES_PATH);
            foreach ($folders as $folder){
                if($folder !== '.'
                    && $folder !== '..'
                    && is_dir(MODULES_PATH . $folder)
                    && class_exists(
                        'Modules\\'
                        . $folder . '\\'
                        . $folder . $controller)
                ){
                    $modules[$folder] = $folder;
                }
            }
		    return $modules;
		});
	}
	protected function initResponse(){
		$this->di->setShared('response',function () {
			return new \Phalcon\Http\Response();
		});
	}
	protected function initDispatcher(){
		$this->di->setShared('dispatcher', function() {
			return new \Phalcon\Mvc\Dispatcher();
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
			return new ModelsMetadata($config);
		});
		$this->di->setShared('modelsCache', function() use ($config){
			return new ModelsCache($config);
		});
	}
	protected function initView(){
		$this->di->setShared('tag', function () {
			return new Tag();
		});
		$this->di->setShared('view', function () {
			return new View();
		});
		$this->di->setShared('volt', function ($view, $di) {
			return new Volt($view, $di);
		});
	}
	protected function initAssets(){
		$config = $this->di->getShared('config')->get('redis');
		$this->di->setShared('assets', function () use ($config) {
			return new Assets($config);
		});
	}
}
