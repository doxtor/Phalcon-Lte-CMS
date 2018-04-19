<?php
namespace Library;
use Phalcon\Http\Request;
use Library\Model\Rewrite;
class Router extends \Phalcon\Mvc\Router{
	function __construct($config){
		$this->setDefaultController($config['controller']);
		$this->setDefaultAction($config['action']);
		$this->add('/:controller',                 ['controller' => 2,      'action' => 'index'         ])->setName('default');
		$this->add('/:controller/:action',         ['controller' => 2,      'action' => 3               ])->setName('default');
		$this->add('/:controller/:action/:params', ['controller' => 2,      'action' => 3, 'params' => 4])->setName('default');

		$this->add('/assets/([\w.-]+)',  ['controller' => 'site', 'action' => 'clearasset', 'collection' => 1]);
	}
}
