<?php
namespace Library;
class Router extends \Phalcon\Mvc\Router{
	function __construct($config){
		$this->setDefaultModule($config['module']);
		$this->setDefaultController($config['controller']);
		$this->setDefaultAction($config['action']);
		$this->add('/:module/:controller/:action/:params', ['module' => 1,'controller' => 2,'action' => 3,'params' => 4])->setName('default');
		$this->add('/:module/:controller', ['module' => 1,'controller' => 2,'action' => 'index',])->setName('default');
		$this->add('/:module', ['module' => 1,'controller' => 'index','action' => 'index',])->setName('default');
		$this->add('/assets/([\w.-]+)',  ['controller' => 'site', 'action' => 'clearasset', 'collection' => 1]);
	}
}
